<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Upgrade Tabel Presensi (Support GPS & Selfie)
        Schema::table('presensis', function (Blueprint $table) {
            if (!Schema::hasColumn('presensis', 'foto_masuk')) {
                $table->string('foto_masuk')->nullable()->after('jam_masuk');
                $table->string('foto_keluar')->nullable()->after('jam_keluar');
                $table->string('lokasi_masuk')->nullable()->comment('Lat,Long')->after('foto_masuk');
                $table->string('lokasi_keluar')->nullable()->comment('Lat,Long')->after('foto_keluar');
                $table->text('catatan_harian')->nullable()->after('status_kehadiran');
                $table->boolean('is_late')->default(false)->after('status_kehadiran');
            }
        });

        // 2. Upgrade Tabel Lembur (Detail & Bukti)
        Schema::table('lemburs', function (Blueprint $table) {
            if (!Schema::hasColumn('lemburs', 'output_kerja')) {
                $table->text('output_kerja')->nullable()->after('keterangan');
                $table->string('bukti_lembur')->nullable()->comment('File path')->after('output_kerja');
            }
        });

        // 3. Tabel Baru: Arsip Dokumen Pegawai (Digitalisasi)
        if (!Schema::hasTable('dokumen_pegawais')) {
            Schema::create('dokumen_pegawais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('jenis_dokumen'); // SK, Ijazah, KTP, Sertifikat
                $table->string('nama_dokumen');
                $table->string('file_path');
                $table->date('tanggal_kadaluwarsa')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_pegawais');
        
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropColumn(['foto_masuk', 'foto_keluar', 'lokasi_masuk', 'lokasi_keluar', 'catatan_harian', 'is_late']);
        });

        Schema::table('lemburs', function (Blueprint $table) {
            $table->dropColumn(['output_kerja', 'bukti_lembur']);
        });
    }
};