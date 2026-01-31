<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Presensi (Absensi Digital)
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->string('foto_masuk')->nullable();
            $table->string('foto_keluar')->nullable();
            $table->string('lokasi_masuk')->nullable(); // Lat,Long
            $table->string('lokasi_keluar')->nullable(); // Lat,Long
            $table->string('status_kehadiran')->default('Hadir'); // Hadir, Terlambat, Alpa
            $table->integer('keterlambatan_menit')->default(0);
            $table->timestamps();
        });

        // 2. Tabel Lembur (Overtime)
        Schema::create('lemburs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->text('alasan_lembur');
            $table->text('output_kerja');
            $table->string('status')->default('Menunggu'); // Menunggu, Disetujui, Ditolak
            $table->text('catatan_approval')->nullable();
            $table->timestamps();
        });

        // 3. Tabel Perjalanan Dinas (SPPD)
        Schema::create('perjalanan_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('tujuan_dinas'); // Kota/Instansi
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->text('keperluan');
            $table->decimal('anggaran_diajukan', 15, 2)->default(0);
            $table->string('status')->default('Menunggu');
            $table->string('file_laporan')->nullable(); // Upload laporan setelah pulang
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perjalanan_dinas');
        Schema::dropIfExists('lemburs');
        Schema::dropIfExists('presensis');
    }
};