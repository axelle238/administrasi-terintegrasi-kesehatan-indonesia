<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $deleteId = '';
    public $showDeleteModal = false;

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
}