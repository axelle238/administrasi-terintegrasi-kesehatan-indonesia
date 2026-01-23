<?php

namespace App\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Livewire\Component;

class Create extends Component
{
    public $nama_kategori;
    public $deskripsi;

    protected $rules = [
        'nama_kategori' => 'required|string|max:255|unique:kategori_barangs,nama_kategori',
        'deskripsi' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        KategoriBarang::create([
            'nama_kategori' => $this->nama_kategori,
            'deskripsi' => $this->deskripsi,
        ]);

        $this->dispatch('notify', 'success', 'Kategori barang berhasil ditambahkan.');
        return $this->redirect(route('kategori-barang.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kategori-barang.create')->layout('layouts.app', ['header' => 'Tambah Kategori Barang']);
    }
}