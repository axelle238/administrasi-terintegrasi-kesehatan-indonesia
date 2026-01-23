<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->boolean('is_prb')->default(false)->after('prolanis');
            $table->string('no_prb')->nullable()->after('is_prb');
            $table->text('catatan_prb')->nullable()->after('no_prb');
        });
    }

    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn(['is_prb', 'no_prb', 'catatan_prb']);
        });
    }
};