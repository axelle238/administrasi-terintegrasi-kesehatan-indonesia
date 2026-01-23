<?php

namespace App\Livewire\Obat;

use App\Models\Obat;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $obat = Obat::find($id);
        if ($obat) {
            $obat->delete();
            $this->dispatch('notify', 'success', 'Data obat berhasil dihapus.');
        }
    }

    public function render()
    {
        $obats = Obat::where('nama_obat', 'like', '%' . $this->search . '%')
            ->orWhere('kode_obat', 'like', '%' . $this->search . '%')
            ->orWhere('jenis_obat', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.obat.index', [
            'obats' => $obats
        ])->layout('layouts.app', ['header' => 'Manajemen Data Obat (Farmasi)']);
    }
}