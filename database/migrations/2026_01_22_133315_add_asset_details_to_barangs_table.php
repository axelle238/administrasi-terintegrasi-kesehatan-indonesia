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
        Schema::table('barangs', function (Blueprint $table) {
            $table->text('spesifikasi')->nullable()->after('merk')->comment('Spesifikasi detail barang');
            $table->string('nomor_seri')->nullable()->after('kode_barang')->comment('Serial number barang elektronik/alkes');
            $table->string('nomor_pabrik')->nullable()->after('nomor_seri')->comment('Nomor pabrik');
            $table->string('nomor_registrasi')->nullable()->after('nomor_pabrik')->comment('Nomor registrasi aset');
            
            $table->string('sumber_dana')->nullable()->after('tanggal_pengadaan')->comment('Sumber dana (APBD, BLUD, Hibah, dll)');
            $table->decimal('harga_perolehan', 15, 2)->default(0)->after('sumber_dana')->comment('Harga beli awal');
            $table->decimal('nilai_buku', 15, 2)->default(0)->after('harga_perolehan')->comment('Nilai saat ini setelah penyusutan');
            $table->integer('masa_manfaat')->default(0)->after('nilai_buku')->comment('Masa manfaat dalam tahun');
            $table->decimal('nilai_residu', 15, 2)->default(0)->after('masa_manfaat')->comment('Nilai sisa aset di akhir masa manfaat');
            
            $table->string('keterangan')->nullable()->after('lokasi_penyimpanan');
            $table->boolean('is_asset')->default(false)->after('id')->comment('True jika ini aset tetap, False jika barang habis pakai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn([
                'spesifikasi',
                'nomor_seri',
                'nomor_pabrik',
                'nomor_registrasi',
                'sumber_dana',
                'harga_perolehan',
                'nilai_buku',
                'masa_manfaat',
                'nilai_residu',
                'keterangan',
                'is_asset'
            ]);
        });
    }
};
