<?php

namespace App\Livewire\RekamMedis;

use App\Models\RekamMedis;
use Livewire\Component;

class Show extends Component
{
    public RekamMedis $rekamMedis;

    public function mount(RekamMedis $rekamMedis)
    {
        $this->rekamMedis = $rekamMedis->load(['pasien', 'dokter.user', 'tindakans', 'obats']);
    }

    public function render()
    {
        return view('livewire.rekam-medis.show')->layout('layouts.app', ['header' => 'Detail Rekam Medis']);
    }
}