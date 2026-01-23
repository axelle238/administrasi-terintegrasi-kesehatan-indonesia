<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->string('nama_bangsal');
            $table->integer('kapasitas_bed')->default(4); // KRIS mandate max 4 beds per room
            $table->integer('bed_terisi')->default(0);
            $table->boolean('is_kris_compliant')->default(true); // Compliance with 12 criteria
            $table->decimal('harga_per_malam', 15, 2);
            $table->string('status')->default('Tersedia'); // Tersedia, Penuh, Renovasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};