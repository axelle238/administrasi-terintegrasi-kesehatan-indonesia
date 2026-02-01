<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realisasi_kinerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_kinerja_id')->constrained('target_kinerjas')->cascadeOnDelete();
            $table->decimal('realisasi', 10, 2);
            $table->decimal('nilai_capaian', 5, 2); // % capaian * bobot
            $table->text('bukti_keterangan')->nullable();
            $table->string('status_validasi')->default('Pending'); // Pending, Valid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realisasi_kinerjas');
    }
};