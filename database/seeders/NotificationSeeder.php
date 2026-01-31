<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Services\NotifikasiService;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            // 1. Info System
            NotifikasiService::send(
                $admin, 
                'Selamat Datang di SATRIA v2.0', 
                'Sistem telah diperbarui dengan fitur notifikasi real-time terbaru. Nikmati pengalaman yang lebih responsif.',
                route('system.info'),
                'info'
            );

            // 2. Warning Stok
            NotifikasiService::send(
                $admin,
                'Stok Obat Menipis',
                'Stok Paracetamol 500mg di Gudang Utama tersisa kurang dari 50 kotak. Harap segera lakukan restock.',
                route('obat.index'),
                'warning'
            );

            // 3. Danger / Error
            NotifikasiService::send(
                $admin,
                'Gagal Backup Database',
                'Proses backup otomatis gagal pada pukul 02:00 WIB. Ruang penyimpanan server hampir penuh.',
                route('system.backup'),
                'danger'
            );

            // 4. Success
            NotifikasiService::send(
                $admin,
                'Laporan Bulanan Siap',
                'Laporan keuangan bulan Januari 2026 telah berhasil digenerate dan siap untuk diunduh.',
                route('finance.dashboard'),
                'success'
            );

            // 5. Urgent
            NotifikasiService::send(
                $admin,
                'Persetujuan Cuti Mendesak',
                'dr. Andi mengajukan cuti mendadak untuk besok. Menunggu persetujuan Admin/HRD segera.',
                route('kepegawaian.cuti.index'),
                'urgent'
            );
        }
    }
}
