<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user (admin)
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin Sistem',
            'email' => 'admin@satria.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        Berita::create([
            'judul' => 'Pentingnya Deteksi Dini Penyakit Tidak Menular',
            'slug' => Str::slug('Pentingnya Deteksi Dini Penyakit Tidak Menular'),
            'konten' => 'Skrining kesehatan secara berkala sangat penting untuk mencegah komplikasi penyakit tidak menular seperti hipertensi dan diabetes. Lakukan pemeriksaan rutin di Puskesmas terdekat minimal 6 bulan sekali.',
            'kategori' => 'Kesehatan',
            'status' => 'published',
            'user_id' => $user->id,
            'thumbnail' => null, // null akan memunculkan placeholder
            'created_at' => now()->subHours(2),
        ]);

        Berita::create([
            'judul' => 'Jadwal Pekan Imunisasi Nasional Terbaru',
            'slug' => Str::slug('Jadwal Pekan Imunisasi Nasional Terbaru'),
            'konten' => 'Informasi lengkap mengenai jadwal dan lokasi posyandu terdekat untuk Pekan Imunisasi Nasional (PIN) Polio. Segera bawa balita Anda untuk mendapatkan tetes manis pencegah polio.',
            'kategori' => 'Imunisasi',
            'status' => 'published',
            'user_id' => $user->id,
            'thumbnail' => null,
            'created_at' => now()->subDays(1),
        ]);

        Berita::create([
            'judul' => 'Cara Menjaga Kesehatan Mata di Era Digital',
            'slug' => Str::slug('Cara Menjaga Kesehatan Mata di Era Digital'),
            'konten' => 'Mata lelah akibat sering menatap layar? Gunakan aturan 20-20-20: Setiap 20 menit menatap layar, istirahatkan mata selama 20 detik dengan melihat objek sejauh 20 kaki.',
            'kategori' => 'Tips Sehat',
            'status' => 'published',
            'user_id' => $user->id,
            'thumbnail' => null,
            'created_at' => now()->subDays(3),
        ]);
    }
}