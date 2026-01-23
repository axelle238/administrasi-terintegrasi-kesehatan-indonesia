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
        Schema::create('peminjaman_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->foreignId('pegawai_id')->constrained('pegawais');
            $table->foreignId('barang_id')->constrained('barangs');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali_rencana')->nullable();
            $table->date('tanggal_kembali_realisasi')->nullable();
            $table->string('status')->default('Dipinjam'); // Dipinjam, Dikembalikan, Terlambat
            $table->string('kondisi_keluar')->nullable(); // Baik, Baru
            $table->string('kondisi_kembali')->nullable(); // Baik, Rusak
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users')->comment('Petugas yang input');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barangs');
    }
};