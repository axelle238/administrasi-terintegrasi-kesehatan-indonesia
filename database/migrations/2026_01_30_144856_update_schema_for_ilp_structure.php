<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update Tabel Polis untuk Klaster ILP
        Schema::table('polis', function (Blueprint $table) {
            // Enum Klaster ILP
            $table->enum('ilp_cluster', [
                'Klaster 1 (Manajemen)',
                'Klaster 2 (Ibu & Anak)',
                'Klaster 3 (Dewasa & Lansia)',
                'Klaster 4 (Penanggulangan Penyakit)',
                'Lintas Klaster'
            ])->nullable()->after('nama_poli')->default('Lintas Klaster');
        });

        // 2. Update Tabel Pasien untuk Kategori Siklus Hidup
        Schema::table('pasiens', function (Blueprint $table) {
            $table->string('kategori_usia')->nullable()->after('tanggal_lahir')
                ->comment('Bayi, Balita, Anak, Remaja, Dewasa, Lansia');
        });

        // 3. Update Tabel Antrean untuk Skrining Awal
        Schema::table('antreans', function (Blueprint $table) {
            $table->boolean('is_skrining_ilp')->default(false)->after('status');
            $table->json('hasil_skrining')->nullable()->after('is_skrining_ilp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('polis', function (Blueprint $table) {
            $table->dropColumn('ilp_cluster');
        });

        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn('kategori_usia');
        });

        Schema::table('antreans', function (Blueprint $table) {
            $table->dropColumn(['is_skrining_ilp', 'hasil_skrining']);
        });
    }
};