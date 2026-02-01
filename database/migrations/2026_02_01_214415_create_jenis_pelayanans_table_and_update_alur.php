<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat Tabel Jenis Pelayanan
        Schema::create('jenis_pelayanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->text('deskripsi')->nullable();
            $table->string('icon')->default('server');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Tambah Relasi di Alur Pelayanan
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->foreignId('jenis_pelayanan_id')->nullable()->after('id')->constrained('jenis_pelayanans')->nullOnDelete();
        });

        // 3. Seeding Data Awal
        $now = now();
        DB::table('jenis_pelayanans')->insert([
            ['nama_layanan' => 'Rawat Jalan', 'deskripsi' => 'Pelayanan poliklinik dan konsultasi dokter.', 'icon' => 'user-group', 'created_at' => $now, 'updated_at' => $now],
            ['nama_layanan' => 'Gawat Darurat (UGD)', 'deskripsi' => 'Penanganan kasus darurat 24 jam.', 'icon' => 'truck', 'created_at' => $now, 'updated_at' => $now],
            ['nama_layanan' => 'Rawat Inap', 'deskripsi' => 'Perawatan intensif di bangsal rumah sakit.', 'icon' => 'home-modern', 'created_at' => $now, 'updated_at' => $now],
            ['nama_layanan' => 'Penunjang Medis', 'deskripsi' => 'Laboratorium, Radiologi, dan Farmasi.', 'icon' => 'beaker', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->dropForeign(['jenis_pelayanan_id']);
            $table->dropColumn('jenis_pelayanan_id');
        });

        Schema::dropIfExists('jenis_pelayanans');
    }
};