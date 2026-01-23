<?php

namespace App\Livewire\Obat;

use App\Models\Obat;
use App\Models\ObatBatch;
use Livewire\Component;
use Carbon\Carbon;

class Ews extends Component
{
    public function render()
    {
        $threeMonths = Carbon::now()->addMonths(3);
        $sixMonths = Carbon::now()->addMonths(6);

        $expiredSoon = ObatBatch::with('obat')
            ->where('stok', '>', 0)
            ->where('tanggal_kedaluwarsa', '<=', $sixMonths)
            ->orderBy('tanggal_kedaluwarsa', 'asc')
            ->get();

        $criticalStock = Obat::whereColumn('stok', '<=', 'min_stok')->get();

        return view('livewire.obat.ews', [
            'expiredSoon' => $expiredSoon,
            'criticalStock' => $criticalStock
        ])->layout('layouts.app', ['header' => 'Early Warning System (EWS) Farmasi']);
    }
}
