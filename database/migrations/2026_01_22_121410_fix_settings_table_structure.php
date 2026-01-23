<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'group')) {
                $table->string('group')->default('general')->after('type');
            }
            if (!Schema::hasColumn('settings', 'label')) {
                $table->string('label')->nullable()->after('group');
            }
            // drop description if exists as we use label now
            if (Schema::hasColumn('settings', 'description')) {
                // We migrate data first if needed, but for now just drop or keep. Keep to avoid data loss.
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};