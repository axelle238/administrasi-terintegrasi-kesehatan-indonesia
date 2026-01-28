<?php

namespace App\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Livewire\Component;

class Edit extends Component
{
    public KategoriBarang $kategoriBarang;
    public $nama_kategori;
    public $keterangan;

    public function mount(KategoriBarang $kategoriBarang)
    {
        $this->kategoriBarang = $kategoriBarang;
        $this->nama_kategori = $kategoriBarang->nama_kategori;
        $this->keterangan = $kategoriBarang->keterangan;
    }

    protected $rules = [
        'nama_kategori' => 'required|string|max:255',
        'keterangan' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        $this->kategoriBarang->update([
            'nama_kategori' => $this->nama_kategori,
            'keterangan' => $this->keterangan,
        ]);

        $this->dispatch('notify', 'success', 'Kategori Barang berhasil diperbarui.');
        return $this->redirect(route('kategori-barang.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.kategori-barang.edit')->layout('layouts.app', ['header' => 'Edit Kategori Barang']);
    }
}
