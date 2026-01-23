<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $deleteId = '';
    public $showDeleteModal = false;

    // Form Fields
    public $supplierId;
    public $nama_supplier;
    public $kode_supplier;
    public $kontak_person;
    public $telepon;
    public $email;
    public $alamat;
    public $keterangan;

    public function render()
    {
        $suppliers = Supplier::query()
            ->where(function($q) {
                $q->where('nama_supplier', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_supplier', 'like', '%' . $this->search . '%')
                  ->orWhere('kontak_person', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_supplier')
            ->paginate(10);

        return view('livewire.supplier.index', [
            'suppliers' => $suppliers
        ])->layout('layouts.app', ['header' => 'Manajemen Supplier / Vendor']);
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->dispatch('open-modal', 'supplier-modal');
    }

    public function edit(Supplier $supplier)
    {
        $this->resetForm();
        $this->supplierId = $supplier->id;
        $this->nama_supplier = $supplier->nama_supplier;
        $this->kode_supplier = $supplier->kode_supplier;
        $this->kontak_person = $supplier->kontak_person;
        $this->telepon = $supplier->telepon;
        $this->email = $supplier->email;
        $this->alamat = $supplier->alamat;
        $this->keterangan = $supplier->keterangan;
        $this->showModal = true;
        $this->dispatch('open-modal', 'supplier-modal');
    }

    public function store()
    {
        $this->validate([
            'nama_supplier' => 'required|string|max:255',
            'kode_supplier' => ['nullable', 'string', 'max:255', Rule::unique('suppliers')->ignore($this->supplierId)],
            'kontak_person' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        Supplier::updateOrCreate(
            ['id' => $this->supplierId],
            [
                'nama_supplier' => $this->nama_supplier,
                'kode_supplier' => $this->kode_supplier,
                'kontak_person' => $this->kontak_person,
                'telepon' => $this->telepon,
                'email' => $this->email,
                'alamat' => $this->alamat,
                'keterangan' => $this->keterangan,
            ]
        );

        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('notify', message: 'Data supplier berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $supplier = Supplier::find($this->deleteId);
        if ($supplier) {
            $supplier->delete();
            $this->dispatch('notify', message: 'Data supplier berhasil dihapus.');
        }
        $this->showDeleteModal = false;
    }

    public function resetForm()
    {
        $this->supplierId = null;
        $this->nama_supplier = '';
        $this->kode_supplier = '';
        $this->kontak_person = '';
        $this->telepon = '';
        $this->email = '';
        $this->alamat = '';
        $this->keterangan = '';
        $this->resetErrorBag();
    }
}
