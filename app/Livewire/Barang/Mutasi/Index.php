<?php

namespace App\Livewire\Barang\Mutasi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MutasiBarang;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $mutasi = MutasiBarang::with(['barang', 'ruanganAsal', 'ruanganTujuan'])
            ->when($this->search, function($q) {
                $q->whereHas('barang', function($b) {
                    $b->where('nama_barang', 'like', '%'.$this->search.'%');
                })->orWhere('penanggung_jawab', 'like', '%'.$this->search.'%');
            })
            ->latest('tanggal_mutasi')
            ->paginate($this->perPage);

        return view('livewire.barang.mutasi.index', [
            'mutasi' => $mutasi,
        ])->layout('layouts.app', ['header' => 'Mutasi & Perpindahan Aset']);
    }
}
