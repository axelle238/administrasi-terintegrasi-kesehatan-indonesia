<?php

namespace App\Livewire\System\Integration;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.system.integration.index')->layout('layouts.app', ['header' => 'Status Integrasi Sistem']);
    }
}