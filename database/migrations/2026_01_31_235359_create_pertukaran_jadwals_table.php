<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pertukaran_jadwals', function (Blueprint $table) {
            $table->id();
            // Pihak Pengaju (Requester)
            $table->foreignId('pemohon_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jadwal_pemohon_id')->constrained('jadwal_jagas')->onDelete('cascade');
            
            // Pihak Tujuan (Target)
            $table->foreignId('pengganti_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jadwal_pengganti_id')->constrained('jadwal_jagas')->onDelete('cascade');
            
            $table->string('alasan');
            $table->string('status')->default('Menunggu Persetujuan Rekan'); 
            // Status: Menunggu Persetujuan Rekan, Menunggu Approval Admin, Disetujui, Ditolak
            
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pertukaran_jadwals');
    }
};