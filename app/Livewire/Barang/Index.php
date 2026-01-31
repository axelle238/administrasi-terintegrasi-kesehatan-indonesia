<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public $cari = '';
    public $filterKategori = '';
    public $tipeAset = 'semua'; // semua, medis, umum
    public $jenisBarang = 'semua'; // semua, aset_tetap, habis_pakai
    public $perHalaman = 10;
    
    // Fitur Barcode Scanner
    public $scanCode = '';

    // Fitur Recycle Bin
    public $modeTampilan = 'aktif'; // aktif, sampah

    public function performScan()
    {
        $this->validate([
            'scanCode' => 'required|string'
        ]);

        // Cari Barang (Exact Match)
        $barang = Barang::where('kode_barang', $this->scanCode)->first();

        if ($barang) {
            // Jika ditemukan, redirect langsung ke detail
            $this->reset('scanCode');
            return redirect()->route('barang.show', $barang->id);
        } else {
            // Jika tidak, beri notifikasi error dan reset input
            $this->addError('scanCode', 'Aset dengan kode tersebut tidak ditemukan.');
            $this->scanCode = '';
            $this->dispatch('focus-scan'); // Kembalikan fokus ke input
        }
    }

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

    public function gantiModeTampilan($mode)
    {
        $this->modeTampilan = $mode;
        $this->resetPage();
    }

    // 1. Hapus Sementara (Soft Delete)
    public function buangKeSampah($id)
    {
        $barang = Barang::find($id);
        if ($barang) {
            $barang->delete(); // Soft delete via Trait
            $this->dispatch('notify', 'success', 'Aset dipindahkan ke Tong Sampah.');
        }
    }

    // 2. Pulihkan Data (Restore)
    public function pulihkan($id)
    {
        $barang = Barang::onlyTrashed()->find($id);
        if ($barang) {
            $barang->restore();
            $this->dispatch('notify', 'success', 'Aset berhasil dipulihkan kembali.');
        }
    }

    // 3. Hapus Permanen (Force Delete)
    public function hapusPermanen($id)
    {
        $barang = Barang::onlyTrashed()->find($id);
        if ($barang) {
            // Hapus gambar fisik jika ada
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
            // Hapus galeri terkait
            foreach($barang->images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
            
            $barang->forceDelete();
            $this->dispatch('notify', 'success', 'Aset dihapus permanen dari sistem.');
        }
    }

    public function render()
    {
        // Query Dasar
        $query = Barang::with(['kategori', 'ruangan']);

        // Filter Mode: Aktif vs Sampah
        if ($this->modeTampilan == 'sampah') {
            $query->onlyTrashed();
        }

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

        // Filter Tipe (Medis/Umum)
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
        
        // Data Tambahan
        $kategoris = KategoriBarang::orderBy('nama_kategori')->get();
        $jumlahSampah = Barang::onlyTrashed()->count();

        return view('livewire.barang.index', [
            'barangs' => $barangs,
            'kategoris' => $kategoris,
            'jumlahSampah' => $jumlahSampah
        ])->layout('layouts.app', ['header' => 'Master Data Barang']);
    }
}