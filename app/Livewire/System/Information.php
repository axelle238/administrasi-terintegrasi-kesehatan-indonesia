<?php

namespace App\Livewire\System;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Obat;
use App\Models\Pegawai;

class Information extends Component
{
    public function render()
    {
        // System Environment
        $serverInfo = [
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'server_os' => php_uname('s') . ' ' . php_uname('r'),
            'database_connection' => config('database.default'),
            'database_name' => config('database.connections.mysql.database'),
            'app_environment' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'timezone' => config('app.timezone'),
        ];

        // Database Statistics
        $stats = [
            'users' => User::count(),
            'patients' => Pasien::count(),
            'medicines' => Obat::count(),
            'employees' => Pegawai::count(),
            // Add more counts as needed
        ];

        // Table Status (MySQL specific)
        $tables = DB::select('SHOW TABLE STATUS');
        $dbSize = 0;
        foreach ($tables as $table) {
            $dbSize += $table->Data_length + $table->Index_length;
        }
        $dbSizeMB = round($dbSize / 1024 / 1024, 2);

        return view('livewire.system.information', [
            'serverInfo' => $serverInfo,
            'stats' => $stats,
            'dbSizeMB' => $dbSizeMB,
            'tableCount' => count($tables)
        ])->layout('layouts.app', ['header' => 'Informasi Sistem & Server']);
    }
}
