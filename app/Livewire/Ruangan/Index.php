<?php

namespace App\Livewire\Ruangan;

use App\Models\Ruangan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

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

    public function delete($id)
    {
        $ruangan = Ruangan::find($id);
        if ($ruangan) {
            $ruangan->delete();
            $this->dispatch('notify', 'success', 'Data ruangan berhasil dihapus.');
        }
    }
}
