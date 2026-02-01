<?php

namespace App\Livewire\Shift;

use Livewire\Component;
use App\Models\Shift;

class Index extends Component
{
    public $shifts;
    public $nama_shift, $jam_masuk, $jam_keluar, $color = '#3b82f6', $shiftId;
    public $isOpen = false;

    public function render()
    {
        $this->shifts = Shift::all();
        return view('livewire.shift.index')->layout('layouts.app', ['header' => 'Master Shift Kerja']);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate([
            'nama_shift' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
        ]);

        Shift::updateOrCreate(['id' => $this->shiftId], [
            'nama_shift' => $this->nama_shift,
            'jam_masuk' => $this->jam_masuk,
            'jam_keluar' => $this->jam_keluar,
            'color' => $this->color
        ]);

        session()->flash('message', $this->shiftId ? 'Data shift berhasil diperbarui.' : 'Shift baru berhasil dibuat.');
        $this->closeForm();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        $this->shiftId = $id;
        $this->nama_shift = $shift->nama_shift;
        $this->jam_masuk = $shift->jam_masuk;
        $this->jam_keluar = $shift->jam_keluar;
        $this->color = $shift->color ?? '#3b82f6';
        $this->isOpen = true;
    }

    public function delete($id)
    {
        Shift::find($id)->delete();
        session()->flash('message', 'Data shift berhasil dihapus.');
    }

    public function closeForm()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->nama_shift = '';
        $this->jam_masuk = '';
        $this->jam_keluar = '';
        $this->shiftId = null;
        $this->color = '#3b82f6';
    }
}