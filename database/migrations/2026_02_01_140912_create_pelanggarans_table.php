<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
            $table->string('jenis_pelanggaran'); // Ringan, Sedang, Berat
            $table->string('judul_kasus');
            $table->text('deskripsi');
            $table->date('tanggal_kejadian');
            $table->string('sanksi_diberikan')->nullable(); // SP1, SP2, Skorsing
            $table->date('tanggal_sanksi')->nullable();
            $table->string('file_bukti')->nullable();
            $table->string('status')->default('Open'); // Open, Resolved
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggarans');
    }
};