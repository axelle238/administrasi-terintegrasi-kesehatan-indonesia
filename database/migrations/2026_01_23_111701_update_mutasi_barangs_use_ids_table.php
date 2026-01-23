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
        Schema::table('mutasi_barangs', function (Blueprint $table) {
            $table->foreignId('ruangan_id_asal')->nullable()->after('lokasi_asal')->constrained('ruangans');
            $table->foreignId('ruangan_id_tujuan')->nullable()->after('lokasi_tujuan')->constrained('ruangans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mutasi_barangs', function (Blueprint $table) {
            $table->dropForeign(['ruangan_id_asal']);
            $table->dropForeign(['ruangan_id_tujuan']);
            $table->dropColumn(['ruangan_id_asal', 'ruangan_id_tujuan']);
        });
    }
};