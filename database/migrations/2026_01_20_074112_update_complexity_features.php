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
        // 1. SISTEM KEPEGAWAIAN: Tabel Master Shift
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_shift')->comment('Contoh: Pagi, Siang, Malam');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });

        // Tabel Jadwal Jaga Pegawai
        Schema::create('jadwal_jagas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');
            $table->date('tanggal')->comment('Tanggal bertugas');
            $table->enum('status_kehadiran', ['Belum Hadir', 'Hadir', 'Izin', 'Sakit', 'Alpha'])->default('Belum Hadir');
            $table->timestamps();
        });

        // 2. SISTEM INTERNAL: Tabel Antrean Pasien
        Schema::create('antreans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->string('poli_tujuan')->default('Umum')->comment('Umum, Gigi, KIA, dll');
            $table->string('nomor_antrean')->comment('A001, B002, dst');
            $table->date('tanggal_antrean');
            $table->enum('status', ['Menunggu', 'Diperiksa', 'Farmasi', 'Selesai', 'Batal'])->default('Menunggu');
            $table->timestamps();
        });

        // 3. SISTEM INTERNAL: Update Rekam Medis (Tambah Vital Signs)
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Tanda-tanda vital (Vital Signs)
            $table->string('tekanan_darah')->nullable()->after('tanggal_periksa')->comment('mmHg (120/80)');
            $table->decimal('suhu_tubuh', 4, 1)->nullable()->after('tekanan_darah')->comment('Celcius');
            $table->decimal('berat_badan', 5, 2)->nullable()->after('suhu_tubuh')->comment('Kg');
            $table->integer('tinggi_badan')->nullable()->after('berat_badan')->comment('Cm');
            $table->integer('nadi')->nullable()->after('tinggi_badan')->comment('bpm');
            $table->integer('pernapasan')->nullable()->after('nadi')->comment('x/menit');
            
            // Status resep
            $table->enum('status_resep', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu')->after('resep_obat');
        });

        // 4. SISTEM SURAT: Tambah Kolom Disposisi
        Schema::table('surats', function (Blueprint $table) {
            $table->text('disposisi')->nullable()->after('file_path')->comment('Instruksi pimpinan ke staf');
            $table->string('tujuan_disposisi')->nullable()->after('disposisi');
            $table->enum('status_disposisi', ['Pending', 'Diteruskan', 'Selesai'])->default('Pending')->after('tujuan_disposisi');
        });

        // 5. SISTEM OBAT: Tambah Min Stock Alert
        Schema::table('obats', function (Blueprint $table) {
            $table->integer('min_stok')->default(10)->after('stok')->comment('Batas minimal untuk alert');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_jagas');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('antreans');
        
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->dropColumn(['tekanan_darah', 'suhu_tubuh', 'berat_badan', 'tinggi_badan', 'nadi', 'pernapasan', 'status_resep']);
        });

        Schema::table('surats', function (Blueprint $table) {
            $table->dropColumn(['disposisi', 'tujuan_disposisi', 'status_disposisi']);
        });

        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn('min_stok');
        });
    }
};