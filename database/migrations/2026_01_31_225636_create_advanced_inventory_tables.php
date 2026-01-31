<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Manajemen Batch (Khusus Medis/Consumables)
        if (!Schema::hasTable('barang_batches')) {
            Schema::create('barang_batches', function (Blueprint $table) {
                $table->id();
                $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
                $table->string('nomor_batch');
                $table->date('tanggal_kadaluarsa');
                $table->integer('stok_saat_ini')->default(0);
                $table->date('tanggal_masuk')->useCurrent();
                $table->string('sumber_penerimaan')->nullable(); // PO Number or Donation
                $table->timestamps();
            });
        }

        // Tabel Log Penyusutan Aset (Depreciation History)
        if (!Schema::hasTable('depresiasi_logs')) {
            Schema::create('depresiasi_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
                $table->date('periode_bulan'); // YYYY-MM-01
                $table->decimal('nilai_buku_awal', 15, 2);
                $table->decimal('nilai_penyusutan', 15, 2);
                $table->decimal('nilai_buku_akhir', 15, 2);
                $table->string('metode')->default('Garis Lurus');
                $table->foreignId('created_by')->constrained('users');
                $table->timestamps();
            });
        }
        
        // Tabel Jadwal Penghapusan (Disposal Plan)
        if (!Schema::hasTable('rencana_penghapusan_barangs')) {
            Schema::create('rencana_penghapusan_barangs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('barang_id')->constrained('barangs');
                $table->date('rencana_tanggal_hapus');
                $table->string('alasan_utama');
                $table->enum('status', ['Terjadwal', 'Diproses', 'Selesai', 'Dibatalkan'])->default('Terjadwal');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rencana_penghapusan_barangs');
        Schema::dropIfExists('depresiasi_logs');
        Schema::dropIfExists('barang_batches');
    }
};
