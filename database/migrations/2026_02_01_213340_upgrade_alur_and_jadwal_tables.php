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
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            if (!Schema::hasColumn('alur_pelayanans', 'target_pasien')) {
                $table->string('target_pasien')->default('Umum')->after('judul')->comment('Umum, BPJS, Asuransi, dll');
            }
            if (!Schema::hasColumn('alur_pelayanans', 'estimasi_waktu')) {
                $table->string('estimasi_waktu')->nullable()->after('deskripsi')->comment('Contoh: 15-30 Menit');
            }
            if (!Schema::hasColumn('alur_pelayanans', 'dokumen_syarat')) {
                $table->text('dokumen_syarat')->nullable()->after('estimasi_waktu')->comment('List dokumen yg dibutuhkan');
            }
        });

        Schema::table('jadwal_jagas', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_jagas', 'kuota_online')) {
                $table->integer('kuota_online')->default(20)->after('shift_id');
            }
            if (!Schema::hasColumn('jadwal_jagas', 'kuota_offline')) {
                $table->integer('kuota_offline')->default(30)->after('kuota_online');
            }
            if (!Schema::hasColumn('jadwal_jagas', 'status_kehadiran')) {
                $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Cuti', 'Sakit', 'Libur'])->default('Hadir')->after('kuota_offline');
            }
            if (!Schema::hasColumn('jadwal_jagas', 'catatan')) {
                $table->text('catatan')->nullable()->after('status_kehadiran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Opsional: Drop column
    }
};