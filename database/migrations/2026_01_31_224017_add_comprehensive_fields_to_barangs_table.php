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
        Schema::table('barangs', function (Blueprint $table) {
            // Kolom yang mungkin belum ada (Safe Add)
            
            if (!Schema::hasColumn('barangs', 'jenis_aset')) {
                $table->enum('jenis_aset', ['Medis', 'Non-Medis'])->default('Non-Medis')->after('nama_barang')->comment('Pembeda aset medis dan umum');
            }

            if (!Schema::hasColumn('barangs', 'nomor_inventaris')) {
                $table->string('nomor_inventaris')->nullable()->unique()->after('kode_barang')->comment('Nomor label inventaris fisik');
            }
            
            // Detail Medis
            if (!Schema::hasColumn('barangs', 'nomor_izin_edar')) {
                $table->string('nomor_izin_edar')->nullable()->after('kondisi')->comment('Nomor Izin Edar (AKD/AKL)');
            }
            if (!Schema::hasColumn('barangs', 'tanggal_kalibrasi_terakhir')) {
                $table->date('tanggal_kalibrasi_terakhir')->nullable()->after('tanggal_pengadaan');
            }
            if (!Schema::hasColumn('barangs', 'tanggal_kalibrasi_berikutnya')) {
                $table->date('tanggal_kalibrasi_berikutnya')->nullable()->after('tanggal_kalibrasi_terakhir');
            }
            if (!Schema::hasColumn('barangs', 'distributor')) {
                $table->string('distributor')->nullable()->after('merk')->comment('Vendor/Distributor penyedia');
            }

            // Keuangan Tambahan (jika belum ada)
            if (!Schema::hasColumn('barangs', 'metode_penyusutan')) {
                $table->enum('metode_penyusutan', ['Garis Lurus', 'Saldo Menurun', 'Tidak Disusutkan'])->default('Garis Lurus')->after('nilai_residu');
            }
            
            // Spesifikasi (jika belum ada)
            if (!Schema::hasColumn('barangs', 'spesifikasi_teknis')) {
                $table->text('spesifikasi_teknis')->nullable()->after('nama_barang')->comment('Detail spek teknis');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Drop columns if exist
            $columns = [
                'jenis_aset',
                'nomor_inventaris',
                'nomor_izin_edar',
                'tanggal_kalibrasi_terakhir',
                'tanggal_kalibrasi_berikutnya',
                'distributor',
                'metode_penyusutan',
                'spesifikasi_teknis'
            ];
            
            foreach ($columns as $col) {
                if (Schema::hasColumn('barangs', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
