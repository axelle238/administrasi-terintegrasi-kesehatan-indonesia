<?php

namespace App\Livewire\Shift;

use App\Models\Shift;
use Livewire\Component;

class Index extends Component
{
    public function delete($id)
    {
        $shift = Shift::find($id);
        if ($shift) {
            $shift->delete();
            $this->dispatch('notify', 'success', 'Shift berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.shift.index', [
            'shifts' => Shift::all()
        ])->layout('layouts.app', ['header' => 'Manajemen Shift']);
    }
}