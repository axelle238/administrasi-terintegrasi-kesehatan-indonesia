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
        Schema::table('pembayarans', function (Blueprint $table) {
            if (!Schema::hasColumn('pembayarans', 'no_transaksi')) {
                $table->string('no_transaksi')->unique()->after('id');
            }
            if (!Schema::hasColumn('pembayarans', 'pasien_id')) {
                $table->foreignId('pasien_id')->nullable()->constrained('pasiens')->onDelete('cascade')->after('rekam_medis_id');
            }
            if (!Schema::hasColumn('pembayarans', 'biaya_administrasi')) {
                $table->decimal('biaya_administrasi', 15, 2)->default(0)->after('total_biaya_obat');
            }
            if (!Schema::hasColumn('pembayarans', 'total_tagihan')) {
                $table->decimal('total_tagihan', 15, 2)->default(0)->after('biaya_administrasi');
            }
            if (!Schema::hasColumn('pembayarans', 'jumlah_bayar')) {
                $table->decimal('jumlah_bayar', 15, 2)->default(0)->after('metode_pembayaran');
            }
            if (!Schema::hasColumn('pembayarans', 'kembalian')) {
                $table->decimal('kembalian', 15, 2)->default(0)->after('jumlah_bayar');
            }
            if (!Schema::hasColumn('pembayarans', 'status')) {
                $table->string('status')->default('Pending')->after('kembalian');
            }
            if (!Schema::hasColumn('pembayarans', 'kasir_id')) {
                $table->foreignId('kasir_id')->nullable()->constrained('users')->after('status');
            }
            
            // Standardize total_bayar vs total_tagihan logic if needed
            // Assuming total_bayar was the old 'total_tagihan'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};