<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Change enum to string to allow more flexible statuses like 'Menunggu Obat', 'Tidak Ada Resep'
            $table->string('status_resep')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting this might be tricky if data exists that violates the enum, 
        // but typically we'd revert to the enum definition.
        // For safety in this environment, we won't strictly enforce revert logic here to avoid data loss.
    }
};