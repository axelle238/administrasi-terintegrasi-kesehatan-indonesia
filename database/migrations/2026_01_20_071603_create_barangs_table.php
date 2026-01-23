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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_barang_id')->constrained('kategori_barangs')->onDelete('cascade')->comment('Kategori barang');
            
            $table->string('kode_barang')->unique()->comment('Kode unik barang inventaris');
            $table->string('nama_barang')->comment('Nama lengkap barang');
            $table->string('merk')->nullable()->comment('Merk atau brand barang');
            $table->integer('stok')->default(0)->comment('Jumlah stok saat ini');
            $table->string('satuan')->default('Unit')->comment('Satuan barang (Unit, Buah, Set)');
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik')->comment('Kondisi fisik barang');
            $table->date('tanggal_pengadaan')->nullable()->comment('Tanggal barang masuk inventaris');
            $table->string('lokasi_penyimpanan')->nullable()->comment('Ruangan atau lemari tempat barang');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};