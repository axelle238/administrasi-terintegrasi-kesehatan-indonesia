<?php

namespace App\Livewire\Barang\Pengadaan;

use App\Models\PengadaanBarang;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function approve($id)
    {
        $pengadaan = PengadaanBarang::with('details')->find($id);
        
        if (!$pengadaan) {
            $this->dispatch('notify', 'error', 'Data tidak ditemukan.');
            return;
        }

        if ($pengadaan->status !== 'Pending') {
            $this->dispatch('notify', 'error', 'Hanya pengajuan status Pending yang bisa disetujui.');
            return;
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($pengadaan) {
            foreach ($pengadaan->details as $detail) {
                // Update Approved Quantity (assume approved = requested for now, or use a modal to edit this later)
                $detail->update(['jumlah_disetujui' => $detail->jumlah_minta]);

                $qty = $detail->jumlah_disetujui;
                $barang = null;

                if ($detail->barang_id) {
                    // Existing Item
                    $barang = \App\Models\Barang::find($detail->barang_id);
                    if ($barang) {
                        $barang->increment('stok', $qty);
                    }
                } else {
                    // New Item - Create Master Data
                    // We need a category. Since we don't have it in the form, we might set a default or just pick the first one?
                    // Better approach: Prompt user to map it, but for now let's auto-create with a "Umum" category or null if nullable.
                    // The 'kategori_barang_id' is NOT NULL in migration. We have a problem.
                    // Workaround: Find first category or create 'Uncategorized'.
                    $kategori = \App\Models\KategoriBarang::first();
                    $kategoriId = $kategori ? $kategori->id : 1; // Fallback

                    $barang = \App\Models\Barang::create([
                        'kategori_barang_id' => $kategoriId,
                        'kode_barang' => 'BRG-' . strtoupper(uniqid()),
                        'nama_barang' => $detail->nama_barang_baru,
                        'stok' => $qty,
                        'satuan' => $detail->satuan,
                        'kondisi' => 'Baik',
                        'tanggal_pengadaan' => now(),
                        'lokasi_penyimpanan' => 'Gudang Utama', // Default
                        'is_asset' => false // Default to consumable? Or asset? Safe to say false.
                    ]);
                    
                    // Link the detail to the new barang
                    $detail->update(['barang_id' => $barang->id]);
                }

                if ($barang) {
                    // Log History
                    \App\Models\RiwayatBarang::create([
                        'barang_id' => $barang->id,
                        'user_id' => Auth::id(),
                        'jenis_transaksi' => 'Masuk',
                        'jumlah' => $qty,
                        'stok_terakhir' => $barang->stok,
                        'tanggal' => now(),
                        'keterangan' => 'Pengadaan No: ' . $pengadaan->nomor_pengajuan
                    ]);
                }
            }

            $pengadaan->update([
                'status' => 'Disetujui',
                'disetujui_oleh' => Auth::id(),
                'tanggal_disetujui' => now(),
            ]);
        });

        $this->dispatch('notify', 'success', 'Pengajuan disetujui dan stok telah ditambahkan.');
    }

    public function reject($id)
    {
        $pengadaan = PengadaanBarang::find($id);
        $pengadaan->update([
            'status' => 'Ditolak',
            'disetujui_oleh' => Auth::id(),
            'tanggal_disetujui' => now(),
        ]);
        $this->dispatch('notify', 'success', 'Pengajuan ditolak.');
    }

    public function render()
    {
        $pengadaans = PengadaanBarang::with(['pemohon', 'supplier'])
            ->where('nomor_pengajuan', 'like', '%' . $this->search . '%')
            ->latest('tanggal_pengajuan')
            ->paginate(10);

        return view('livewire.barang.pengadaan.index', [
            'pengadaans' => $pengadaans
        ])->layout('layouts.app', ['header' => 'Pengadaan Barang']);
    }
}
