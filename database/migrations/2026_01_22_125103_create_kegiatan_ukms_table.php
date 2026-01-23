<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan_ukms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan'); // Posyandu Mawar, Penyuluhan DBD
            $table->date('tanggal_kegiatan');
            $table->string('lokasi');
            $table->string('penanggung_jawab'); // Nama Petugas
            $table->integer('jumlah_peserta')->default(0);
            $table->text('hasil_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_ukms');
    }
};