<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Detail Khusus Alat Kesehatan
        Schema::create('detail_aset_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->string('nomor_izin_edar')->nullable(); // AKL/AKD
            $table->string('distributor_resmi')->nullable();
            $table->integer('frekuensi_kalibrasi_bulan')->nullable(); // e.g. 12 bulan
            $table->date('kalibrasi_terakhir')->nullable();
            $table->date('kalibrasi_selanjutnya')->nullable();
            $table->string('suhu_penyimpanan')->nullable(); // e.g. 2-8 Celcius
            $table->boolean('wajib_maintenance')->default(true);
            $table->text('catatan_teknis')->nullable();
            $table->timestamps();
        });

        // Tabel Depresiasi Aset (Penyusutan Nilai)
        Schema::create('depresiasi_aset', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->integer('tahun_ke');
            $table->decimal('nilai_buku_awal', 15, 2);
            $table->decimal('nilai_penyusutan', 15, 2);
            $table->decimal('nilai_buku_akhir', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('depresiasi_aset');
        Schema::dropIfExists('detail_aset_medis');
    }
};