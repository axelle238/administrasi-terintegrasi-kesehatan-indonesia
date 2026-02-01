<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_kinerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->string('indikator'); // Jumlah Pasien, Ketepatan Waktu
            $table->decimal('target', 10, 2);
            $table->string('satuan'); // Orang, Persen, Dokumen
            $table->decimal('bobot', 5, 2)->default(1); // Bobot nilai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_kinerjas');
    }
};