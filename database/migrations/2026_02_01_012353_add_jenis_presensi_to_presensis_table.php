<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            if (!Schema::hasColumn('presensis', 'jenis_presensi')) {
                // WFO, WFH, Dinas Luar, Sakit, Izin
                $table->string('jenis_presensi')->default('WFO')->after('user_id');
                $table->text('keterangan')->nullable()->after('jenis_presensi'); // Untuk detail Dinas/Sakit
            }
        });
    }

    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropColumn(['jenis_presensi', 'keterangan']);
        });
    }
};