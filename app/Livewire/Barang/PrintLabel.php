<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use Livewire\Component;

class PrintLabel extends Component
{
    public Barang $barang;

    public function mount(Barang $barang)
    {
        $this->barang = $barang;
    }

    public function render()
    {
        return view('livewire.barang.print-label')->layout('layouts.print'); // Use empty layout for printing
    }
}
