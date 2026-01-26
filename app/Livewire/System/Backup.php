<?php

namespace App\Livewire\System;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class Backup extends Component
{
    public $backups = [];

    public function mount()
    {
        $this->refreshBackups();
    }

    public function refreshBackups()
    {
        $files = Storage::files('backups');
        $this->backups = [];
        
        foreach ($files as $file) {
            $this->backups[] = [
                'path' => $file,
                'name' => basename($file),
                'size' => $this->formatSize(Storage::size($file)),
                'date' => date('Y-m-d H:i:s', Storage::lastModified($file))
            ];
        }
        
        // Sort by newest
        usort($this->backups, function($a, $b) {
            return $b['date'] <=> $a['date'];
        });
    }

    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }

    public function createBackup()
    {
        try {
            Artisan::call('database:backup');
            $this->refreshBackups();
            $this->dispatch('notify', 'success', 'Backup database berhasil dibuat.');
        } catch (\Exception $e) {
            $this->dispatch('notify', 'error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function download($path)
    {
        return Storage::download($path);
    }

    public function delete($path)
    {
        Storage::delete($path);
        $this->refreshBackups();
        $this->dispatch('notify', 'success', 'File backup dihapus.');
    }

    public function render()
    {
        return view('livewire.system.backup')->layout('layouts.app', ['header' => 'Backup & Restore']);
    }
}