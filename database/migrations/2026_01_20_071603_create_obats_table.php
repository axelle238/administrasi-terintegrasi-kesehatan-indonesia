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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_obat')->unique()->comment('Kode unik obat (bisa barcode)');
            $table->string('nama_obat')->comment('Nama dagang atau generik obat');
            $table->string('jenis_obat')->comment('Contoh: Tablet, Sirup, Injeksi, Salep');
            $table->integer('stok')->default(0)->comment('Sisa stok obat di apotek');
            $table->string('satuan')->comment('Contoh: Strip, Botol, Ampul');
            $table->decimal('harga_satuan', 10, 2)->default(0)->comment('Harga per satuan (opsional jika ada penjualan)');
            $table->date('tanggal_kedaluwarsa')->comment('Tanggal expired obat');
            $table->text('keterangan')->nullable()->comment('Instruksi penyimpanan atau info tambahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};