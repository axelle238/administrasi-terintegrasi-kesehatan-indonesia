<?php

namespace App\Livewire\Ruangan;

use App\Models\Ruangan;
use Livewire\Component;

class Edit extends Component
{
    public Ruangan $ruangan;
    public $nama_ruangan;
    public $lokasi;
    public $kapasitas;

    public function mount(Ruangan $ruangan)
    {
        $this->ruangan = $ruangan;
        $this->nama_ruangan = $ruangan->nama_ruangan;
        $this->lokasi = $ruangan->lokasi;
        $this->kapasitas = $ruangan->kapasitas;
    }

    protected $rules = [
        'nama_ruangan' => 'required|string|max:255',
        'lokasi' => 'nullable|string|max:255',
        'kapasitas' => 'nullable|integer|min:0',
    ];

    public function save()
    {
        $this->validate();

        $this->ruangan->update([
            'nama_ruangan' => $this->nama_ruangan,
            'lokasi' => $this->lokasi,
            'kapasitas' => $this->kapasitas,
        ]);

        $this->dispatch('notify', 'success', 'Ruangan berhasil diperbarui.');
        return $this->redirect(route('ruangan.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.ruangan.edit')->layout('layouts.app', ['header' => 'Edit Ruangan']);
    }
}
