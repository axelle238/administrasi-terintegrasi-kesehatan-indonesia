<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Inventaris Pegawai (Handover Aset)
        if (!Schema::hasTable('aset_pegawais')) {
            Schema::create('aset_pegawais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete(); // Pemegang
                $table->foreignId('barang_id')->constrained()->cascadeOnDelete(); // Barang dari modul Aset
                $table->date('tanggal_terima');
                $table->date('tanggal_kembali')->nullable();
                $table->string('kondisi_saat_terima')->default('Baik');
                $table->string('kondisi_saat_kembali')->nullable();
                $table->string('status')->default('Dipakai'); // Dipakai, Dikembalikan, Hilang
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }

        // 2. Update Riwayat Jabatan untuk Approval Workflow
        if (Schema::hasTable('riwayat_jabatans')) {
            Schema::table('riwayat_jabatans', function (Blueprint $table) {
                if (!Schema::hasColumn('riwayat_jabatans', 'status_pengajuan')) {
                    $table->string('status_pengajuan')->default('Disetujui')->after('keterangan'); // Draft, Pending, Disetujui, Ditolak
                }
                if (!Schema::hasColumn('riwayat_jabatans', 'approved_by')) {
                    $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('status_pengajuan');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_pegawais');
    }
};