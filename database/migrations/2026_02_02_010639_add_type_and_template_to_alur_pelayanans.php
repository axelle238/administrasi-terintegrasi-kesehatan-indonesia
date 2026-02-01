<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            // Offline, Online, Hybrid
            $table->string('tipe_alur')->default('Offline')->after('judul'); 
            // Path file yang bisa didownload user
            $table->string('file_template')->nullable()->after('video_url'); 
        });
    }

    public function down(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->dropColumn(['tipe_alur', 'file_template']);
        });
    }
};