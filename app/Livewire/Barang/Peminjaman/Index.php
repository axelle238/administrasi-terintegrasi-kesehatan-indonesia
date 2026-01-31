<?php

namespace App\Livewire\Barang\Peminjaman;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.barang.peminjaman.index')->layout('layouts.app', ['header' => 'Peminjaman Barang']);
    }
}