<?php

namespace App\Livewire\KategoriBarang;

use App\Models\KategoriBarang;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $kategori = KategoriBarang::find($id);
        
        if ($kategori) {
            if ($kategori->barangs()->count() > 0) {
                $this->dispatch('notify', 'error', 'Gagal hapus: Kategori ini masih memiliki data barang.');
                return;
            }

            $kategori->delete();
            $this->dispatch('notify', 'success', 'Kategori barang berhasil dihapus.');
        }
    }

    public function render()
    {
        $kategoris = KategoriBarang::withCount('barangs')
            ->where('nama_kategori', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.kategori-barang.index', [
            'kategoris' => $kategoris
        ])->layout('layouts.app', ['header' => 'Kategori Barang (Inventaris)']);
    }
}