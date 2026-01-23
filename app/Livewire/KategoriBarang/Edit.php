<?php

namespace App\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public KategoriBarang $kategoriBarang;
    public $nama_kategori;
    public $deskripsi;

    public function mount(KategoriBarang $kategoriBarang)
    {
        $this->kategoriBarang = $kategoriBarang;
        $this->nama_kategori = $kategoriBarang->nama_kategori;
        $this->deskripsi = $kategoriBarang->deskripsi;
    }

    public function update()
    {
        $this->validate([
            'nama_kategori' => ['required', 'string', 'max:255', Rule::unique('kategori_barangs', 'nama_kategori')->ignore($this->kategoriBarang->id)],
            'deskripsi' => 'nullable|string',
        ]);

        $this->kategoriBarang->update([
            'nama_kategori' => $this->nama_kategori,
            'deskripsi' => $this->deskripsi,
        ]);

        $this->dispatch('notify', 'success', 'Kategori barang berhasil diperbarui.');
        return $this->redirect(route('kategori-barang.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kategori-barang.edit')->layout('layouts.app', ['header' => 'Edit Kategori Barang']);
    }
}