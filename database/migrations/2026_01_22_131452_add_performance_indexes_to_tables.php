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
        // 1. Optimasi Tabel Pasien (Pencarian NIK, Nama, BPJS)
        Schema::table('pasiens', function (Blueprint $table) {
            // NIK dan No BPJS biasanya sudah unique (otomatis index), tapi kita pastikan index nama
            $table->index('nama_lengkap'); 
            $table->index('no_telepon');
        });

        // 2. Optimasi Tabel Obat (Pencarian Stok, Nama, Expired)
        Schema::table('obats', function (Blueprint $table) {
            $table->index('nama_obat');
            $table->index('tanggal_kedaluwarsa'); // Penting untuk EWS FEFO
            $table->index('stok'); // Penting untuk filter stok menipis
        });

        // 3. Optimasi Tabel Antrean (Filter Harian Dashboard)
        Schema::table('antreans', function (Blueprint $table) {
            // Compound index untuk query: where('tanggal', today)->where('status', '...')
            $table->index(['tanggal_antrean', 'status']);
            $table->index('poli_id');
        });

        // 4. Optimasi Rekam Medis (History)
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->index('tanggal_periksa');
            $table->index('pasien_id');
            $table->index('dokter_id');
        });

        // 5. Optimasi Pembayaran (Laporan Keuangan)
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->index('created_at'); // Untuk filter laporan harian/bulanan
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes if needed (optional for optimization migration)
    }
};