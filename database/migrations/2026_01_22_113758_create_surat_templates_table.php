<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_templates', function (Blueprint $table) {
            $table->id();
            $table->string('kode_template'); // e.g. SKS
            $table->string('nama_template'); // e.g. Surat Keterangan Sehat
            $table->text('konten'); // HTML Content with placeholders
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_templates');
    }
};