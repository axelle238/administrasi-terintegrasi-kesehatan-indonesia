<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        Fasilitas::create([
            'nama_fasilitas' => 'Laboratorium Patologi',
            'deskripsi' => 'Fasilitas laboratorium lengkap dengan peralatan canggih untuk pemeriksaan patologi klinik dan anatomi dengan hasil akurat.',
            'jenis' => 'medis',
            'is_active' => true,
        ]);

        Fasilitas::create([
            'nama_fasilitas' => 'IGD 24 Jam',
            'deskripsi' => 'Unit Gawat Darurat yang siap melayani pasien dalam kondisi kritis 24 jam sehari, 7 hari seminggu dengan dokter jaga standby.',
            'jenis' => 'unggulan',
            'is_active' => true,
        ]);

        Fasilitas::create([
            'nama_fasilitas' => 'Ruang Rawat Inap VVIP',
            'deskripsi' => 'Kamar rawat inap kelas VVIP dengan fasilitas setara hotel bintang 3, mencakup AC, TV, Kulkas, dan Sofa Bed penunggu.',
            'jenis' => 'non-medis',
            'is_active' => true,
        ]);

        Fasilitas::create([
            'nama_fasilitas' => 'Ambulans Gawat Darurat',
            'deskripsi' => 'Armada ambulans lengkap dengan peralatan life support standar ICU Mobile untuk evakuasi pasien kritis.',
            'jenis' => 'medis',
            'is_active' => true,
        ]);
    }
}