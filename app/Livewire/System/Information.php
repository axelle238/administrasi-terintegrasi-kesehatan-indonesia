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

        // System Capabilities
        $capabilities = [
            'Layanan Medis' => [
                'Manajemen Antrean & Triage otomatis',
                'Rekam Medis Elektronik (RME) standar SOAP',
                'Integrasi Diagnosa ICD-10',
                'Manajemen Rawat Inap & Monitoring Kamar',
                'Surat Keterangan Sakit/Sehat Otomatis',
                'Odontogram Digital (Poli Gigi)',
            ],
            'Farmasi & Obat' => [
                'Inventaris Obat & Bahan Medis Habis Pakai (BMHP)',
                'Kartu Stok Otomatis (Masuk/Keluar)',
                'Early Warning System (EWS) Kedaluwarsa Obat',
                'Laporan LPLPO & Narkotika Psikotropika',
                'Layanan Resep Digital end-to-end',
            ],
            'Keuangan & Billing' => [
                'Billing Otomatis terintegrasi Tindakan & Obat',
                'Dukungan Pembayaran Pasien Umum & BPJS',
                'Laporan Pendapatan Harian/Bulanan',
                'Manajemen Payroll (Gaji) Pegawai Terintegrasi',
            ],
            'Administrasi & SDM' => [
                'Database Pegawai Lengkap (STR, SIP, Ijazah)',
                'Manajemen Jadwal Jaga & Shift Kerja',
                'Monitoring Kinerja Pegawai',
                'Sistem Persuratan Digital (Masuk/Keluar/Disposisi)',
                'Pengajuan Cuti Online',
            ],
            'Aset & Fasilitas' => [
                'Inventaris Barang & Aset Tetap',
                'Manajemen Lokasi/Ruangan',
                'Log Pemeliharaan & Kalibrasi Berkala',
                'Perhitungan Penyusutan Aset otomatis',
                'Manajemen Pengadaan & Penghapusan Barang',
            ],
            'Masyarakat' => [
                'Landing Page Dinamis (Kontrol via Dashboard)',
                'Portal Pengaduan Masyarakat Online',
                'Survei Kepuasan Masyarakat (IKM)',
                'Monitor Antrean Real-time (Layar Publik)',
            ],
            'Sistem Internal' => [
                'Log Aktivitas Audit Trail (Spatie Log)',
                'Backup Database Otomatis',
                'Manajemen Hak Akses (RBAC) Berlapis',
                'Integrasi API (BPJS PCare, SatuSehat ready)',
            ]
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
            'capabilities' => $capabilities,
            'dbSizeMB' => $dbSizeMB,
            'tableCount' => count($tables)
        ])->layout('layouts.app', ['header' => 'Informasi Sistem & Server']);
    }
}
