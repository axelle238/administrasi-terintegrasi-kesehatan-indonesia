<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->string('golongan')->default('Bebas')->after('jenis_obat'); // Bebas, Bebas Terbatas, Keras, Narkotika, Psikotropika
        });
    }

    public function down(): void
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn('golongan');
        });
    }
};