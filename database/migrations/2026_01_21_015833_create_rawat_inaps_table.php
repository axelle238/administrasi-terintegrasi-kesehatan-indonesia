<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rawat_inaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('kamar_id')->constrained('kamars')->onDelete('cascade');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable();
            $table->text('diagnosa_awal');
            $table->text('diagnosa_akhir')->nullable();
            $table->string('status')->default('Aktif'); // Aktif, Pulang, Rujuk, Meninggal
            $table->string('jenis_pembayaran')->default('Umum'); // Umum, BPJS
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rawat_inaps');
    }
};