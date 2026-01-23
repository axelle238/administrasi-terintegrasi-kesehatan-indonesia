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
        if (!Schema::hasTable('pembayarans')) {
            Schema::create('pembayarans', function (Blueprint $table) {
                $table->id();
                $table->string('no_transaksi')->unique(); // Invoice ID
                $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
                $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
                
                // Rincian Biaya
                $table->decimal('total_biaya_tindakan', 15, 2)->default(0);
                $table->decimal('total_biaya_obat', 15, 2)->default(0);
                $table->decimal('biaya_administrasi', 15, 2)->default(0);
                $table->decimal('total_tagihan', 15, 2)->default(0);
                
                // Pembayaran
                $table->string('metode_pembayaran')->default('Tunai'); // Tunai, Transfer, BPJS
                $table->decimal('jumlah_bayar', 15, 2)->default(0);
                $table->decimal('kembalian', 15, 2)->default(0);
                
                $table->string('status')->default('Pending'); // Pending, Lunas, BPJS Terklaim
                $table->foreignId('kasir_id')->constrained('users'); // User yang memproses
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};