<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingComponent;

class LandingComponentSeeder extends Seeder
{
    public function run(): void
    {
        $components = [
            [
                'section_key' => 'hero',
                'title' => 'Sehat Lebih Mudah Bersama Kami',
                'subtitle' => 'Layanan Kesehatan Modern',
                'content' => 'Akses layanan kesehatan terpadu mulai dari pendaftaran antrean, konsultasi dokter, hingga riwayat medis dalam satu genggaman.',
                'image' => null, // Gunakan default di view jika null
                'metadata' => [
                    'cta_primary_text' => 'Daftar Berobat',
                    'cta_primary_url' => 'antrean.monitor',
                    'cta_secondary_text' => 'Cek Jadwal Dokter',
                    'cta_secondary_url' => '#jadwal',
                    'trust_1' => 'Terverifikasi',
                    'trust_2' => 'Data Aman',
                    'trust_3' => 'Pelayanan Ramah',
                ],
                'order' => 1,
            ],
            [
                'section_key' => 'stats',
                'title' => 'Statistik Layanan',
                'subtitle' => 'Data Realtime',
                'content' => null,
                'metadata' => [
                    'label_1' => 'Dokter Ahli',
                    'label_2' => 'Poliklinik',
                    'label_3' => 'Pasien Terdaftar',
                    'label_4' => 'Layanan UGD',
                ],
                'order' => 5, // Di bawah
            ],
            [
                'section_key' => 'footer',
                'title' => 'Kontak & Info',
                'subtitle' => null,
                'content' => 'Sistem Kesehatan Terintegrasi',
                'metadata' => [
                    'address' => 'Jl. Kesehatan No. 1, Jakarta',
                    'phone' => '+62 21 5555 6666',
                    'email' => 'info@satria-health.id',
                ],
                'order' => 10,
            ],
        ];

        foreach ($components as $comp) {
            LandingComponent::updateOrCreate(
                ['section_key' => $comp['section_key']],
                $comp
            );
        }
    }
}