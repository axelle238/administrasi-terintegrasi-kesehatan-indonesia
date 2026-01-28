<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;

class Create extends Component
{
    public $nama_supplier;
    public $kontak;
    public $alamat;
    public $email;

    protected $rules = [
        'nama_supplier' => 'required|string|max:255',
        'kontak' => 'required|string|max:255',
        'alamat' => 'nullable|string',
        'email' => 'nullable|email|max:255',
    ];

    public function save()
    {
        $this->validate();

        Supplier::create([
            'nama_supplier' => $this->nama_supplier,
            'kontak' => $this->kontak,
            'alamat' => $this->alamat,
            'email' => $this->email,
        ]);

        $this->dispatch('notify', 'success', 'Supplier berhasil ditambahkan.');
        return $this->redirect(route('supplier.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.supplier.create')->layout('layouts.app', ['header' => 'Tambah Supplier']);
    }
}
