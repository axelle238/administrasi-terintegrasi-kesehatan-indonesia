<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Supplier $supplier;
    
    public $nama_supplier;
    public $kode_supplier;
    public $kontak_person;
    public $telepon;
    public $email;
    public $alamat;
    public $keterangan;

    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->nama_supplier = $supplier->nama_supplier;
        $this->kode_supplier = $supplier->kode_supplier;
        $this->kontak_person = $supplier->kontak_person;
        $this->telepon = $supplier->telepon;
        $this->email = $supplier->email;
        $this->alamat = $supplier->alamat;
        $this->keterangan = $supplier->keterangan;
    }

    protected function rules()
    {
        return [
            'nama_supplier' => 'required|string|max:255',
            'kode_supplier' => ['nullable', 'string', 'max:255', Rule::unique('suppliers')->ignore($this->supplier->id)],
            'kontak_person' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->supplier->update([
            'nama_supplier' => $this->nama_supplier,
            'kode_supplier' => $this->kode_supplier,
            'kontak_person' => $this->kontak_person,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'keterangan' => $this->keterangan,
        ]);

        $this->dispatch('notify', 'success', 'Data supplier berhasil diperbarui.');
        return $this->redirect(route('supplier.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.supplier.edit')->layout('layouts.app', ['header' => 'Edit Supplier']);
    }
}
