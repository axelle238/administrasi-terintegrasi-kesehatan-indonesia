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
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            // Tambahkan kolom baru yang belum ada
            if (!Schema::hasColumn('alur_pelayanans', 'estimasi_biaya')) {
                $table->decimal('estimasi_biaya', 12, 2)->default(0)->after('estimasi_waktu');
            }
            
            if (!Schema::hasColumn('alur_pelayanans', 'output_langkah')) {
                $table->string('output_langkah')->nullable()->after('deskripsi');
            }

            // Pastikan kolom pendukung multimedia ada (idempotent check)
            if (!Schema::hasColumn('alur_pelayanans', 'icon')) {
                $table->string('icon')->nullable();
            }
            if (!Schema::hasColumn('alur_pelayanans', 'gambar')) {
                $table->string('gambar')->nullable();
            }
            if (!Schema::hasColumn('alur_pelayanans', 'video_url')) {
                $table->string('video_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            if (Schema::hasColumn('alur_pelayanans', 'estimasi_biaya')) {
                $table->dropColumn('estimasi_biaya');
            }
            if (Schema::hasColumn('alur_pelayanans', 'output_langkah')) {
                $table->dropColumn('output_langkah');
            }
        });
    }
};
