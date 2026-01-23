<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->string('asuransi')->default('Umum')->after('no_bpjs'); // Umum, BPJS, Asuransi Lain
            $table->string('faskes_asal')->nullable()->after('asuransi'); // Untuk rujukan masuk
            $table->string('prolanis')->nullable()->after('faskes_asal'); // Program Pengelolaan Penyakit Kronis
        });
    }

    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn(['asuransi', 'faskes_asal', 'prolanis']);
        });
    }
};