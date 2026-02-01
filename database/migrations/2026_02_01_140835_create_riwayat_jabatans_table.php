<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('jabatan_baru');
            $table->string('unit_kerja_baru');
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('file_sk')->nullable(); // Dokumen SK
            $table->enum('jenis_perubahan', ['Promosi', 'Mutasi', 'Demosi', 'Perekrutan'])->default('Mutasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatans');
    }
};