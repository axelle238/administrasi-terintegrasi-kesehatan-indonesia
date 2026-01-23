<?php

namespace App\Livewire\Barang;

use App\Models\Opname;
use Livewire\Component;
use Livewire\WithPagination;

class OpnameIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $opnames = Opname::with('user')->latest()->paginate(10);
        return view('livewire.barang.opname-index', [
            'opnames' => $opnames
        ])->layout('layouts.app', ['header' => 'Stok Opname']);
    }
}
