<?php

namespace App\Livewire\Obat;

use App\Models\Obat;
use App\Models\RiwayatBarang; 
// Note: Ideally use RiwayatObat or TransaksiObat, but for now I focus on Master Data.
// TransaksiObat logic usually is separate (Prescription based).
use Livewire\Component;

class Create extends Component
{
    public $kode_obat;
    public $nama_obat;
    public $jenis_obat;
    public $golongan = 'Bebas'; // Default
    public $stok;
    public $min_stok;
    public $satuan;
    public $harga_satuan;
    public $tanggal_kedaluwarsa;
    public $batch_number;
    public $no_izin_edar;
    public $pabrik;

    protected $rules = [
        'kode_obat' => 'required|unique:obats,kode_obat',
        'nama_obat' => 'required|string|max:255',
        'jenis_obat' => 'required|string',
        'golongan' => 'required|in:Bebas,Bebas Terbatas,Keras,Narkotika,Psikotropika',
        'stok' => 'required|integer|min:0',
        'min_stok' => 'required|integer|min:0',
        'satuan' => 'required|string',
        'harga_satuan' => 'required|numeric|min:0',
        'tanggal_kedaluwarsa' => 'required|date',
        'batch_number' => 'nullable|string',
        'no_izin_edar' => 'nullable|string',
        'pabrik' => 'nullable|string',
    ];

    public function mount()
    {
         $this->kode_obat = 'OBT-' . strtoupper(uniqid());
    }

    public function save()
    {
        $this->validate();

        Obat::create([
            'kode_obat' => $this->kode_obat,
            'nama_obat' => $this->nama_obat,
            'jenis_obat' => $this->jenis_obat,
            'golongan' => $this->golongan,
            'stok' => $this->stok,
            'min_stok' => $this->min_stok,
            'satuan' => $this->satuan,
            'harga_satuan' => $this->harga_satuan,
            'tanggal_kedaluwarsa' => $this->tanggal_kedaluwarsa,
            'batch_number' => $this->batch_number,
            'no_izin_edar' => $this->no_izin_edar,
            'pabrik' => $this->pabrik,
        ]);

        $this->dispatch('notify', 'success', 'Data obat berhasil ditambahkan.');
        return $this->redirect(route('obat.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.obat.create')->layout('layouts.app', ['header' => 'Tambah Data Obat']);
    }
}