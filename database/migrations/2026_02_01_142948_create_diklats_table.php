<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diklats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_diklat');
            $table->string('penyelenggara')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('kuota')->default(0);
            $table->integer('jp')->default(0); // Jam Pelajaran
            $table->enum('status', ['Rencana', 'Berjalan', 'Selesai', 'Batal'])->default('Rencana');
            $table->string('kategori')->default('Teknis'); // Teknis, Manajerial, Fungsional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diklats');
    }
};