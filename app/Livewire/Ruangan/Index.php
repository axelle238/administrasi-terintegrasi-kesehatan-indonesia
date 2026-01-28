<?php

namespace App\Livewire\Ruangan;

use App\Models\Ruangan;
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
        $ruangans = Ruangan::query()
            ->where(function($q) {
                $q->where('nama_ruangan', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_ruangan', 'like', '%' . $this->search . '%')
                  ->orWhere('penanggung_jawab', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_ruangan')
            ->paginate(10);

        return view('livewire.ruangan.index', [
            'ruangans' => $ruangans
        ])->layout('layouts.app', ['header' => 'Manajemen Ruangan']);
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $ruangan = Ruangan::find($this->deleteId);
        if ($ruangan) {
            $ruangan->delete();
            $this->dispatch('notify', message: 'Data ruangan berhasil dihapus.');
        }
        $this->showDeleteModal = false;
    }
}