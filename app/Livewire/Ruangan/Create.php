<?php

namespace App\Livewire\Ruangan;

use App\Models\Ruangan;
use Livewire\Component;

class Create extends Component
{
    public $kode_ruangan;
    public $nama_ruangan;
    public $lokasi_gedung;
    public $penanggung_jawab;
    public $keterangan;

    protected $rules = [
        'nama_ruangan' => 'required|string|max:255',
        'kode_ruangan' => 'nullable|string|max:255|unique:ruangans,kode_ruangan',
        'lokasi_gedung' => 'nullable|string|max:255',
        'penanggung_jawab' => 'nullable|string|max:255',
        'keterangan' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        Ruangan::create([
            'kode_ruangan' => $this->kode_ruangan,
            'nama_ruangan' => $this->nama_ruangan,
            'lokasi_gedung' => $this->lokasi_gedung,
            'penanggung_jawab' => $this->penanggung_jawab,
            'keterangan' => $this->keterangan,
        ]);

        $this->dispatch('notify', 'success', 'Data ruangan berhasil ditambahkan.');
        return $this->redirect(route('ruangan.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.ruangan.create')->layout('layouts.app', ['header' => 'Tambah Ruangan Baru']);
    }
}
