<?php

namespace App\Livewire\Laporan;

use App\Models\RekamMedis;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Penyakit extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        // Calculate Top 10 Diseases
        // Diagnosa is stored as "Code - Name". 
        // We can use SUBSTRING_INDEX or regex, but for simplicity, let's group by the raw string.
        
        $topDiseases = RekamMedis::select('diagnosa', DB::raw('count(*) as total'))
            ->whereBetween('tanggal_periksa', [$this->startDate, $this->endDate])
            ->groupBy('diagnosa')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        return view('livewire.laporan.penyakit', [
            'topDiseases' => $topDiseases
        ])->layout('layouts.app', ['header' => 'Laporan 10 Besar Penyakit']);
    }
}