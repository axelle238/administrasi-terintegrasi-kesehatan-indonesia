<?php

namespace App\Livewire\System\Role;

use Livewire\Component;
use App\Models\User;

class Index extends Component
{
    public function render()
    {
        // Definisi Role dan Hak Akses Statis (Sesuai Konvensi Sistem)
        $roles = [
            'admin' => [
                'name' => 'Administrator Sistem',
                'description' => 'Memiliki akses penuh ke seluruh modul sistem, pengaturan, dan manajemen pengguna.',
                'color' => 'purple',
                'users_count' => User::where('role', 'admin')->count(),
                'permissions' => [
                    'Mengelola User & Role',
                    'Mengakses Dashboard Keamanan',
                    'Konfigurasi Sistem Global',
                    'Melihat Semua Laporan',
                    'Backup & Restore Database'
                ]
            ],
            'dokter' => [
                'name' => 'Dokter Medis',
                'description' => 'Tenaga medis profesional yang menangani pemeriksaan pasien dan rekam medis.',
                'color' => 'green',
                'users_count' => User::where('role', 'dokter')->count(),
                'permissions' => [
                    'Akses Dashboard Medis',
                    'Input Rekam Medis (SOAP)',
                    'Resep Elektronik',
                    'Melihat Riwayat Pasien',
                    'Tindakan Medis'
                ]
            ],
            'perawat' => [
                'name' => 'Perawat',
                'description' => 'Membantu dokter dalam pelayanan, tanda-tanda vital, dan administrasi bangsal.',
                'color' => 'blue',
                'users_count' => User::where('role', 'perawat')->count(),
                'permissions' => [
                    'Dashboard Medis (Terbatas)',
                    'Input Tanda Vital (TTV)',
                    'Manajemen Rawat Inap',
                    'Asuhan Keperawatan',
                    'Triase Awal'
                ]
            ],
            'apoteker' => [
                'name' => 'Apoteker / Farmasi',
                'description' => 'Bertanggung jawab atas pengelolaan obat, stok farmasi, dan penyerahan resep.',
                'color' => 'yellow',
                'users_count' => User::where('role', 'apoteker')->count(),
                'permissions' => [
                    'Dashboard Farmasi',
                    'Manajemen Stok Obat',
                    'Proses Resep Dokter',
                    'Laporan Narkotika/Psikotropika',
                    'Stok Opname Farmasi'
                ]
            ],
            'staf' => [
                'name' => 'Staf Administrasi',
                'description' => 'Menangani pendaftaran, kasir, dan administrasi umum.',
                'color' => 'gray',
                'users_count' => User::where('role', 'staf')->count(),
                'permissions' => [
                    'Dashboard Utama',
                    'Pendaftaran Pasien',
                    'Kasir & Pembayaran',
                    'Manajemen Antrean',
                    'Data Master Pasien'
                ]
            ],
            'tata_usaha' => [
                'name' => 'Tata Usaha (TU)',
                'description' => 'Mengelola aset, surat menyurat, dan kepegawaian non-medis.',
                'color' => 'orange',
                'users_count' => User::where('role', 'tata_usaha')->count(),
                'permissions' => [
                    'Manajemen Aset & Barang',
                    'Sistem Persuratan',
                    'Kepegawaian Dasar',
                    'Inventaris Umum'
                ]
            ]
        ];

        return view('livewire.system.role.index', [
            'roles' => $roles
        ])->layout('layouts.app', ['header' => 'Manajemen Hak Akses & Peran']);
    }
}