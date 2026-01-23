<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kinerja_pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->integer('bulan');
            $table->integer('tahun');
            
            // Aspek Penilaian (Skala 1-100)
            $table->integer('orientasi_pelayanan')->default(0);
            $table->integer('integritas')->default(0);
            $table->integer('komitmen')->default(0);
            $table->integer('disiplin')->default(0);
            $table->integer('kerjasama')->default(0);
            
            $table->text('catatan_atasan')->nullable();
            $table->string('penilai')->nullable(); // Nama User Penilai
            
            $table->timestamps();
            
            $table->unique(['pegawai_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_pegawais');
    }
};