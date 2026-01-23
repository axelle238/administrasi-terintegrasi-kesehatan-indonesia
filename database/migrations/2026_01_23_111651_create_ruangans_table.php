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
        Schema::create('ruangans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ruangan')->unique()->nullable()->comment('Kode unik ruangan, misal: R-001');
            $table->string('nama_ruangan')->comment('Nama Ruangan / Gudang');
            $table->string('lokasi_gedung')->nullable()->comment('Gedung A, B, atau Lantai 1, 2');
            $table->string('penanggung_jawab')->nullable()->comment('Nama PIC ruangan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};