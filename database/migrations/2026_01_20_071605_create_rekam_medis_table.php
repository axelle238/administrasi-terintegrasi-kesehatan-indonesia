<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade')->comment('Pasien yang diperiksa');
            $table->foreignId('dokter_id')->constrained('users')->comment('Dokter yang memeriksa (User ID)');
            
            $table->date('tanggal_periksa')->useCurrent();
            $table->text('keluhan')->comment('Keluhan yang dirasakan pasien (Anamnesa)');
            $table->text('diagnosa')->comment('Hasil diagnosa dokter');
            $table->text('tindakan')->nullable()->comment('Tindakan medis yang dilakukan');
            $table->text('resep_obat')->nullable()->comment('Daftar obat yang diresepkan (Text/JSON)');
            $table->text('catatan_tambahan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};