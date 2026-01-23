<?php

namespace App\Livewire\Barang;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;

class Ruangan extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedLocation = '';
    public $locations = [];

    public function mount()
    {
        // Get unique locations from database
        $this->locations = Barang::whereNotNull('lokasi_penyimpanan')
            ->where('lokasi_penyimpanan', '!=', '')
            ->distinct()
            ->pluck('lokasi_penyimpanan')
            ->sort()
            ->values()
            ->toArray();
            
        // Select first location by default if available
        if (!empty($this->locations)) {
            $this->selectedLocation = $this->locations[0];
        }
    }

    public function updatedSelectedLocation()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Barang::query();

        if ($this->selectedLocation) {
            $query->where('lokasi_penyimpanan', $this->selectedLocation);
        }

        if ($this->search) {
            $query->where('nama_barang', 'like', '%' . $this->search . '%');
        }

        $barangs = $query->with('kategori')
            ->orderBy('nama_barang')
            ->paginate(12);

        return view('livewire.barang.ruangan', [
            'barangs' => $barangs
        ])->layout('layouts.app', ['header' => 'Kartu Inventaris Ruangan (KIR)']);
    }
}