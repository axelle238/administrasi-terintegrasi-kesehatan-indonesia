<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;

class Edit extends Component
{
    public Supplier $supplier;
    public $nama_supplier;
    public $kontak;
    public $alamat;
    public $email;

    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->nama_supplier = $supplier->nama_supplier;
        $this->kontak = $supplier->kontak;
        $this->alamat = $supplier->alamat;
        $this->email = $supplier->email;
    }

    protected $rules = [
        'nama_supplier' => 'required|string|max:255',
        'kontak' => 'required|string|max:255',
        'alamat' => 'nullable|string',
        'email' => 'nullable|email|max:255',
    ];

    public function save()
    {
        $this->validate();

        $this->supplier->update([
            'nama_supplier' => $this->nama_supplier,
            'kontak' => $this->kontak,
            'alamat' => $this->alamat,
            'email' => $this->email,
        ]);

        $this->dispatch('notify', 'success', 'Supplier berhasil diperbarui.');
        return $this->redirect(route('supplier.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.supplier.edit')->layout('layouts.app', ['header' => 'Edit Supplier']);
    }
}
