<?php

namespace App\Livewire\Obat;

use App\Models\Obat;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Obat $obat;
    public $kode_obat;
    public $nama_obat;
    public $jenis_obat;
    public $stok;
    public $min_stok;
    public $satuan;
    public $harga_satuan;
    public $tanggal_kedaluwarsa;
    public $batch_number;
    public $no_izin_edar;
    public $pabrik;

    public function mount(Obat $obat)
    {
        $this->obat = $obat;
        $this->kode_obat = $obat->kode_obat;
        $this->nama_obat = $obat->nama_obat;
        $this->jenis_obat = $obat->jenis_obat;
        $this->stok = $obat->stok;
        $this->min_stok = $obat->min_stok;
        $this->satuan = $obat->satuan;
        $this->harga_satuan = $obat->harga_satuan;
        $this->tanggal_kedaluwarsa = $obat->tanggal_kedaluwarsa;
        $this->batch_number = $obat->batch_number;
        $this->no_izin_edar = $obat->no_izin_edar;
        $this->pabrik = $obat->pabrik;
    }

    public function update()
    {
        $this->validate([
            'kode_obat' => ['required', Rule::unique('obats')->ignore($this->obat->id)],
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|string',
            'stok' => 'required|integer|min:0',
            'min_stok' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'harga_satuan' => 'required|numeric|min:0',
            'tanggal_kedaluwarsa' => 'required|date',
            'batch_number' => 'nullable|string',
            'no_izin_edar' => 'nullable|string',
            'pabrik' => 'nullable|string',
        ]);

        $this->obat->update([
            'kode_obat' => $this->kode_obat,
            'nama_obat' => $this->nama_obat,
            'jenis_obat' => $this->jenis_obat,
            'stok' => $this->stok,
            'min_stok' => $this->min_stok,
            'satuan' => $this->satuan,
            'harga_satuan' => $this->harga_satuan,
            'tanggal_kedaluwarsa' => $this->tanggal_kedaluwarsa,
            'batch_number' => $this->batch_number,
            'no_izin_edar' => $this->no_izin_edar,
            'pabrik' => $this->pabrik,
        ]);

        $this->dispatch('notify', 'success', 'Data obat berhasil diperbarui.');
        return $this->redirect(route('obat.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.obat.edit')->layout('layouts.app', ['header' => 'Edit Data Obat']);
    }
}