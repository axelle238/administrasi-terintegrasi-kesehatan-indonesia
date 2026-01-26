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
        Schema::table('penggajians', function (Blueprint $table) {
            // Breakdown Tunjangan
            $table->decimal('tunjangan_jabatan', 15, 2)->default(0)->after('gaji_pokok');
            $table->decimal('tunjangan_fungsional', 15, 2)->default(0)->after('tunjangan_jabatan');
            $table->decimal('tunjangan_umum', 15, 2)->default(0)->after('tunjangan_fungsional');
            $table->decimal('tunjangan_makan', 15, 2)->default(0)->after('tunjangan_umum');
            $table->decimal('tunjangan_transport', 15, 2)->default(0)->after('tunjangan_makan');
            
            // Breakdown Potongan
            $table->decimal('potongan_bpjs_kesehatan', 15, 2)->default(0)->after('tunjangan'); // 'tunjangan' column exists as total
            $table->decimal('potongan_bpjs_tk', 15, 2)->default(0)->after('potongan_bpjs_kesehatan');
            $table->decimal('potongan_pph21', 15, 2)->default(0)->after('potongan_bpjs_tk');
            $table->decimal('potongan_absen', 15, 2)->default(0)->after('potongan_pph21');
            
            // Catatan
            $table->text('catatan')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penggajians', function (Blueprint $table) {
            $table->dropColumn([
                'tunjangan_jabatan',
                'tunjangan_fungsional',
                'tunjangan_umum',
                'tunjangan_makan',
                'tunjangan_transport',
                'potongan_bpjs_kesehatan',
                'potongan_bpjs_tk',
                'potongan_pph21',
                'potongan_absen',
                'catatan'
            ]);
        });
    }
};