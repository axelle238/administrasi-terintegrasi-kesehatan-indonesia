<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Enhance Rekam Medis for SOAP
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Rename existing columns to match SOAP standard better or add aliases
            // subjective: keluhan (already exists)
            // objective: tekanan_darah, suhu, etc (already exists)
            // assessment: diagnosa (already exists)
            // plan: tindakan, resep (already exists)
            
            // Add ICD-10 Code support if not just text
            $table->string('icd10_code')->nullable()->after('diagnosa');
            $table->string('icd10_name')->nullable()->after('icd10_code');
            
            // Status Pemeriksaan
            $table->string('status_pemeriksaan')->default('Menunggu Dokter')->after('status_resep'); // Menunggu, Diperiksa, Selesai
        });

        // Link Transaksi Obat to Rekam Medis for better tracing
        Schema::table('transaksi_obats', function (Blueprint $table) {
            $table->foreignId('rekam_medis_id')->nullable()->after('obat_id')->constrained('rekam_medis')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->dropColumn(['icd10_code', 'icd10_name', 'status_pemeriksaan']);
        });

        Schema::table('transaksi_obats', function (Blueprint $table) {
            $table->dropForeign(['rekam_medis_id']);
            $table->dropColumn('rekam_medis_id');
        });
    }
};
