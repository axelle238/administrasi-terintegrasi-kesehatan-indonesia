<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\RiwayatBarang;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterKategori = '';
    public $filterTipe = 'all'; // all, medis, umum
    public $perPage = 10;

    // Properties untuk Modal Detail (Kartu Stok)
    public $selectedBarangId;
    public $selectedBarang;
    public $riwayatTransaksi = [];
    public $isDetailOpen = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showDetail($id)
    {
        $this->selectedBarangId = $id;
        $this->selectedBarang = Barang::with(['kategori', 'ruangan', 'supplier'])->find($id);
        
        if ($this->selectedBarang) {
            $this->riwayatTransaksi = RiwayatBarang::where('barang_id', $id)
                ->with('user')
                ->latest()
                ->take(20) // Limit 20 transaksi terakhir untuk performa view
                ->get();
            
            $this->isDetailOpen = true;
        }
    }

    public function closeDetail()
    {
        $this->isDetailOpen = false;
        $this->reset(['selectedBarang', 'riwayatTransaksi']);
    }

    public function render()
    {
        $query = Barang::with(['kategori', 'ruangan']);

        // Search Logic
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('merk', 'like', '%' . $this->search . '%');
            });
        }

        // Filter Kategori
        if ($this->filterKategori) {
            $query->where('kategori_barang_id', $this->filterKategori);
        }

        // Filter Tipe (Medis vs Umum)
        if ($this->filterTipe == 'medis') {
            $query->whereHas('kategori', function($q) {
                $q->where('nama_kategori', 'like', '%Medis%')
                  ->orWhere('nama_kategori', 'like', '%Kesehatan%')
                  ->orWhere('nama_kategori', 'like', '%Alat%');
            });
        } elseif ($this->filterTipe == 'umum') {
            $query->whereHas('kategori', function($q) {
                $q->where('nama_kategori', 'not like', '%Medis%')
                  ->where('nama_kategori', 'not like', '%Kesehatan%')
                  ->where('nama_kategori', 'not like', '%Alat%');
            });
        }

        $barangs = $query->latest()->paginate($this->perPage);
        $kategoris = KategoriBarang::orderBy('nama_kategori')->get();

        return view('livewire.barang.index', [
            'barangs' => $barangs,
            'kategoris' => $kategoris
        ])->layout('layouts.app', ['header' => 'Master Data Barang']);
    }
}