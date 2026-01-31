<?php

namespace App\Livewire\Barang\Mutasi;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.barang.mutasi.index')->layout('layouts.app', ['header' => 'Mutasi & Perpindahan Aset']);
    }
}