<?php

namespace App\Livewire\Admin\Fasilitas;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Fasilitas;

class Create extends Component
{
    use WithFileUploads;

    public $nama_fasilitas;
    public $deskripsi;
    public $jenis = 'medis';
    public $is_active = true;
    public $gambar;

    protected $rules = [
        'nama_fasilitas' => 'required|min:3|max:255',
        'deskripsi' => 'nullable|string',
        'jenis' => 'required|in:medis,non-medis,unggulan',
        'is_active' => 'boolean',
        'gambar' => 'nullable|image|max:2048', // Max 2MB
    ];

    public function save()
    {
        $this->validate();

        $gambarPath = null;
        if ($this->gambar) {
            $gambarPath = $this->gambar->store('fasilitas-images', 'public');
        }

        Fasilitas::create([
            'nama_fasilitas' => $this->nama_fasilitas,
            'deskripsi' => $this->deskripsi,
            'jenis' => $this->jenis,
            'is_active' => $this->is_active,
            'gambar' => $gambarPath,
        ]);

        $this->dispatch('notify', 'success', 'Fasilitas berhasil ditambahkan.');
        return redirect()->route('admin.fasilitas.index');
    }

    public function render()
    {
        return view('livewire.admin.fasilitas.create')
            ->layout('layouts.app', ['header' => 'Tambah Fasilitas Baru']);
    }
}