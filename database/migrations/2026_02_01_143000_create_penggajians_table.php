<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('penggajians')) {
            Schema::create('penggajians', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pegawai (User)
                $table->integer('bulan');
                $table->integer('tahun');
                $table->decimal('gaji_pokok', 15, 2);
                $table->decimal('total_tunjangan', 15, 2)->default(0);
                $table->decimal('total_potongan', 15, 2)->default(0);
                $table->decimal('gaji_bersih', 15, 2);
                $table->string('status')->default('Draft'); // Draft, Final, Paid
                $table->date('tanggal_bayar')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};