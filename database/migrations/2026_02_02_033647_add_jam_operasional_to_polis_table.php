<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('polis', function (Blueprint $table) {
            if (!Schema::hasColumn('polis', 'jam_operasional')) {
                $table->string('jam_operasional')->nullable()->default('08:00 - 14:00')->after('nama_poli');
            }
            if (!Schema::hasColumn('polis', 'hari_buka')) {
                $table->string('hari_buka')->nullable()->default('Senin - Sabtu')->after('jam_operasional');
            }
        });
    }

    public function down(): void
    {
        Schema::table('polis', function (Blueprint $table) {
            $table->dropColumn(['jam_operasional', 'hari_buka']);
        });
    }
};