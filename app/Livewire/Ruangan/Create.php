<?php

namespace App\Livewire\Ruangan;

use App\Models\Ruangan;
use Livewire\Component;

class Create extends Component
{
    public $nama_ruangan;
    public $lokasi;
    public $kapasitas;

    protected $rules = [
        'nama_ruangan' => 'required|string|max:255',
        'lokasi' => 'nullable|string|max:255',
        'kapasitas' => 'nullable|integer|min:0',
    ];

    public function save()
    {
        $this->validate();

        Ruangan::create([
            'nama_ruangan' => $this->nama_ruangan,
            'lokasi' => $this->lokasi,
            'kapasitas' => $this->kapasitas,
        ]);

        $this->dispatch('notify', 'success', 'Ruangan berhasil ditambahkan.');
        return $this->redirect(route('ruangan.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.ruangan.create')->layout('layouts.app', ['header' => 'Tambah Ruangan']);
    }
}
