<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\Permission;

class PermissionDiscoveryService
{
    // Definisi Mapping Modul untuk Pengelompokan yang Rapi
    protected $moduleMap = [
        'Manajemen Kepegawaian (HRIS)' => [
            'hrd', 'pegawai', 'kepegawaian', 'shift', 'jadwal-jaga', 
            'mutasi', 'diklat', 'kredensial', 'cuti', 'lembur', 
            'kinerja', 'offboarding', 'aset-pegawai'
        ],
        'Layanan Medis & Pasien' => [
            'medical', 'rekam-medis', 'antrean', 'rawat-inap', 
            'tindakan', 'surat.keterangan', 'pasien', 'surat'
        ],
        'Farmasi & Obat' => [
            'pharmacy', 'obat', 'apotek', 'transaksi-obat'
        ],
        'Kesehatan Masyarakat (UKM)' => [
            'ukm', 'masyarakat', 'survey'
        ],
        'Keuangan & Kasir' => [
            'finance', 'kasir', 'pembayaran'
        ],
        'Aset & Inventaris Barang' => [
            'barang', 'supplier', 'ruangan', 'kategori-barang'
        ],
        'Sistem & Keamanan' => [
            'system', 'security', 'activity-log', 'admin'
        ],
        'Layanan Publik' => [
            'public', 'pengaduan'
        ],
        'Profil Pengguna' => [
            'profile', 'notifications'
        ]
    ];

    /**
     * Memindai semua rute terdaftar dan menyinkronkannya ke tabel permissions.
     */
    public function discover()
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $name = $route->getName();

            // Skip rute internal framework
            if (!$name || 
                Str::startsWith($name, ['ignition.', 'sanctum.', 'livewire.', 'logout', 'verification.', 'password.']) ||
                Str::startsWith($name, '_')) {
                continue;
            }

            $groupName = $this->determineGroup($name);
            $readableName = $this->humanizeName($name);

            // Gunakan updateOrCreate agar Nama Grup dan Readable Name ter-update jika logika berubah
            Permission::updateOrCreate(
                ['name' => $name], // Kunci pencarian (Nama Rute tidak berubah)
                [
                    'group_name' => $groupName,
                    'readable_name' => $readableName,
                    'guard_name' => 'web'
                ]
            );
        }
    }

    /**
     * Menentukan Grup berdasarkan Nama Rute
     */
    private function determineGroup($routeName)
    {
        // 1. Cek Dashboard Spesifik
        if (str_contains($routeName, 'dashboard')) {
            if ($routeName === 'dashboard') return 'Dashboard Utama'; // Dashboard Global
            
            // Cek prefix untuk dashboard spesifik
            foreach ($this->moduleMap as $group => $prefixes) {
                foreach ($prefixes as $prefix) {
                    if (str_starts_with($routeName, $prefix . '.')) {
                        return $group;
                    }
                }
            }
        }

        // 2. Cek Mapping Modul Umum
        foreach ($this->moduleMap as $group => $prefixes) {
            foreach ($prefixes as $prefix) {
                // Cek exact match atau prefix match dengan dot
                if ($routeName === $prefix || str_starts_with($routeName, $prefix . '.') || str_contains($routeName, '.' . $prefix . '.')) {
                    return $group;
                }
            }
        }

        // 3. Fallback: Ekstrak dari kata pertama jika tidak ada di map
        $parts = explode('.', $routeName);
        return 'Modul ' . Str::title($parts[0]);
    }

    /**
     * Membuat nama yang mudah dibaca.
     */
    private function humanizeName($routeName)
    {
        $parts = explode('.', $routeName);
        $action = end($parts);
        
        // Custom labels untuk aksi umum
        $actionMap = [
            'index' => 'Lihat Data / Akses Menu',
            'create' => 'Tambah Data',
            'store' => 'Simpan Data Baru',
            'show' => 'Lihat Detail',
            'edit' => 'Edit Data',
            'update' => 'Simpan Perubahan',
            'destroy' => 'Hapus Data',
            'print' => 'Cetak Dokumen',
            'export' => 'Export Data',
            'manage' => 'Kelola Data',
            'dashboard' => 'Akses Dashboard',
        ];

        // Deteksi jika ini rute dashboard
        if (str_contains($routeName, 'dashboard')) {
            $prefix = $parts[0] === 'dashboard' ? 'Utama' : Str::title($parts[0]);
            if ($prefix == 'Hrd' || $prefix == 'Kepegawaian') $prefix = 'HRD & Pegawai';
            if ($prefix == 'Ukm') $prefix = 'UKM';
            return "Akses Dashboard $prefix";
        }

        $baseName = isset($actionMap[$action]) ? $actionMap[$action] : Str::title(str_replace('-', ' ', $action));
        
        // Tambahkan konteks jika perlu
        if (count($parts) > 1) {
            $context = Str::title(str_replace('-', ' ', $parts[count($parts)-2]));
            // Jika context belum ada di baseName, tambahkan
            if (!str_contains(strtolower($baseName), strtolower($context)) && !in_array($action, ['index', 'create', 'edit', 'show'])) {
                // return "$baseName $context";
            }
        }

        return $baseName . " (" . implode(' ', array_map(fn($p) => Str::title(str_replace('-', ' ', $p)), array_slice($parts, 0, -1))) . ")";
    }
}