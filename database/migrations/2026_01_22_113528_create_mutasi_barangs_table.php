<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasi_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->string('lokasi_asal'); // e.g., Gudang
            $table->string('lokasi_tujuan'); // e.g., Poli Gigi
            $table->integer('jumlah');
            $table->date('tanggal_mutasi');
            $table->string('penanggung_jawab'); // Nama User
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasi_barangs');
    }
};