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
            $table->foreignId('ruangan_id')->nullable()->after('lokasi_penyimpanan')->constrained('ruangans')->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->after('ruangan_id')->constrained('suppliers')->onDelete('set null');
        });

        Schema::table('pengadaan_barangs', function (Blueprint $table) {
             $table->foreignId('supplier_id')->nullable()->after('pemohon_id')->constrained('suppliers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['ruangan_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['ruangan_id', 'supplier_id']);
        });

        Schema::table('pengadaan_barangs', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['supplier_id']);
        });
    }
};