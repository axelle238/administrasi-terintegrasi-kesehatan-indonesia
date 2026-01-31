<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_kinerja_harians', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_kinerja_harians', 'kategori_kegiatan')) {
                $table->string('kategori_kegiatan')->default('Tugas Utama')->after('aktivitas');
                $table->integer('durasi_menit')->default(60)->after('jam_selesai');
                $table->string('tautan_dokumen')->nullable()->after('file_bukti_kerja');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporan_kinerja_harians', function (Blueprint $table) {
            $table->dropColumn(['kategori_kegiatan', 'durasi_menit', 'tautan_dokumen']);
        });
    }
};