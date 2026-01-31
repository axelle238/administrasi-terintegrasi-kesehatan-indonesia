<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Laporan Kinerja Harian (Activity Log)
        Schema::create('laporan_kinerja_harians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('aktivitas');
            $table->text('deskripsi')->nullable();
            $table->string('output')->nullable(); // Dokumen, Laporan, Pasien, dll
            $table->string('file_bukti')->nullable();
            $table->enum('status', ['Draft', 'Diajukan', 'Disetujui', 'Direvisi'])->default('Draft');
            $table->text('catatan_verifikator')->nullable();
            $table->timestamps();
        });

        // Tabel Riwayat Pelatihan & Kompetensi
        Schema::create('riwayat_pelatihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_pelatihan');
            $table->string('penyelenggara');
            $table->string('lokasi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('jumlah_jam')->default(0);
            $table->string('nomor_sertifikat')->nullable();
            $table->string('file_sertifikat')->nullable();
            $table->enum('status_validasi', ['Pending', 'Valid', 'Invalid'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pelatihans');
        Schema::dropIfExists('laporan_kinerja_harians');
    }
};