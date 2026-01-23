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
        $pengadaan = PengadaanBarang::find($id);
        $pengadaan->update([
            'status' => 'Disetujui',
            'disetujui_oleh' => Auth::id(),
            'tanggal_disetujui' => now(),
        ]);
        $this->dispatch('notify', 'success', 'Pengajuan disetujui.');
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
        $pengadaans = PengadaanBarang::with('pemohon')
            ->where('nomor_pengajuan', 'like', '%' . $this->search . '%')
            ->latest('tanggal_pengajuan')
            ->paginate(10);

        return view('livewire.barang.pengadaan.index', [
            'pengadaans' => $pengadaans
        ])->layout('layouts.app', ['header' => 'Pengadaan Barang']);
    }
}
