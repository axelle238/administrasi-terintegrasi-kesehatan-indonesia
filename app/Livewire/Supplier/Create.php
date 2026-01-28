<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;

class Create extends Component
{
    public $nama_supplier;
    public $kode_supplier;
    public $kontak_person;
    public $telepon;
    public $email;
    public $alamat;
    public $keterangan;

    protected $rules = [
        'nama_supplier' => 'required|string|max:255',
        'kode_supplier' => 'nullable|string|max:255|unique:suppliers,kode_supplier',
        'kontak_person' => 'nullable|string|max:255',
        'telepon' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:255',
        'alamat' => 'nullable|string',
        'keterangan' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        Supplier::create([
            'nama_supplier' => $this->nama_supplier,
            'kode_supplier' => $this->kode_supplier,
            'kontak_person' => $this->kontak_person,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'keterangan' => $this->keterangan,
        ]);

        $this->dispatch('notify', 'success', 'Data supplier berhasil ditambahkan.');
        return $this->redirect(route('supplier.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.supplier.create')->layout('layouts.app', ['header' => 'Tambah Supplier Baru']);
    }
}
