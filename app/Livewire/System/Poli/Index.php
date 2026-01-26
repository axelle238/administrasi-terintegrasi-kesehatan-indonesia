<?php

namespace App\Livewire\System\Poli;

use App\Models\Poli;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        Poli::find($id)->delete();
        $this->dispatch('notify', 'success', 'Poli dihapus.');
    }

    public function render()
    {
        $polis = Poli::where('nama_poli', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.system.poli.index', [
            'polis' => $polis
        ])->layout('layouts.app', ['header' => 'Master Data Poli']);
    }
}