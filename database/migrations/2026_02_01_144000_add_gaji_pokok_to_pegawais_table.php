<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->decimal('gaji_pokok', 15, 2)->default(0)->after('status_kepegawaian');
            $table->string('nomor_rekening')->nullable()->after('gaji_pokok');
            $table->string('nama_bank')->nullable()->after('nomor_rekening');
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn(['gaji_pokok', 'nomor_rekening', 'nama_bank']);
        });
    }
};