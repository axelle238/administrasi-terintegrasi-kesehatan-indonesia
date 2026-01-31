<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hari_liburs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('keterangan'); // Nama Hari Libur
            $table->boolean('is_cuti_bersama')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hari_liburs');
    }
};