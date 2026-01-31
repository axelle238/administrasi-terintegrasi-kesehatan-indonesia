<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\RiwayatBarang;
use App\Models\Maintenance;
use App\Models\MutasiBarang;
use App\Models\PeminjamanBarang;
use App\Models\OpnameDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Url;

class Show extends Component
{
    public Barang $barang;
    
    #[Url(keep: true)]
    public $tabAktif = 'ringkasan'; // ringkasan, spesifikasi, keuangan, riwayat

    // Form Transaksi Stok Cepat
    public $jenis_transaksi = 'Masuk';
    public $jumlah;
    public $keterangan;
    public $tanggal_transaksi;

    public function mount(Barang $barang)
    {
        $this->barang = $barang->load(['kategori', 'ruangan', 'supplier']);
        $this->tanggal_transaksi = now()->format('Y-m-d');
        
        // Hitung Nilai Buku Real-time
        if ($this->barang->is_asset && $this->barang->masa_manfaat > 0) {
            $umur = now()->diffInYears($this->barang->tanggal_pengadaan);
            $biaya = $this->barang->harga_perolehan;
            $residu = $this->barang->nilai_residu;
            
            if ($this->barang->metode_penyusutan == 'Saldo Menurun') {
                // Implementasi Double Declining Balance sederhana
                // Rate = (100% / Umur) * 2
                // Disederhanakan untuk contoh
                $rate = (1 / $this->barang->masa_manfaat) * 2;
                $nilaiBuku = $biaya * pow((1 - $rate), $umur);
            } else {
                // Garis Lurus (Default)
                $penyusutanPerTahun = ($biaya - $residu) / $this->barang->masa_manfaat;
                $nilaiBuku = $biaya - ($penyusutanPerTahun * $umur);
            }
            
            $this->barang->nilai_buku = max($nilaiBuku, $residu);
        }
    }

    public function aturTab($tab)
    {
        $this->tabAktif = $tab;
    }

    public function simpanTransaksi()
    {
        $this->validate([
            'jenis_transaksi' => 'required|in:Masuk,Keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'tanggal_transaksi' => 'required|date'
        ]);

        if ($this->jenis_transaksi == 'Keluar' && $this->barang->stok < $this->jumlah) {
            $this->addError('jumlah', 'Stok tidak mencukupi untuk transaksi keluar.');
            return;
        }

        try {
            DB::beginTransaction();

            $stokBaru = $this->jenis_transaksi == 'Masuk' 
                ? $this->barang->stok + $this->jumlah 
                : $this->barang->stok - $this->jumlah;

            $this->barang->update(['stok' => $stokBaru]);

            RiwayatBarang::create([
                'barang_id' => $this->barang->id,
                'user_id' => auth()->id(),
                'jenis_transaksi' => $this->jenis_transaksi,
                'jumlah' => $this->jumlah,
                'stok_terakhir' => $stokBaru,
                'tanggal' => $this->tanggal_transaksi,
                'keterangan' => $this->keterangan
            ]);

            DB::commit();

            $this->reset(['jumlah', 'keterangan']);
            $this->tanggal_transaksi = now()->format('Y-m-d');
            
            $this->dispatch('notify', 'success', 'Transaksi berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal mencatat transaksi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $timeline = collect();

        if ($this->tabAktif == 'riwayat') {
            // Aggregasi Timeline hanya jika tab riwayat aktif untuk performa
            $riwayats = RiwayatBarang::where('barang_id', $this->barang->id)->with('user')->latest()->get();
            $maintenances = Maintenance::where('barang_id', $this->barang->id)->get();
            $mutasi = MutasiBarang::where('barang_id', $this->barang->id)->with(['ruanganAsal', 'ruanganTujuan'])->get();
            
            $timeline = $riwayats->map(fn($i) => ['type' => 'Stok', 'date' => $i->tanggal, 'data' => $i])
                ->concat($maintenances->map(fn($i) => ['type' => 'Maintenance', 'date' => $i->tanggal_maintenance, 'data' => $i]))
                ->concat($mutasi->map(fn($i) => ['type' => 'Mutasi', 'date' => $i->tanggal_mutasi, 'data' => $i]))
                ->sortByDesc('date');
        }

        return view('livewire.barang.show', [
            'timeline' => $timeline
        ])->layout('layouts.app', ['header' => 'Detail Aset Inventaris']);
    }
}