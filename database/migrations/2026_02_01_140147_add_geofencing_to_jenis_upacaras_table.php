<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_upacaras', function (Blueprint $table) {
            // Koordinat Target Upacara (Default: Kantor/Lapangan)
            $table->string('target_latitude')->nullable()->after('kategori');
            $table->string('target_longitude')->nullable()->after('target_latitude');
            $table->integer('radius_meter')->default(100)->after('target_longitude'); // Toleransi jarak
        });
    }

    public function down(): void
    {
        Schema::table('jenis_upacaras', function (Blueprint $table) {
            $table->dropColumn(['target_latitude', 'target_longitude', 'radius_meter']);
        });
    }
};