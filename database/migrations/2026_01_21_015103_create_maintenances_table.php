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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->date('tanggal_maintenance');
            $table->string('jenis_kegiatan'); // Perbaikan, Kalibrasi, Pemeliharaan Rutin
            $table->text('keterangan')->nullable();
            $table->string('teknisi')->nullable(); // Nama teknisi / Vendor
            $table->decimal('biaya', 15, 2)->default(0);
            $table->date('tanggal_berikutnya')->nullable(); // Reminder
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};