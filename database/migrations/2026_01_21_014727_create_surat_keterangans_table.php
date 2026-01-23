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
        Schema::create('surat_keterangans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade'); // User who is a doctor
            $table->enum('jenis_surat', ['Sehat', 'Sakit', 'Buta Warna', 'Bebas Narkoba']);
            $table->date('tanggal_surat');
            
            // Medical Data Snapshot (JSON to be flexible)
            // Storing: tinggi_badan, berat_badan, tekanan_darah, golongan_darah, visus_mata, buta_warna_test
            $table->json('data_medis')->nullable(); 
            
            $table->text('keperluan')->nullable(); // For Sehat/Bebas Narkoba
            $table->integer('lama_istirahat')->nullable(); // For Sakit (days)
            $table->date('mulai_istirahat')->nullable(); // For Sakit
            
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangans');
    }
};