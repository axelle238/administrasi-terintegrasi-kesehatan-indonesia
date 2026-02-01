<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presensi_upacaras', function (Blueprint $table) {
            $table->string('latitude')->nullable()->after('status');
            $table->string('longitude')->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('presensi_upacaras', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};