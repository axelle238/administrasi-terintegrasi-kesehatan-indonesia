<?php

namespace App\Livewire\Barang\Penghapusan;

use App\Models\PenghapusanBarang;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function approve($id)
    {
        $data = PenghapusanBarang::find($id);
        if ($data->status === 'Pending') {
            $data->update([
                'status' => 'Disetujui',
                'disetujui_oleh' => Auth::id(),
                'tanggal_disetujui' => now()
            ]);
            
            // Logic to actually remove stock or mark asset as disposed
            foreach ($data->details as $detail) {
                $barang = $detail->barang;
                if ($barang) {
                    // Reduce stock or set status
                    $barang->stok = max(0, $barang->stok - $detail->jumlah);
                    // Optionally mark as Disposed if stock is 0 and it's an asset
                    if ($barang->is_asset && $barang->stok == 0) {
                        $barang->kondisi = 'Dihapuskan';
                    }
                    $barang->save();

                    // Log History
                    \App\Models\RiwayatBarang::create([
                        'barang_id' => $barang->id,
                        'user_id' => Auth::id(),
                        'jenis_transaksi' => 'Penghapusan',
                        'jumlah' => $detail->jumlah,
                        'stok_terakhir' => $barang->stok,
                        'tanggal' => now(),
                        'keterangan' => 'Penghapusan No: ' . $data->nomor_dokumen
                    ]);
                }
            }

            $this->dispatch('notify', 'success', 'Penghapusan disetujui dan stok telah diperbarui.');
        }
    }

    public function reject($id)
    {
        $data = PenghapusanBarang::find($id);
        if ($data->status === 'Pending') {
            $data->update([
                'status' => 'Ditolak',
                'disetujui_oleh' => Auth::id(),
                'tanggal_disetujui' => now()
            ]);
            $this->dispatch('notify', 'success', 'Pengajuan ditolak.');
        }
    }

    public function render()
    {
        $list = PenghapusanBarang::with('pemohon')
            ->where('nomor_dokumen', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.barang.penghapusan.index', [
            'list' => $list
        ])->layout('layouts.app', ['header' => 'Daftar Penghapusan Aset']);
    }
}
