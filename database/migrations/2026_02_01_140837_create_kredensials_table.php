<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kredensials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('nama_dokumen'); // Contoh: STR, SIP, Sertifikat ACLS
            $table->string('nomor_dokumen');
            $table->date('tanggal_terbit');
            $table->date('tanggal_berakhir'); // Untuk alert expired
            $table->string('penerbit')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->integer('reminder_days')->default(30); // Ingatkan X hari sebelum expired
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kredensials');
    }
};