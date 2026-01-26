<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class FrontendSettingSeeder extends Seeder
{
    public function run(): void
    {
        // Identitas Instansi
        Setting::simpan('app_name', 'SATRIA', 'text', 'Nama Aplikasi/Instansi');
        Setting::simpan('app_tagline', 'Sistem Administrasi Terintegrasi Kesehatan Indonesia', 'text', 'Tagline Aplikasi');
        Setting::simpan('app_description', 'Platform administrasi terintegrasi yang menghubungkan pasien, tenaga medis, dan manajemen fasilitas kesehatan dalam satu ekosistem cerdas.', 'text', 'Deskripsi Aplikasi');
        
        // Kontak
        Setting::simpan('app_phone', '(021) 123-4567', 'text', 'Nomor Telepon');
        Setting::simpan('app_email', 'kontak@satria-health.id', 'text', 'Alamat Email');
        Setting::simpan('app_address', 'Jl. Kesehatan No. 1, Jakarta Selatan', 'text', 'Alamat Lengkap');

        // Hero Section
        Setting::simpan('hero_title', 'Transformasi Digital Layanan Kesehatan Paripurna', 'text', 'Judul Utama Halaman Depan');
        Setting::simpan('hero_subtitle', 'Solusi kesehatan digital masa depan untuk Indonesia yang lebih sehat.', 'text', 'Sub-judul Halaman Depan');
        
        // Fitur Unggulan (JSON)
        $features = [
            [
                'title' => 'Rekam Medis Elektronik',
                'desc' => 'Data pasien terpusat, aman, dan dapat diakses real-time oleh tenaga medis berwenang.',
                'icon' => 'clipboard-document-list'
            ],
            [
                'title' => 'Farmasi Pintar',
                'desc' => 'Manajemen stok obat otomatis dengan sistem peringatan dini kedaluwarsa.',
                'icon' => 'beaker'
            ],
            [
                'title' => 'Analitik & Pelaporan',
                'desc' => 'Dashboard analitik komprehensif untuk memantau kinerja operasional.',
                'icon' => 'chart-bar'
            ]
        ];
        Setting::simpan('landing_features', json_encode($features), 'json', 'Daftar Fitur Unggulan');
    }
}