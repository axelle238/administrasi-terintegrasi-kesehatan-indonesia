<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Periode Penilaian (Contoh: Q1 2024, Semester 1 2024)
        if (!Schema::hasTable('periode_penilaians')) {
            Schema::create('periode_penilaians', function (Blueprint $table) {
                $table->id();
                $table->string('judul'); // Contoh: Penilaian Kinerja 2024
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 2. Master Indikator Kinerja (KPI Library)
        if (!Schema::hasTable('indikator_kinerjas')) {
            Schema::create('indikator_kinerjas', function (Blueprint $table) {
                $table->id();
                $table->string('kategori'); // Perilaku, Hasil Kerja, Kedisiplinan
                $table->string('nama_indikator');
                $table->integer('bobot')->default(10); // Persentase bobot
                $table->timestamps();
            });
        }

        // 3. Penilaian Pegawai (Header)
        if (!Schema::hasTable('penilaian_pegawais')) {
            Schema::create('penilaian_pegawais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('periode_id')->constrained('periode_penilaians')->cascadeOnDelete();
                $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
                $table->foreignId('penilai_id')->nullable()->constrained('users')->nullOnDelete();
                $table->decimal('skor_akhir', 5, 2)->default(0);
                $table->string('predikat')->nullable(); // Sangat Baik, Baik, Cukup, Kurang
                $table->text('catatan_penilai')->nullable();
                $table->text('catatan_pegawai')->nullable();
                $table->string('status')->default('Draft'); // Draft, Final
                $table->timestamps();
            });
        }

        // 4. Detail Skor per Indikator
        if (!Schema::hasTable('detail_penilaians')) {
            Schema::create('detail_penilaians', function (Blueprint $table) {
                $table->id();
                $table->foreignId('penilaian_id')->constrained('penilaian_pegawais')->cascadeOnDelete();
                $table->foreignId('indikator_id')->constrained('indikator_kinerjas')->cascadeOnDelete();
                $table->decimal('skor', 5, 2); // 0-100
                $table->decimal('nilai_terbobot', 5, 2); // (skor * bobot) / 100
                $table->timestamps();
            });
        }

        // 5. Pengajuan Berhenti (Resign/PHK)
        if (!Schema::hasTable('pengajuan_berhentis')) {
            Schema::create('pengajuan_berhentis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
                $table->string('jenis_berhenti'); // Resign, PHK, Pensiun, Meninggal
                $table->date('tanggal_pengajuan');
                $table->date('tanggal_efektif_keluar');
                $table->text('alasan');
                $table->string('file_surat')->nullable();
                $table->string('status_approval')->default('Pending'); // Pending, Disetujui, Ditolak
                
                // Clearance Status (Checklist Bebas Tanggungan)
                $table->boolean('clearance_aset')->default(false); // Laptop, Kendaraan kembali
                $table->boolean('clearance_keuangan')->default(false); // Pinjaman lunas
                $table->boolean('clearance_dokumen')->default(false); // ID Card, Akses dikembalikan
                
                $table->text('catatan_hrd')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_berhentis');
        Schema::dropIfExists('detail_penilaians');
        Schema::dropIfExists('penilaian_pegawais');
        Schema::dropIfExists('indikator_kinerjas');
        Schema::dropIfExists('periode_penilaians');
    }
};