<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Header (Satu Laporan per Hari per Pegawai)
        Schema::create('laporan_harians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('status')->default('Draft'); // Draft, Diajukan, Disetujui, Ditolak, Revisi
            $table->text('catatan_harian')->nullable(); // Ringkasan hari itu (opsional)
            
            // Verifikasi
            $table->foreignId('verifikator_id')->nullable()->constrained('users');
            $table->dateTime('waktu_verifikasi')->nullable();
            $table->text('catatan_verifikator')->nullable();
            
            $table->timestamps();
            
            // Unique constraint: 1 User hanya punya 1 laporan per hari
            $table->unique(['user_id', 'tanggal']);
        });

        // Tabel Detail (Banyak Kegiatan dalam Satu Laporan)
        Schema::create('laporan_harian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_harian_id')->constrained('laporan_harians')->cascadeOnDelete();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('kegiatan'); // Judul kegiatan
            $table->text('deskripsi')->nullable(); // Detail teknis
            $table->string('output')->nullable(); // Hasil kerja (e.g. 1 Dokumen, 5 Pasien)
            $table->integer('progress')->default(100); // 0-100%
            $table->string('file_bukti')->nullable(); // Path foto/dokumen (opsional)
            $table->enum('kategori', ['Utama', 'Tambahan', 'Lainnya'])->default('Utama');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_harian_details');
        Schema::dropIfExists('laporan_harians');
    }
};