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
            $table->date('garansi_mulai')->nullable()->after('keterangan');
            $table->date('garansi_selesai')->nullable()->after('garansi_mulai');
            $table->string('penanggung_garansi')->nullable()->after('garansi_selesai')->comment('Distributor/Principal');
            $table->string('cakupan_garansi')->nullable()->after('penanggung_garansi')->comment('Full, Service Only, Sparepart');
            $table->string('nomor_kontrak_servis')->nullable()->after('cakupan_garansi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn([
                'garansi_mulai',
                'garansi_selesai',
                'penanggung_garansi',
                'cakupan_garansi',
                'nomor_kontrak_servis'
            ]);
        });
    }
};