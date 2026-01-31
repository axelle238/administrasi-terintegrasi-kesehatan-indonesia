<?php

namespace App\Livewire\System\Role;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.system.role.index')->layout('layouts.app', ['header' => 'Manajemen Hak Akses']);
    }
}