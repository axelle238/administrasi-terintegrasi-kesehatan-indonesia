<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('dokumen_pegawais')) {
            Schema::create('dokumen_pegawais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();
                $table->string('kategori'); // KTP, KK, Ijazah, NPWP, BPJS
                $table->string('nomor_identitas')->nullable();
                $table->string('file_path');
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_pegawais');
    }
};