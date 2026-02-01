<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek tabel, jika belum ada buat baru. Jika ada, tambahkan kolom yang kurang.
        if (!Schema::hasTable('perjalanan_dinas')) {
            Schema::create('perjalanan_dinas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
                $table->string('nomor_surat_tugas')->nullable();
                $table->string('tujuan');
                $table->text('keperluan');
                $table->date('tanggal_berangkat');
                $table->date('tanggal_kembali');
                $table->decimal('anggaran', 15, 2)->default(0);
                $table->string('status')->default('Pengajuan'); // Pengajuan, Disetujui, Selesai
                $table->text('laporan_hasil')->nullable();
                $table->string('file_laporan')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('perjalanan_dinas');
    }
};