<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('gambar'); // Link Youtube/Video
            $table->string('action_label')->nullable()->after('video_url'); // Label Tombol (e.g. "Daftar Online")
            $table->string('action_url')->nullable()->after('action_label'); // Link Tujuan (e.g. "/pendaftaran")
        });
    }

    public function down(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'action_label', 'action_url']);
        });
    }
};