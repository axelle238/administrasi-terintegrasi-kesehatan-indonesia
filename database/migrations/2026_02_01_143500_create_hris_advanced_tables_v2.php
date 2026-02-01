<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Kredensial (Monitoring Dokumen Expired)
        if (!Schema::hasTable('kredensials')) {
            Schema::create('kredensials', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
                $table->string('jenis_dokumen'); 
                $table->string('nomor_dokumen');
                $table->date('tanggal_terbit');
                $table->date('tanggal_berakhir');
                $table->string('penerbit')->nullable();
                $table->string('file_dokumen')->nullable();
                $table->string('status')->default('Aktif');
                $table->timestamps();
            });
        }

        // 2. Manajemen Diklat (Pelatihan)
        if (!Schema::hasTable('diklats')) {
            Schema::create('diklats', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kegiatan');
                $table->string('jenis_diklat');
                $table->string('penyelenggara');
                $table->string('lokasi');
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->integer('total_jam_pelajaran')->default(0);
                $table->decimal('biaya', 15, 2)->default(0);
                $table->string('status')->default('Rencana');
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }

        // 3. Peserta Diklat
        if (!Schema::hasTable('diklat_pesertas')) {
            Schema::create('diklat_pesertas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('diklat_id')->constrained()->cascadeOnDelete();
                $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
                $table->string('status_kelulusan')->default('Peserta');
                $table->string('nomor_sertifikat')->nullable();
                $table->string('file_sertifikat')->nullable();
                $table->timestamps();
            });
        }

        // 4. Perjalanan Dinas (SPPD)
        if (!Schema::hasTable('perjalanan_dinas')) {
            Schema::create('perjalanan_dinas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
                $table->string('nomor_spt')->nullable();
                $table->string('tujuan_dinas');
                $table->text('keperluan');
                $table->date('tanggal_berangkat');
                $table->date('tanggal_kembali');
                $table->string('transportasi')->nullable();
                $table->decimal('uang_saku', 15, 2)->default(0);
                $table->decimal('biaya_transport', 15, 2)->default(0);
                $table->decimal('biaya_penginapan', 15, 2)->default(0);
                $table->string('status')->default('Pengajuan');
                $table->text('laporan_hasil')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('perjalanan_dinas');
        Schema::dropIfExists('diklat_pesertas');
        Schema::dropIfExists('diklats');
        Schema::dropIfExists('kredensials');
    }
};