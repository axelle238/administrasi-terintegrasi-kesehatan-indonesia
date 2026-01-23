<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengadaan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan')->unique();
            $table->date('tanggal_pengajuan');
            $table->foreignId('pemohon_id')->constrained('users')->comment('User yang mengajukan');
            
            $table->string('status')->default('Pending'); // Pending, Disetujui, Ditolak, Selesai
            $table->text('keterangan')->nullable();
            $table->text('catatan_persetujuan')->nullable(); // Alasan jika ditolak/catatan acc
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users');
            $table->date('tanggal_disetujui')->nullable();

            $table->timestamps();
        });

        // Detail items requested
        Schema::create('pengadaan_barang_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengadaan_barang_id')->constrained('pengadaan_barangs')->onDelete('cascade');
            // Bisa request barang baru (belum ada di master) atau restock (ada di master)
            $table->foreignId('barang_id')->nullable()->constrained('barangs'); 
            $table->string('nama_barang')->nullable(); // Jika barang baru
            $table->integer('jumlah_permintaan');
            $table->integer('jumlah_disetujui')->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('estimasi_harga_satuan', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengadaan_barang_details');
        Schema::dropIfExists('pengadaan_barangs');
    }
};