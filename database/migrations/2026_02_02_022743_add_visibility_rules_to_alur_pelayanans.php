<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            if (!Schema::hasColumn('alur_pelayanans', 'visibility_rules')) {
                $table->json('visibility_rules')->nullable()->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('alur_pelayanans', function (Blueprint $table) {
            $table->dropColumn('visibility_rules');
        });
    }
};