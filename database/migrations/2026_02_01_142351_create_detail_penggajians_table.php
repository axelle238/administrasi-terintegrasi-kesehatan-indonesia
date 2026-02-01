<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penggajians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penggajian_id')->constrained('penggajians')->cascadeOnDelete(); // Asumsi tabel penggajians ada
            $table->string('nama_komponen');
            $table->enum('jenis', ['Penerimaan', 'Potongan']);
            $table->decimal('jumlah', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penggajians');
    }
};