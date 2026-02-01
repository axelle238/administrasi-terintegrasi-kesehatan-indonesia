<?php

namespace App\Livewire\Pegawai;

use Livewire\Component;
use App\Models\Pegawai;

class Show extends Component
{
    public $pegawai;
    public $activeTab = 'profil';

    public function mount($id)
    {
        $this->pegawai = Pegawai::with(['user', 'poli'])->findOrFail($id);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.pegawai.show')->layout('layouts.app', ['header' => 'Dossier Pegawai']);
    }
}