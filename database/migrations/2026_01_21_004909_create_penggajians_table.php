<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('bulan'); // Januari, Februari
            $table->year('tahun');
            $table->decimal('gaji_pokok', 15, 2);
            $table->decimal('tunjangan', 15, 2)->default(0);
            $table->decimal('potongan', 15, 2)->default(0);
            $table->decimal('total_gaji', 15, 2);
            $table->string('status')->default('Pending'); // Pending, Paid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};