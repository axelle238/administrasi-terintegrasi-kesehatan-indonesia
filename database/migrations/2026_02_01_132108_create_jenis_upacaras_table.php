<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_upacaras', function (Blueprint $table) {
            $table->id();
            $table->string('nama_upacara'); // Contoh: Upacara Senin, Hari Pahlawan
            $table->string('kategori')->default('Rutin'); // Rutin / Hari Besar
            $table->integer('poin_kredit')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_upacaras');
    }
};