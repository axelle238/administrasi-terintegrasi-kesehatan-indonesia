<?php

namespace App\Livewire\Pegawai\Tabs;

use Livewire\Component;
use App\Models\Pegawai;

class Profil extends Component
{
    public $pegawai;

    public function mount(Pegawai $pegawai)
    {
        $this->pegawai = $pegawai;
    }

    public function render()
    {
        return view('livewire.pegawai.tabs.profil');
    }
}