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
        // 1. Master Data Tindakan / Layanan Medis (Sesuai Perda Retribusi biasanya)
        Schema::create('tindakans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tindakan');
            $table->string('poli_terkait')->default('Umum'); // Umum, Gigi, KIA
            $table->decimal('harga', 10, 2)->default(0);
            $table->timestamps();
        });

        // 2. Pivot: Obat dalam Rekam Medis (Resep Detail)
        Schema::create('rekam_medis_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('aturan_pakai')->comment('Contoh: 3x1 Sesudah Makan');
            $table->timestamps();
        });

        // 3. Pivot: Tindakan dalam Rekam Medis
        Schema::create('rekam_medis_tindakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
            $table->foreignId('tindakan_id')->constrained('tindakans')->onDelete('cascade');
            $table->decimal('biaya', 10, 2)->comment('Harga saat tindakan dilakukan (snapshot)');
            $table->timestamps();
        });

        // 4. Tabel Tagihan / Pembayaran (Kasir)
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade');
            $table->decimal('total_biaya_tindakan', 12, 2)->default(0);
            $table->decimal('total_biaya_obat', 12, 2)->default(0);
            $table->decimal('total_bayar', 12, 2);
            $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->string('metode_pembayaran')->nullable(); // Tunai, QRIS, BPJS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
        Schema::dropIfExists('rekam_medis_tindakan');
        Schema::dropIfExists('rekam_medis_obat');
        Schema::dropIfExists('tindakans');
    }
};