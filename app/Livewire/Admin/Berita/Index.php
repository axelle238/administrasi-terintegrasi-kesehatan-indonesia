<?php

namespace App\Livewire\Admin\Berita;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Berita;

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
        $berita = Berita::find($id);
        if ($berita) {
            $berita->delete();
            $this->dispatch('notify', 'success', 'Berita berhasil dihapus.');
        }
    }

    public function render()
    {
        $berita = Berita::where('judul', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.berita.index', compact('berita'))
            ->layout('layouts.app', ['header' => 'Manajemen Informasi & Berita']);
    }
}