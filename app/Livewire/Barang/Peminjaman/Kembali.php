<?php

namespace App\Livewire\Barang\Peminjaman;

use Livewire\Component;
use App\Models\PeminjamanBarang;

class Kembali extends Component
{
    public PeminjamanBarang $peminjaman;
    public $tanggal_kembali_realisasi;
    public $kondisi_kembali = 'Baik';

    public function mount(PeminjamanBarang $peminjaman)
    {
        $this->peminjaman = $peminjaman->load('barang', 'pegawai.user');
        $this->tanggal_kembali_realisasi = date('Y-m-d');
    }

    public function save()
    {
        $this->validate([
            'tanggal_kembali_realisasi' => 'required|date',
            'kondisi_kembali' => 'required|string',
        ]);

        $this->peminjaman->update([
            'tanggal_kembali_realisasi' => $this->tanggal_kembali_realisasi,
            'kondisi_kembali' => $this->kondisi_kembali,
            'status' => 'Dikembalikan',
        ]);

        $this->dispatch('notify', 'success', 'Barang berhasil dikembalikan.');
        return $this->redirect(route('barang.peminjaman.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.peminjaman.kembali')
            ->layout('layouts.app', ['header' => 'Proses Pengembalian Barang']);
    }
}
