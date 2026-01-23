<?php

namespace App\Livewire\Kasir;

use App\Models\Pembayaran;
use App\Models\RekamMedis;
use App\Models\Antrean;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Process extends Component
{
    public RekamMedis $rekamMedis;
    public $detailsTindakan = [];
    public $detailsObat = [];
    
    public $totalTindakan = 0;
    public $totalObat = 0;
    public $biayaAdministrasi = 10000; // Standar admin puskesmas
    public $totalTagihan = 0;
    
    public $metode_pembayaran = 'Tunai';
    public $jumlah_bayar = 0;
    public $kembalian = 0;

    public function mount(RekamMedis $rekamMedis)
    {
        $this->rekamMedis = $rekamMedis;
        $this->calculateBill();
    }

    public function calculateBill()
    {
        // 1. Hitung Biaya Tindakan
        foreach ($this->rekamMedis->tindakans as $tindakan) {
            $harga = $tindakan->pivot->biaya;
            $this->detailsTindakan[] = [
                'nama' => $tindakan->nama_tindakan,
                'biaya' => $harga
            ];
            $this->totalTindakan += $harga;
        }

        // 2. Hitung Biaya Obat
        foreach ($this->rekamMedis->obats as $obat) {
            $jumlah = $obat->pivot->jumlah;
            // Harga satuan bisa diambil dari obat langsung jika tidak disimpan di pivot
            // Idealnya harga dicatat saat transaksi untuk history yang akurat, tapi untuk sekarang pakai harga master
            $harga = $obat->harga_satuan; 
            $subtotal = $jumlah * $harga;
            
            $this->detailsObat[] = [
                'nama' => $obat->nama_obat,
                'jumlah' => $jumlah,
                'harga' => $harga,
                'subtotal' => $subtotal
            ];
            $this->totalObat += $subtotal;
        }

        // 3. Cek Penjamin (BPJS / Umum)
        $jenisPasien = $this->rekamMedis->jenis_pembayaran ?? 'Umum'; // Dari Rawat Inap atau default
        if ($this->rekamMedis->pasien->no_bpjs && $jenisPasien !== 'Umum') {
            $this->metode_pembayaran = 'BPJS';
            $this->biayaAdministrasi = 0;
            $this->totalTagihan = 0; // Ditanggung BPJS (Klaim Terpisah)
        } else {
            $this->totalTagihan = $this->totalTindakan + $this->totalObat + $this->biayaAdministrasi;
        }
    }

    public function updatedJumlahBayar()
    {
        if ($this->totalTagihan > 0) {
            $this->kembalian = (int)$this->jumlah_bayar - $this->totalTagihan;
        } else {
            $this->kembalian = 0;
        }
    }

    public function processPayment()
    {
        // Validasi pembayaran jika Tunai & Tagihan > 0
        if ($this->totalTagihan > 0 && $this->metode_pembayaran == 'Tunai') {
            if ($this->jumlah_bayar < $this->totalTagihan) {
                $this->dispatch('notify', 'error', 'Jumlah pembayaran kurang dari total tagihan.');
                return;
            }
        }

        // Cek duplikasi
        if (Pembayaran::where('rekam_medis_id', $this->rekamMedis->id)->where('status', 'Lunas')->exists()) {
            $this->dispatch('notify', 'error', 'Transaksi ini sudah lunas.');
            return $this->redirect(route('kasir.index'), navigate: true);
        }

        try {
            DB::beginTransaction();

            $pembayaran = Pembayaran::create([
                'no_transaksi' => 'INV-' . date('Ymd') . '-' . str_pad($this->rekamMedis->id, 4, '0', STR_PAD_LEFT),
                'rekam_medis_id' => $this->rekamMedis->id,
                'pasien_id' => $this->rekamMedis->pasien_id,
                'total_biaya_tindakan' => $this->totalTindakan,
                'total_biaya_obat' => $this->totalObat,
                'biaya_administrasi' => $this->biayaAdministrasi,
                'total_tagihan' => $this->totalTagihan,
                'metode_pembayaran' => $this->metode_pembayaran,
                'jumlah_bayar' => $this->jumlah_bayar,
                'kembalian' => max(0, $this->kembalian),
                'status' => 'Lunas',
                'kasir_id' => Auth::id() ?? 1, // Fallback if no auth (shouldn't happen)
            ]);

            // Update Status Antrean -> Selesai / Pulang
            $antrean = Antrean::where('pasien_id', $this->rekamMedis->pasien_id)
                ->whereDate('tanggal_antrean', now())
                ->latest()
                ->first();
            
            if ($antrean) {
                $antrean->update(['status' => 'Selesai']);
            }

            DB::commit();

            $this->dispatch('notify', 'success', 'Pembayaran berhasil diproses.');
            
            // Redirect ke Print Invoice
            return $this->redirect(route('kasir.print', $pembayaran->id), navigate: false); // Full reload for print usually better

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.kasir.process', [
            'pasien' => $this->rekamMedis->pasien
        ])->layout('layouts.app', ['header' => 'Billing & Pembayaran']);
    }
}
