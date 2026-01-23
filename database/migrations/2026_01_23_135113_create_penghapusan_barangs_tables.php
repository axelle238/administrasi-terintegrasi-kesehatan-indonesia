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
        Schema::create('penghapusan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen')->unique();
            $table->date('tanggal_pengajuan');
            $table->foreignId('diajukan_oleh')->constrained('users');
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users');
            $table->date('tanggal_disetujui')->nullable();
            $table->enum('status', ['Draft', 'Pending', 'Disetujui', 'Ditolak', 'Selesai'])->default('Draft');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('penghapusan_barang_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penghapusan_barang_id')->constrained('penghapusan_barangs')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs');
            $table->integer('jumlah')->default(1);
            $table->string('kondisi_terakhir')->nullable(); // Rusak Berat, Hilang, Kadaluarsa
            $table->decimal('nilai_buku_saat_ini', 15, 2)->default(0);
            $table->decimal('estimasi_nilai_jual', 15, 2)->default(0)->comment('Jika dilelang/dijual');
            $table->text('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghapusan_barang_details');
        Schema::dropIfExists('penghapusan_barangs');
    }
};