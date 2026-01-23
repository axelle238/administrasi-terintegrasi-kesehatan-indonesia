<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Barang $barang;
    
    public $kategori_barang_id;
    public $kode_barang;
    public $nama_barang;
    public $merk;
    public $stok; // Stok is usually not edited directly here, but let's allow correction
    public $satuan;
    public $kondisi;
    public $tanggal_pengadaan;
    public $lokasi_penyimpanan;

    public function mount(Barang $barang)
    {
        $this->barang = $barang;
        $this->kategori_barang_id = $barang->kategori_barang_id;
        $this->kode_barang = $barang->kode_barang;
        $this->nama_barang = $barang->nama_barang;
        $this->merk = $barang->merk;
        $this->stok = $barang->stok;
        $this->satuan = $barang->satuan;
        $this->kondisi = $barang->kondisi;
        $this->tanggal_pengadaan = $barang->tanggal_pengadaan;
        $this->lokasi_penyimpanan = $barang->lokasi_penyimpanan;
    }

    public function update()
    {
        $this->validate([
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'kode_barang' => ['required', 'string', Rule::unique('barangs')->ignore($this->barang->id)],
            'nama_barang' => 'required|string|max:255',
            'merk' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'kondisi' => 'required|string',
            'tanggal_pengadaan' => 'required|date',
            'lokasi_penyimpanan' => 'nullable|string',
        ]);

        $this->barang->update([
            'kategori_barang_id' => $this->kategori_barang_id,
            'kode_barang' => $this->kode_barang,
            'nama_barang' => $this->nama_barang,
            'merk' => $this->merk,
            'stok' => $this->stok,
            'satuan' => $this->satuan,
            'kondisi' => $this->kondisi,
            'tanggal_pengadaan' => $this->tanggal_pengadaan,
            'lokasi_penyimpanan' => $this->lokasi_penyimpanan,
        ]);

        $this->dispatch('notify', 'success', 'Data barang berhasil diperbarui.');
        return $this->redirect(route('barang.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.barang.edit', [
            'kategoris' => KategoriBarang::all()
        ])->layout('layouts.app', ['header' => 'Edit Data Barang']);
    }
}