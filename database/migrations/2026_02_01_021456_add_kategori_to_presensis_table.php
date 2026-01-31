<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            // Kategori: WFO (Kantor), WFH (Rumah), DL (Dinas Luar)
            if (!Schema::hasColumn('presensis', 'kategori')) {
                $table->string('kategori')->default('WFO')->after('tanggal'); 
            }
        });
    }

    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};