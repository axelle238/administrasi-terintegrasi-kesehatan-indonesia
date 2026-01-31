<?php

namespace App\Livewire\Barang\Peminjaman;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PeminjamanBarang;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = ''; // 'Dipinjam', 'Dikembalikan'
    public $perPage = 10;

    public function render()
    {
        $peminjaman = PeminjamanBarang::with(['barang', 'pegawai.user'])
            ->when($this->search, function($q) {
                $q->where('no_transaksi', 'like', '%'.$this->search.'%')
                  ->orWhereHas('barang', fn($b) => $b->where('nama_barang', 'like', '%'.$this->search.'%'))
                  ->orWhereHas('pegawai.user', fn($u) => $u->where('name', 'like', '%'.$this->search.'%'));
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            })
            ->latest('created_at')
            ->paginate($this->perPage);

        return view('livewire.barang.peminjaman.index', [
            'peminjaman' => $peminjaman,
        ])->layout('layouts.app', ['header' => 'Peminjaman Barang']);
    }
}
