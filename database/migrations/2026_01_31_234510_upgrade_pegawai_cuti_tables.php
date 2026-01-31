<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->integer('kuota_cuti_tahunan')->default(12)->after('status_kepegawaian');
            $table->integer('sisa_cuti')->default(12)->after('kuota_cuti_tahunan');
            $table->string('foto_profil')->nullable()->after('alamat');
            $table->string('kontak_darurat_nama')->nullable()->after('no_telepon');
            $table->string('kontak_darurat_telp')->nullable()->after('kontak_darurat_nama');
        });

        Schema::table('pengajuan_cutis', function (Blueprint $table) {
            $table->integer('durasi_hari')->default(1)->after('tanggal_selesai');
            $table->string('file_bukti')->nullable()->after('keterangan'); // Untuk surat sakit dll
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn(['kuota_cuti_tahunan', 'sisa_cuti', 'foto_profil', 'kontak_darurat_nama', 'kontak_darurat_telp']);
        });

        Schema::table('pengajuan_cutis', function (Blueprint $table) {
            $table->dropColumn(['durasi_hari', 'file_bukti']);
        });
    }
};