<?php

namespace App\Livewire\Shift;

use App\Models\Shift;
use Livewire\Component;

class Edit extends Component
{
    public Shift $shift;
    public $nama_shift;
    public $jam_mulai;
    public $jam_selesai;

    public function mount(Shift $shift)
    {
        $this->shift = $shift;
        $this->nama_shift = $shift->nama_shift;
        $this->jam_mulai = $shift->jam_mulai;
        $this->jam_selesai = $shift->jam_selesai;
    }

    public function update()
    {
        $this->validate([
            'nama_shift' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $this->shift->update([
            'nama_shift' => $this->nama_shift,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
        ]);

        $this->dispatch('notify', 'success', 'Shift berhasil diperbarui.');
        return $this->redirect(route('shift.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.shift.edit')->layout('layouts.app', ['header' => 'Edit Shift']);
    }
}