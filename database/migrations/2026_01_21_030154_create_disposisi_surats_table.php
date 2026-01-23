<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disposisi_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surats')->onDelete('cascade');
            $table->foreignId('pengirim_id')->constrained('users')->comment('Yang memberikan disposisi (misal: Kapus)');
            $table->foreignId('penerima_id')->constrained('users')->comment('Tujuan disposisi (misal: Ka. TU / Unit)');
            
            $table->string('sifat_disposisi')->default('Biasa'); // Biasa, Penting, Segera, Rahasia
            $table->date('batas_waktu')->nullable();
            $table->text('instruksi')->nullable(); // Isi instruksi disposisi
            $table->text('catatan')->nullable();
            
            $table->string('status')->default('Belum Dibaca'); // Belum Dibaca, Dibaca, Selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi_surats');
    }
};