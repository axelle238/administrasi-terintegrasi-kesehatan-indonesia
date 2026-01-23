<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laboratoriums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
            $table->string('jenis_pemeriksaan'); // Darah Lengkap, Urin, Gula Darah
            $table->json('hasil'); // Key-Value pair: {"Hemoglobin": "14", "Leukosit": "9000"}
            $table->string('petugas_lab');
            $table->timestamp('waktu_selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laboratoriums');
    }
};