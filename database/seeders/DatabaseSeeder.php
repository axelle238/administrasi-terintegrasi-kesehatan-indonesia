<?php

namespace Database\Seeders;

use App\Models\Poli;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\KategoriBarang;
use App\Models\Barang;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Shift;
use App\Models\JadwalJaga;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Buat Poli
        $poliUmum = Poli::create(['nama_poli' => 'Poli Umum', 'kode_poli' => 'P-001']);
        $poliGigi = Poli::create(['nama_poli' => 'Poli Gigi', 'kode_poli' => 'P-002']);
        $poliKia = Poli::create(['nama_poli' => 'Poli KIA', 'kode_poli' => 'P-003']);
        $poliGizi = Poli::create(['nama_poli' => 'Poli Gizi', 'kode_poli' => 'P-004']);

        // 1. Buat User Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@sipujaga.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        Pegawai::create([
            'user_id' => $admin->id,
            'nip' => '199001012024011001',
            'jabatan' => 'Kepala Tata Usaha',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Jagakarsa No. 1',
            'status_kepegawaian' => 'PNS',
            'tanggal_masuk' => '2020-01-01',
        ]);

        // 2. Buat User Dokter
        $dokter = User::create([
            'name' => 'dr. Budi Santoso',
            'email' => 'dokter@sipujaga.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);

        Pegawai::create([
            'user_id' => $dokter->id,
            'nip' => '198505052010011002',
            'jabatan' => 'Dokter Umum',
            'poli_id' => $poliUmum->id, // Assign Poli Umum
            'no_telepon' => '081298765432',
            'alamat' => 'Jl. Kebagusan Raya',
            'status_kepegawaian' => 'PNS',
            'tanggal_masuk' => '2015-05-01',
        ]);

        // 3. Buat User Apoteker
        $apoteker = User::create([
            'name' => 'Apt. Siti Rahma',
            'email' => 'apoteker@sipujaga.com',
            'password' => Hash::make('password'),
            'role' => 'apoteker',
        ]);

        Pegawai::create([
            'user_id' => $apoteker->id,
            'nip' => '199202022019012003',
            'jabatan' => 'Kepala Farmasi',
            'no_telepon' => '081345678901',
            'alamat' => 'Jl. Lenteng Agung',
            'status_kepegawaian' => 'PNS',
            'tanggal_masuk' => '2019-02-01',
        ]);

        // 4. Buat User Staf (Pendaftaran/Kasir)
        $staf = User::create([
            'name' => 'Rina Staff',
            'email' => 'staf@sipujaga.com',
            'password' => Hash::make('password'),
            'role' => 'staf',
        ]);

        Pegawai::create([
            'user_id' => $staf->id,
            'nip' => '199505052020012004',
            'jabatan' => 'Staf Administrasi',
            'no_telepon' => '081234567000',
            'alamat' => 'Jl. Ciganjur',
            'status_kepegawaian' => 'Kontrak',
            'tanggal_masuk' => '2020-05-01',
        ]);

        // 5. Buat Kategori Barang & Barang
        $katMedis = KategoriBarang::create(['nama_kategori' => 'Alat Medis', 'deskripsi' => 'Alat kesehatan']);
        $katUmum = KategoriBarang::create(['nama_kategori' => 'Umum', 'deskripsi' => 'Perlengkapan kantor']);

        Barang::create([
            'kategori_barang_id' => $katMedis->id,
            'kode_barang' => 'AM-001',
            'nama_barang' => 'Stetoskop',
            'stok' => 5,
            'satuan' => 'Unit',
            'kondisi' => 'Baik',
            'tanggal_pengadaan' => '2024-01-01',
        ]);

        Barang::create([
            'kategori_barang_id' => $katUmum->id,
            'kode_barang' => 'UM-001',
            'nama_barang' => 'Laptop Dell',
            'stok' => 2,
            'satuan' => 'Unit',
            'kondisi' => 'Baik',
            'tanggal_pengadaan' => '2024-06-01',
        ]);

        // 6. Buat Obat
        Obat::create([
            'kode_obat' => 'OBT-001',
            'nama_obat' => 'Paracetamol 500mg',
            'jenis_obat' => 'Tablet',
            'stok' => 100,
            'min_stok' => 10,
            'satuan' => 'Strip',
            'harga_satuan' => 5000,
            'tanggal_kedaluwarsa' => '2027-12-31',
        ]);

        Obat::create([
            'kode_obat' => 'OBT-002',
            'nama_obat' => 'Amoxicillin Sirup',
            'jenis_obat' => 'Sirup',
            'stok' => 50,
            'min_stok' => 5,
            'satuan' => 'Botol',
            'harga_satuan' => 15000,
            'tanggal_kedaluwarsa' => '2026-06-30',
        ]);

        // 7. Call Tindakan Seeder
        $this->call(TindakanSeeder::class);

        // 8. Buat Pasien
        Pasien::create([
            'nik' => '3174000000000001',
            'nama_lengkap' => 'Siti Aminah',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1995-02-20',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Lenteng Agung',
            'no_telepon' => '08567890123',
        ]);

        // 9. Buat Shift
        $pagi = Shift::create(['nama_shift' => 'Pagi', 'jam_mulai' => '07:00:00', 'jam_selesai' => '14:00:00']);
        $siang = Shift::create(['nama_shift' => 'Siang', 'jam_mulai' => '14:00:00', 'jam_selesai' => '21:00:00']);
        Shift::create(['nama_shift' => 'Malam', 'jam_mulai' => '21:00:00', 'jam_selesai' => '07:00:00']);

        // 10. Buat Jadwal Jaga Hari Ini (Untuk Demo Absensi)
        $pegawaiAdmin = Pegawai::where('user_id', $admin->id)->first();
        $pegawaiDokter = Pegawai::where('user_id', $dokter->id)->first();

        if ($pegawaiAdmin) {
            JadwalJaga::create([
                'pegawai_id' => $pegawaiAdmin->id,
                'shift_id' => $pagi->id,
                'tanggal' => Carbon::today(),
                'status_kehadiran' => 'Belum Hadir',
            ]);
        }

        if ($pegawaiDokter) {
            JadwalJaga::create([
                'pegawai_id' => $pegawaiDokter->id,
                'shift_id' => $pagi->id, // Dokter shift pagi
                'tanggal' => Carbon::today(),
                'status_kehadiran' => 'Belum Hadir',
            ]);
        }
    }
}
