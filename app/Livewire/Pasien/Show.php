<?php

namespace App\Livewire\Pasien;

use App\Models\Pasien;
use App\Models\RekamMedis;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Pasien $pasien;

    public function mount(Pasien $pasien)
    {
        $this->pasien = $pasien;
    }

    public function render()
    {
        $riwayatMedis = RekamMedis::where('pasien_id', $this->pasien->id)
            ->with(['dokter.user', 'poli']) // Adjust based on RekamMedis relations
            ->latest()
            ->paginate(5);

        return view('livewire.pasien.show', [
            'riwayatMedis' => $riwayatMedis
        ])->layout('layouts.app', ['header' => 'Detail Pasien']);
    }
}