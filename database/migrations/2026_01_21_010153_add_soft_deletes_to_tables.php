<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('pasiens', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('rekam_medis', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('obats', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('barangs', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('pegawais', function (Blueprint $table) { $table->softDeletes(); });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('pasiens', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('rekam_medis', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('obats', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('barangs', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('pegawais', function (Blueprint $table) { $table->dropSoftDeletes(); });
    }
};