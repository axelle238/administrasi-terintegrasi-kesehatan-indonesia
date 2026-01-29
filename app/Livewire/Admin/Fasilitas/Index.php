<?php

namespace App\Livewire\Admin\Fasilitas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Fasilitas;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $fasilitas = Fasilitas::find($id);
        if ($fasilitas) {
            $fasilitas->delete();
            $this->dispatch('notify', 'success', 'Fasilitas berhasil dihapus.');
        }
    }

    public function render()
    {
        $fasilitas = Fasilitas::where('nama_fasilitas', 'like', '%' . $this->search . '%')
            ->orderBy('is_active', 'desc')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.fasilitas.index', compact('fasilitas'))
            ->layout('layouts.app', ['header' => 'Manajemen Fasilitas & Sarana']);
    }
}