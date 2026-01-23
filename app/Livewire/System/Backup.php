<?php

namespace App\Livewire\System;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Backup extends Component
{
    public $backups = [];

    public function mount()
    {
        // Scan storage/app/backup (Simulation)
        $this->backups = [
            ['name' => 'backup-2025-01-01.zip', 'size' => '5.2MB', 'date' => '2025-01-01 00:00'],
            ['name' => 'backup-2025-01-02.zip', 'size' => '5.3MB', 'date' => '2025-01-02 00:00'],
        ];
    }

    public function createBackup()
    {
        // In real app: Artisan::call('backup:run');
        // Here simulation
        $name = 'backup-' . date('Y-m-d-His') . '.zip';
        $this->backups[] = ['name' => $name, 'size' => '5.5MB', 'date' => now()->toDateTimeString()];
        
        $this->dispatch('notify', 'success', 'Backup baru berhasil dibuat.');
    }

    public function download($name)
    {
        // return Storage::download('backup/'.$name);
        $this->dispatch('notify', 'info', 'Mendownload ' . $name);
    }

    public function delete($index)
    {
        unset($this->backups[$index]);
        $this->backups = array_values($this->backups);
        $this->dispatch('notify', 'success', 'File backup dihapus.');
    }

    public function render()
    {
        return view('livewire.system.backup')->layout('layouts.app', ['header' => 'Backup & Restore Database']);
    }
}
