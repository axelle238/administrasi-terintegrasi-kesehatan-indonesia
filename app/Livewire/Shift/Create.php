<?php

namespace App\Livewire\Shift;

use App\Models\Shift;
use Livewire\Component;

class Create extends Component
{
    public $nama_shift;
    public $jam_mulai;
    public $jam_selesai;

    protected $rules = [
        'nama_shift' => 'required|string|max:255',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required',
    ];

    public function save()
    {
        $this->validate();

        Shift::create([
            'nama_shift' => $this->nama_shift,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
        ]);

        $this->dispatch('notify', 'success', 'Shift berhasil ditambahkan.');
        return $this->redirect(route('shift.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.shift.create')->layout('layouts.app', ['header' => 'Tambah Shift Baru']);
    }
}