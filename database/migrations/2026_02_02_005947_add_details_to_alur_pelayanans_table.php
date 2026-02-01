<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('icon'); // Foto Ilustrasi
            $table->string('penanggung_jawab')->nullable()->after('target_pasien'); // e.g. "Petugas Pendaftaran"
            $table->string('lokasi')->nullable()->after('penanggung_jawab'); // e.g. "Lantai 1, Loket A"
            $table->boolean('is_critical')->default(false)->after('is_active'); // Highlight step penting
            $table->json('faq')->nullable()->after('dokumen_syarat'); // JSON Array untuk FAQ spesifik
        });
    }

    public function down(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->dropColumn(['gambar', 'penanggung_jawab', 'lokasi', 'is_critical', 'faq']);
        });
    }
};