<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $cari = '';
    public $filterKategori = '';
    public $tipeAset = 'semua'; // semua, medis, umum
    public $jenisBarang = 'semua'; // semua, aset_tetap, habis_pakai
    public $perHalaman = 10;

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function aturTipeAset($tipe)
    {
        $this->tipeAset = $tipe;
        $this->resetPage();
    }

    public function aturJenisBarang($jenis)
    {
        $this->jenisBarang = $jenis;
        $this->resetPage();
    }

    public function render()
    {
        $query = Barang::with(['kategori', 'ruangan']);

        // Pencarian
        if ($this->cari) {
            $query->where(function($q) {
                $q->where('nama_barang', 'like', '%' . $this->cari . '%')
                  ->orWhere('kode_barang', 'like', '%' . $this->cari . '%')
                  ->orWhere('merk', 'like', '%' . $this->cari . '%');
            });
        }

        // Filter Kategori
        if ($this->filterKategori) {
            $query->where('kategori_barang_id', $this->filterKategori);
        }

        // Filter Tipe (Medis/Umum) - Menggunakan kolom jenis_aset baru
        if ($this->tipeAset == 'medis') {
            $query->where('jenis_aset', 'Medis');
        } elseif ($this->tipeAset == 'umum') {
            $query->where('jenis_aset', 'Non-Medis');
        }

        // Filter Jenis (Aset Tetap vs Habis Pakai)
        if ($this->jenisBarang == 'aset_tetap') {
            $query->where('is_asset', true);
        } elseif ($this->jenisBarang == 'habis_pakai') {
            $query->where('is_asset', false);
        }

        $barangs = $query->latest()->paginate($this->perHalaman);
        $kategoris = KategoriBarang::orderBy('nama_kategori')->get();

        return view('livewire.barang.index', [
            'barangs' => $barangs,
            'kategoris' => $kategoris
        ])->layout('layouts.app', ['header' => 'Master Data Barang']);
    }
}
