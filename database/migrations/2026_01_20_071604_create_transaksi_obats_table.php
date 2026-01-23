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
        Schema::create('transaksi_obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade')->comment('Obat yang ditransaksikan');
            
            $table->enum('jenis_transaksi', ['Masuk', 'Keluar'])->comment('Masuk = Supply baru, Keluar = Pemakaian pasien/Expired');
            $table->integer('jumlah')->comment('Jumlah obat yang masuk/keluar');
            $table->date('tanggal_transaksi')->comment('Tanggal kejadian');
            $table->text('keterangan')->nullable()->comment('Asal supply atau Nama Pasien penerima');
            $table->string('pencatat')->nullable()->comment('Nama petugas yang mencatat (opsional)');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_obats');
    }
};