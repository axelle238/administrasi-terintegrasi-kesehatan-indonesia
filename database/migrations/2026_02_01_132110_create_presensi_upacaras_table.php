<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi_upacaras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jenis_upacara_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('bukti_foto')->nullable();
            $table->text('keterangan')->nullable(); // Lokasi atau catatan
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpha'])->default('Hadir');
            $table->boolean('is_integrated_lkh')->default(false); // Flag integrasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi_upacaras');
    }
};