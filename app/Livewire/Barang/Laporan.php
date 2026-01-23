<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\RiwayatBarang;
use Livewire\Component;
use Livewire\WithPagination;

class Laporan extends Component
{
    use WithPagination;

    public $jenis_laporan = 'stok'; // stok, mutasi, aset
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $kategori_filter = '';

    public function mount()
    {
        $this->tanggal_mulai = now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_selesai = now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $data = [];

        if ($this->jenis_laporan == 'stok') {
            $query = Barang::query();
            if ($this->kategori_filter) {
                $query->where('kategori_barang_id', $this->kategori_filter);
            }
            $data = $query->orderBy('nama_barang')->paginate(20);
        } 
        elseif ($this->jenis_laporan == 'mutasi') {
            $query = RiwayatBarang::with(['barang', 'user'])
                ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_selesai]);
            
            if ($this->kategori_filter) {
                $query->whereHas('barang', function($q) {
                    $q->where('kategori_barang_id', $this->kategori_filter);
                });
            }
            $data = $query->latest()->paginate(20);
        }
        elseif ($this->jenis_laporan == 'aset') {
            $query = Barang::where('is_asset', true);
            if ($this->kategori_filter) {
                $query->where('kategori_barang_id', $this->kategori_filter);
            }
            $data = $query->orderBy('nama_barang')->paginate(20);
        }

        return view('livewire.barang.laporan', [
            'data' => $data,
            'kategoris' => \App\Models\KategoriBarang::all()
        ])->layout('layouts.app', ['header' => 'Laporan Inventaris']);
    }
}
