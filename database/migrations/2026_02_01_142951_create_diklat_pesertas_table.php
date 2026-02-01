<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diklat_pesertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diklat_id')->constrained('diklats')->cascadeOnDelete();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('nomor_sertifikat')->nullable();
            $table->string('file_sertifikat')->nullable();
            $table->string('status_kelulusan')->default('Peserta'); // Lulus, Tidak Lulus, Peserta
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diklat_pesertas');
    }
};