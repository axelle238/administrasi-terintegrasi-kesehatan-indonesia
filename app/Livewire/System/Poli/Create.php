<?php

namespace App\Livewire\System\Poli;

use App\Models\Poli;
use Livewire\Component;

class Create extends Component
{
    public $nama_poli;
    public $kode_poli;
    public $keterangan;

    protected $rules = [
        'nama_poli' => 'required|string|max:255',
        'kode_poli' => 'required|string|max:10|unique:polis,kode_poli',
        'keterangan' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        Poli::create([
            'nama_poli' => $this->nama_poli,
            'kode_poli' => $this->kode_poli,
            'keterangan' => $this->keterangan,
        ]);

        $this->dispatch('notify', 'success', 'Poli berhasil ditambahkan.');
        return $this->redirect(route('system.poli.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.system.poli.create')->layout('layouts.app', ['header' => 'Tambah Poli Baru']);
    }
}
