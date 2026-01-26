<?php

namespace App\Livewire\Kasir;

use App\Models\Pembayaran;
use App\Models\RekamMedis;
use App\Models\Antrean;
use App\Models\Setting;
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
    public $biayaAdministrasi = 10000;
    public $biayaTambahan = 0;
    public $diskon = 0;
    
    public $totalTagihan = 0;
    public $grandTotal = 0;
    
    public $metode_pembayaran = 'Tunai';
    public $jumlah_bayar = 0;
    public $kembalian = 0;
    public $catatan = '';

    // Toggle BPJS
    public $useBpjs = false;

    public function mount(RekamMedis $rekamMedis)
    {
        $this->rekamMedis = $rekamMedis;
        
        // Auto-detect BPJS availability
        if ($this->rekamMedis->pasien->no_bpjs && ($this->rekamMedis->jenis_pembayaran ?? 'Umum') != 'Umum') {
            $this->useBpjs = true;
            $this->metode_pembayaran = 'BPJS';
        }

        $this->calculateBill();
    }

    public function updatedUseBpjs()
    {
        if ($this->useBpjs) {
            $this->metode_pembayaran = 'BPJS';
        } else {
            $this->metode_pembayaran = 'Tunai';
        }
        $this->calculateBill();
    }

    public function updatedBiayaTambahan()
    {
        $this->calculateBill();
    }

    public function updatedDiskon()
    {
        $this->calculateBill();
    }

    public function setQuickAmount($amount)
    {
        if ($amount === 'pas') {
            $this->jumlah_bayar = $this->grandTotal;
        } else {
            $this->jumlah_bayar = $amount;
        }
        $this->updatedJumlahBayar();
    }

    public function calculateBill()
    {
        $this->detailsTindakan = [];
        $this->detailsObat = [];
        $this->totalTindakan = 0;
        $this->totalObat = 0;

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

        // 3. Kalkulasi Grand Total
        if ($this->useBpjs) {
            $this->biayaAdministrasi = 0;
            $this->totalTagihan = 0;
            $this->grandTotal = 0;
            $this->biayaTambahan = 0; // Reset biaya tambahan jika BPJS
            $this->diskon = 0;
        } else {
            // Jika Umum
            $this->biayaAdministrasi = (int) Setting::ambil('biaya_pendaftaran_umum', 10000);
            $this->totalTagihan = $this->totalTindakan + $this->totalObat + $this->biayaAdministrasi + (int)$this->biayaTambahan;
            $this->grandTotal = max(0, $this->totalTagihan - (int)$this->diskon);
        }

        $this->updatedJumlahBayar();
    }

    public function updatedJumlahBayar()
    {
        if ($this->grandTotal > 0) {
            $this->kembalian = (int)$this->jumlah_bayar - $this->grandTotal;
        } else {
            $this->kembalian = 0;
        }
    }

    public function processPayment()
    {
        if ($this->grandTotal > 0 && $this->metode_pembayaran == 'Tunai') {
            if ($this->jumlah_bayar < $this->grandTotal) {
                $this->dispatch('notify', 'error', 'Jumlah pembayaran kurang dari total tagihan.');
                return;
            }
        }

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
                'biaya_tambahan' => $this->biayaTambahan,
                'diskon' => $this->diskon,
                'total_tagihan' => $this->grandTotal,
                'metode_pembayaran' => $this->metode_pembayaran,
                'jumlah_bayar' => $this->jumlah_bayar,
                'kembalian' => max(0, $this->kembalian),
                'status' => 'Lunas',
                'catatan' => $this->catatan,
                'kasir_id' => Auth::id() ?? 1,
            ]);

            $antrean = Antrean::where('pasien_id', $this->rekamMedis->pasien_id)
                ->whereDate('tanggal_antrean', now())
                ->latest()
                ->first();
            
            if ($antrean) {
                $antrean->update(['status' => 'Selesai']);
            }

            DB::commit();

            $this->dispatch('notify', 'success', 'Pembayaran berhasil diproses.');
            
            return $this->redirect(route('kasir.print', $pembayaran->id), navigate: false);

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.kasir.process', [
            'pasien' => $this->rekamMedis->pasien
        ])->layout('layouts.app', ['header' => 'Proses Pembayaran']);
    }
}