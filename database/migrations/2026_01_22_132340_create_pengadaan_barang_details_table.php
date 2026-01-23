<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pengadaan_barang_details')) {
            Schema::create('pengadaan_barang_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pengadaan_barang_id')->constrained('pengadaan_barangs')->onDelete('cascade');
                $table->foreignId('barang_id')->nullable()->constrained('barangs')->nullOnDelete(); // Existing item
                $table->string('nama_barang_baru')->nullable(); // For new items not in master
                $table->integer('jumlah_minta');
                $table->integer('jumlah_disetujui')->default(0);
                $table->decimal('harga_satuan_estimasi', 15, 2)->default(0);
                $table->decimal('total_harga', 15, 2)->default(0);
                $table->string('spesifikasi')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengadaan_barang_details');
    }
};