<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('presensis', 'shift_nama')) $table->string('shift_nama')->nullable();
            if (!Schema::hasColumn('presensis', 'shift_jam_masuk')) $table->time('shift_jam_masuk')->nullable();
            if (!Schema::hasColumn('presensis', 'shift_jam_keluar')) $table->time('shift_jam_keluar')->nullable();
            
            if (!Schema::hasColumn('presensis', 'foto_masuk')) $table->string('foto_masuk')->nullable();
            if (!Schema::hasColumn('presensis', 'foto_keluar')) $table->string('foto_keluar')->nullable();
            
            if (!Schema::hasColumn('presensis', 'koordinat_masuk')) $table->string('koordinat_masuk')->nullable();
            if (!Schema::hasColumn('presensis', 'koordinat_keluar')) $table->string('koordinat_keluar')->nullable();
            
            if (!Schema::hasColumn('presensis', 'alamat_masuk')) $table->string('alamat_masuk')->nullable();
            if (!Schema::hasColumn('presensis', 'alamat_keluar')) $table->string('alamat_keluar')->nullable();
            
            if (!Schema::hasColumn('presensis', 'status_masuk')) $table->string('status_masuk')->nullable();
            if (!Schema::hasColumn('presensis', 'status_keluar')) $table->string('status_keluar')->nullable();
            
            if (!Schema::hasColumn('presensis', 'terlambat_menit')) $table->integer('terlambat_menit')->default(0);
            if (!Schema::hasColumn('presensis', 'pulang_cepat_menit')) $table->integer('pulang_cepat_menit')->default(0);
            if (!Schema::hasColumn('presensis', 'total_jam_kerja_menit')) $table->integer('total_jam_kerja_menit')->default(0);
            
            if (!Schema::hasColumn('presensis', 'catatan')) $table->text('catatan')->nullable();
        });
    }

    public function down(): void
    {
        // Drop columns logic here if needed
    }
};