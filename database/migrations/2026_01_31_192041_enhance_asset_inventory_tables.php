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
        Schema::table('barangs', function (Blueprint $table) {
            $table->integer('min_stok')->default(0)->after('stok')->comment('Batas stok minimum untuk alert');
            $table->string('status_ketersediaan')->default('Tersedia')->after('kondisi')->comment('Tersedia, Dipinjam, Maintenance, Dihapuskan');
        });

        Schema::table('maintenances', function (Blueprint $table) {
            $table->string('file_sertifikat')->nullable()->after('biaya')->comment('Path file sertifikat kalibrasi/service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['min_stok', 'status_ketersediaan']);
        });

        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropColumn('file_sertifikat');
        });
    }
};