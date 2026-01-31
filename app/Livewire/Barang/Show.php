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
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Barang $barang;
    
    // Transaction Form
    public $jenis_transaksi = 'Masuk';
    public $jumlah;
    public $keterangan;
    public $tanggal_transaksi;

    protected $rules = [
        'jenis_transaksi' => 'required|in:Masuk,Keluar',
        'jumlah' => 'required|integer|min:1',
        'keterangan' => 'nullable|string',
        'tanggal_transaksi' => 'required|date'
    ];

    public function mount(Barang $barang)
    {
        $this->barang = $barang;
        $this->tanggal_transaksi = now()->format('Y-m-d');
        
        // Calculate Nilai Buku (Depreciation) - Simple Straight Line
        if ($this->barang->is_asset && $this->barang->masa_manfaat > 0) {
            $age = now()->diffInYears($this->barang->tanggal_pengadaan);
            if ($age < $this->barang->masa_manfaat) {
                $depreciationPerYear = ($this->barang->harga_perolehan - $this->barang->nilai_residu) / $this->barang->masa_manfaat;
                $currentValue = $this->barang->harga_perolehan - ($depreciationPerYear * $age);
                $this->barang->nilai_buku = max($currentValue, $this->barang->nilai_residu);
            } else {
                $this->barang->nilai_buku = $this->barang->nilai_residu;
            }
        }
    }

    public function saveTransaksi()
    {
        $this->validate();

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
            $this->jenis_transaksi = 'Masuk';
            
            $this->dispatch('notify', 'success', 'Transaksi berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'error', 'Gagal mencatat transaksi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // 1. Riwayat Stok (Manual)
        $riwayats = RiwayatBarang::where('barang_id', $this->barang->id)
            ->with('user')
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Stok',
                    'date' => $item->tanggal,
                    'user' => $item->user->name ?? 'System',
                    'description' => $item->jenis_transaksi . " (" . $item->jumlah . ")",
                    'details' => $item->keterangan,
                    'icon' => 'archive-box',
                    'color' => $item->jenis_transaksi == 'Masuk' ? 'green' : 'red',
                    'original' => $item
                ];
            });

        // 2. Maintenance
        $maintenances = Maintenance::where('barang_id', $this->barang->id)
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Maintenance',
                    'date' => $item->tanggal_maintenance,
                    'user' => $item->teknisi ?? 'Vendor',
                    'description' => $item->jenis_kegiatan,
                    'details' => $item->keterangan . " (Biaya: Rp " . number_format($item->biaya) . ")",
                    'icon' => 'wrench-screwdriver',
                    'color' => 'amber',
                    'original' => $item
                ];
            });

        // 3. Mutasi
        $mutasi = MutasiBarang::where('barang_id', $this->barang->id)
            ->with(['ruanganAsal', 'ruanganTujuan'])
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Mutasi',
                    'date' => $item->tanggal_mutasi,
                    'user' => $item->penanggung_jawab,
                    'description' => 'Pindah Ruangan',
                    'details' => "Dari " . ($item->ruanganAsal->nama_ruangan ?? $item->lokasi_asal) . " ke " . ($item->ruanganTujuan->nama_ruangan ?? $item->lokasi_tujuan),
                    'icon' => 'truck',
                    'color' => 'blue',
                    'original' => $item
                ];
            });

        // 4. Peminjaman
        $peminjaman = PeminjamanBarang::where('barang_id', $this->barang->id)
            ->with('pegawai.user')
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Peminjaman',
                    'date' => $item->tanggal_pinjam,
                    'user' => $item->pegawai->user->name ?? 'Pegawai',
                    'description' => 'Dipinjam',
                    'details' => "Status: " . $item->status,
                    'icon' => 'hand-raised',
                    'color' => 'purple',
                    'original' => $item
                ];
            });

        // 5. Opname (Audit)
        $opname = OpnameDetail::where('barang_id', $this->barang->id)
            ->with(['opname.user'])
            ->get()
            ->map(function($item) {
                return [
                    'type' => 'Audit',
                    'date' => $item->opname->tanggal ?? $item->created_at,
                    'user' => $item->opname->user->name ?? 'Auditor',
                    'description' => 'Stok Opname',
                    'details' => "Fisik: " . $item->stok_fisik . " (Selisih: " . $item->selisih . ")",
                    'icon' => 'clipboard-document-check',
                    'color' => 'teal',
                    'original' => $item
                ];
            });

        // Merge & Sort
        $timeline = $riwayats->concat($maintenances)
            ->concat($mutasi)
            ->concat($peminjaman)
            ->concat($opname)
            ->sortByDesc('date');

        return view('livewire.barang.show', [
            'timeline' => $timeline
        ])->layout('layouts.app', ['header' => 'Detail Aset: ' . $this->barang->nama_barang]);
    }
}
