<?php

namespace App\Livewire\Barang\Pengadaan;

use App\Models\PengadaanBarang;
use App\Models\Barang;
use App\Models\RiwayatBarang;
use App\Models\KategoriBarang;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    
    // Approval
    public function approve($id)
    {
        $pengadaan = PengadaanBarang::find($id);
        
        if ($pengadaan && $pengadaan->status === 'Pending') {
            $pengadaan->update([
                'status' => 'Disetujui', // Menunggu barang datang
                'disetujui_oleh' => Auth::id(),
                'tanggal_disetujui' => now(),
            ]);
            $this->dispatch('notify', 'success', 'Pengajuan disetujui. Menunggu penerimaan barang.');
        }
    }

    // Goods Receipt (Penerimaan Barang)
    public function receive($id)
    {
        $pengadaan = PengadaanBarang::with('details')->find($id);
        
        if (!$pengadaan || $pengadaan->status !== 'Disetujui') {
            $this->dispatch('notify', 'error', 'Hanya pengadaan disetujui yang bisa diproses terima.');
            return;
        }

        DB::transaction(function () use ($pengadaan) {
            foreach ($pengadaan->details as $detail) {
                // Gunakan jumlah disetujui, jika null gunakan jumlah minta
                $qty = $detail->jumlah_disetujui ?? $detail->jumlah_minta;
                $barang = null;

                if ($detail->barang_id) {
                    $barang = Barang::find($detail->barang_id);
                    if ($barang) {
                        $barang->increment('stok', $qty);
                    }
                } else {
                    // Auto-create new item if not mapped
                    $kategori = KategoriBarang::first();
                    $kategoriId = $kategori ? $kategori->id : 1; 

                    $barang = Barang::create([
                        'kategori_barang_id' => $kategoriId,
                        'kode_barang' => 'BRG-' . strtoupper(uniqid()), // Sebaiknya auto-numbering sequence
                        'nama_barang' => $detail->nama_barang_baru,
                        'stok' => $qty,
                        'satuan' => $detail->satuan,
                        'kondisi' => 'Baik',
                        'tanggal_pengadaan' => now(),
                        'lokasi_penyimpanan' => 'Gudang Utama',
                        'is_asset' => false
                    ]);
                    
                    $detail->update(['barang_id' => $barang->id]);
                }

                // Log History
                if ($barang) {
                    RiwayatBarang::create([
                        'barang_id' => $barang->id,
                        'user_id' => Auth::id(),
                        'jenis_transaksi' => 'Pengadaan', // Procurement
                        'jumlah' => $qty,
                        'stok_terakhir' => $barang->stok,
                        'tanggal' => now(),
                        'keterangan' => 'Penerimaan Pengadaan No: ' . $pengadaan->nomor_pengajuan
                    ]);
                }
            }

            $pengadaan->update([
                'status' => 'Selesai', // Closed/Received
            ]);
        });

        $this->dispatch('notify', 'success', 'Barang diterima dan stok telah ditambahkan.');
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
