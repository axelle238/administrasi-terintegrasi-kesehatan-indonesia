<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\Permission;

class PermissionDiscoveryService
{
    /**
     * Memindai semua rute terdaftar dan menyinkronkannya ke tabel permissions.
     */
    public function discover()
    {
        $routes = Route::getRoutes();
        $permissions = [];

        foreach ($routes as $route) {
            $name = $route->getName();

            // Skip rute tanpa nama, rute debug, rute ignition/telescope, dan rute public/auth dasar
            if (!$name || 
                Str::startsWith($name, ['ignition.', 'sanctum.', 'livewire.', 'profile.', 'logout', 'verification.', 'password.']) ||
                Str::startsWith($name, '_')) {
                continue;
            }

            // Skip jika middleware tidak mengandung 'auth' (Opsional: kita anggap semua named route butuh permission)
            // if (!in_array('auth', $route->gatherMiddleware())) continue;

            $groupName = $this->extractGroup($name);
            $readableName = $this->humanizeName($name);

            // Simpan / Update Permission
            Permission::firstOrCreate(
                ['name' => $name],
                [
                    'group_name' => $groupName,
                    'readable_name' => $readableName,
                    'guard_name' => 'web'
                ]
            );
        }
    }

    /**
     * Mengelompokkan rute berdasarkan prefix.
     * Contoh: 'pegawai.create' -> 'Pegawai'
     */
    private function extractGroup($routeName)
    {
        $parts = explode('.', $routeName);
        
        // Ambil bagian pertama sebagai grup
        $group = $parts[0];

        // Jika diawali 'admin.', ambil bagian kedua
        if ($group === 'admin' && isset($parts[1])) {
            $group = 'Admin ' . ucfirst($parts[1]);
        } elseif ($group === 'kepegawaian' && isset($parts[1])) {
            $group = 'Kepegawaian ' . ucfirst($parts[1]); // Sub-grup kepegawaian
        }

        return Str::title(str_replace('-', ' ', $group));
    }

    /**
     * Membuat nama yang mudah dibaca.
     * Contoh: 'pegawai.create' -> 'Buat Data Pegawai'
     */
    private function humanizeName($routeName)
    {
        $parts = explode('.', $routeName);
        $action = end($parts);
        
        $map = [
            'index' => 'Lihat Daftar',
            'create' => 'Tambah Data',
            'store' => 'Simpan Data',
            'show' => 'Lihat Detail',
            'edit' => 'Edit Data',
            'update' => 'Update Data',
            'destroy' => 'Hapus Data',
            'print' => 'Cetak Laporan',
            'export' => 'Export Data',
        ];

        if (isset($map[$action])) {
            return $map[$action];
        }

        return Str::title(str_replace(['.', '-'], ' ', $routeName));
    }
}
