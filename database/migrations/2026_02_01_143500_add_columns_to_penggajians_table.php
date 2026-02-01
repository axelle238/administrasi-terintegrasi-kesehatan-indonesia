<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penggajians', function (Blueprint $table) {
            // Drop column if exists (cleanup) or just add
            if (!Schema::hasColumn('penggajians', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->integer('bulan');
                $table->integer('tahun');
                $table->decimal('gaji_pokok', 15, 2)->default(0);
                $table->decimal('total_tunjangan', 15, 2)->default(0);
                $table->decimal('total_potongan', 15, 2)->default(0);
                $table->decimal('gaji_bersih', 15, 2)->default(0);
                $table->string('status')->default('Draft');
                $table->date('tanggal_bayar')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('penggajians', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'bulan', 'tahun', 'gaji_pokok', 'total_tunjangan', 'total_potongan', 'gaji_bersih', 'status', 'tanggal_bayar']);
        });
    }
};