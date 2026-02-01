<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Modifikasi Riwayat Jabatan (Jika Perlu)
        if (Schema::hasTable('riwayat_jabatans')) {
            Schema::table('riwayat_jabatans', function (Blueprint $table) {
                if (!Schema::hasColumn('riwayat_jabatans', 'jabatan_lama')) {
                    $table->string('jabatan_lama')->nullable()->after('jenis_perubahan');
                }
                if (!Schema::hasColumn('riwayat_jabatans', 'unit_kerja_lama')) {
                    $table->string('unit_kerja_lama')->nullable()->after('jabatan_baru');
                }
                if (!Schema::hasColumn('riwayat_jabatans', 'keterangan')) {
                    $table->text('keterangan')->nullable()->after('file_sk');
                }
            });
        }

        // 2. Tabel Keluarga Pegawai
        if (!Schema::hasTable('keluarga_pegawais')) {
            Schema::create('keluarga_pegawais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
                $table->string('nama');
                $table->string('hubungan'); // Suami, Istri, Anak
                $table->string('nik')->nullable();
                $table->date('tanggal_lahir')->nullable();
                $table->string('pekerjaan')->nullable();
                $table->boolean('tertanggung_bpjs')->default(false);
                $table->timestamps();
            });
        }

        // 3. Tabel Pelanggaran & Sanksi
        if (!Schema::hasTable('pelanggarans')) {
            Schema::create('pelanggarans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
                $table->string('jenis_pelanggaran'); // Ringan, Sedang, Berat
                $table->string('tingkat_sanksi'); // Teguran Lisan, SP1, SP2, SP3, PHK
                $table->date('tanggal_kejadian');
                $table->date('tanggal_berakhir_sanksi')->nullable();
                $table->text('deskripsi_kejadian');
                $table->string('file_bukti')->nullable();
                $table->string('status')->default('Aktif'); // Aktif, Selesai
                $table->timestamps();
            });
        }

        // 4. Tabel Riwayat Pendidikan
        if (!Schema::hasTable('riwayat_pendidikans')) {
            Schema::create('riwayat_pendidikans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
                $table->string('jenjang'); // SMA, D3, S1, S2, dll
                $table->string('institusi');
                $table->string('jurusan')->nullable();
                $table->year('tahun_lulus');
                $table->string('nomor_ijazah')->nullable();
                $table->string('file_ijazah')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pendidikans');
        Schema::dropIfExists('pelanggarans');
        Schema::dropIfExists('keluarga_pegawais');
        // Tidak drop riwayat_jabatans karena tabel lama
    }
};