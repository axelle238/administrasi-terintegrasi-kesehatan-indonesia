<?php

namespace App\Livewire\Apotek;

use App\Models\RekamMedis;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        // Get prescriptions waiting for processing
        $antreanResep = RekamMedis::where('status_resep', 'Menunggu Obat')
            ->with(['pasien', 'dokter'])
            ->latest()
            ->paginate(10);
            
        return view('livewire.apotek.index', [
            'antreanResep' => $antreanResep
        ])->layout('layouts.app', ['header' => 'Antrean Resep (Farmasi)']);
    }
}