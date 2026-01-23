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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique()->comment('Nomor surat resmi');
            $table->date('tanggal_surat')->comment('Tanggal yang tertera di surat');
            $table->date('tanggal_diterima')->nullable()->comment('Tanggal surat diterima (khusus surat masuk)');
            $table->string('pengirim')->comment('Instansi atau orang yang mengirim');
            $table->string('penerima')->comment('Tujuan surat');
            $table->string('perihal')->comment('Inti atau judul surat');
            $table->enum('jenis_surat', ['Masuk', 'Keluar'])->comment('Kategori surat');
            $table->string('file_path')->nullable()->comment('Lokasi file scan surat (PDF/Gambar)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};