<?php

namespace App\Livewire\Obat;

use App\Models\Obat;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $obat = Obat::find($id);
        if ($obat) {
            $obat->delete();
            $this->dispatch('notify', 'success', 'Data obat berhasil dihapus.');
        }
    }

    public function render()
    {
        $query = Obat::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_obat', 'like', '%' . $this->search . '%')
                  ->orWhere('kode_obat', 'like', '%' . $this->search . '%')
                  ->orWhere('jenis_obat', 'like', '%' . $this->search . '%');
            });
        }

        $obats = $query->latest()->paginate(10);

        // Dashboard Stats
        $totalObat = Obat::count();
        $stokMenipis = Obat::whereColumn('stok', '<=', 'min_stok')->count();
        $kedaluwarsa = Obat::where('tanggal_kedaluwarsa', '<=', now()->addMonths(3))->count();
        $nilaiAset = Obat::selectRaw('SUM(stok * harga_satuan) as total')->value('total');

        return view('livewire.obat.index', [
            'obats' => $obats,
            'totalObat' => $totalObat,
            'stokMenipis' => $stokMenipis,
            'kedaluwarsa' => $kedaluwarsa,
            'nilaiAset' => $nilaiAset
        ])->layout('layouts.app', ['header' => 'Manajemen Farmasi & Obat']);
    }
}