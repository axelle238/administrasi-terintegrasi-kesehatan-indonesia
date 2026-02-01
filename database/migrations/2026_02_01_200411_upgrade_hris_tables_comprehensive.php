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
        // 1. Upgrade Tabel Pegawai Utama (Tambahkan yang belum ada saja)
        Schema::table('pegawais', function (Blueprint $table) {
            
            // Identitas Pribadi Tambahan
            if (!Schema::hasColumn('pegawais', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('pegawais', 'agama')) {
                $table->string('agama')->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('pegawais', 'golongan_darah')) {
                $table->string('golongan_darah', 3)->nullable()->after('agama');
            }
            if (!Schema::hasColumn('pegawais', 'status_pernikahan')) {
                $table->string('status_pernikahan')->nullable()->after('golongan_darah');
            }
            
            // Kontak Darurat Detail
            if (!Schema::hasColumn('pegawais', 'kontak_darurat_relasi')) {
                $table->string('kontak_darurat_relasi')->nullable()->after('kontak_darurat_nama');
            }
            // Note: kontak_darurat_telp sudah ada, skip kontak_darurat_telepon

            // Keuangan & Pajak Detail
            if (!Schema::hasColumn('pegawais', 'npwp')) {
                $table->string('npwp', 20)->nullable()->after('tanggal_masuk');
            }
            if (!Schema::hasColumn('pegawais', 'pemilik_rekening')) {
                $table->string('pemilik_rekening')->nullable()->after('nomor_rekening');
            }
            
            // Jaminan Sosial
            if (!Schema::hasColumn('pegawais', 'no_bpjs_kesehatan')) {
                $table->string('no_bpjs_kesehatan')->nullable()->after('pemilik_rekening');
            }
            if (!Schema::hasColumn('pegawais', 'no_bpjs_ketenagakerjaan')) {
                $table->string('no_bpjs_ketenagakerjaan')->nullable()->after('no_bpjs_kesehatan');
            }
            
            // Status Aktif
            if (!Schema::hasColumn('pegawais', 'tanggal_berhenti')) {
                $table->date('tanggal_berhenti')->nullable()->after('no_bpjs_ketenagakerjaan');
            }
            if (!Schema::hasColumn('pegawais', 'alasan_berhenti')) {
                $table->string('alasan_berhenti')->nullable()->after('tanggal_berhenti');
            }
            if (!Schema::hasColumn('pegawais', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('alasan_berhenti');
            }
        });

        // 2. Tabel Keluarga Pegawai
        if (!Schema::hasTable('keluarga_pegawais')) {
            Schema::create('keluarga_pegawais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
                $table->string('nama');
                $table->string('nik', 16)->nullable();
                $table->enum('hubungan', ['Suami', 'Istri', 'Anak', 'Orang Tua']);
                $table->date('tanggal_lahir')->nullable();
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
                $table->string('pekerjaan')->nullable();
                $table->boolean('status_tunjangan')->default(false)->comment('Apakah masuk dalam tanggungan tunjangan?');
                $table->timestamps();
            });
        }

        // 3. Tabel Riwayat Pendidikan
        if (!Schema::hasTable('riwayat_pendidikan_pegawais')) {
            Schema::create('riwayat_pendidikan_pegawais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
                $table->enum('jenjang', ['SD', 'SMP', 'SMA/SMK', 'D3', 'D4', 'S1', 'S2', 'S3', 'Non-Formal']);
                $table->string('nama_institusi');
                $table->string('jurusan')->nullable();
                $table->year('tahun_lulus')->nullable();
                $table->float('ipk')->nullable(); 
                $table->string('nomor_ijazah')->nullable();
                $table->timestamps();
            });
        }

        // 4. Tabel Dokumen Digital (Arsip Pegawai)
        if (!Schema::hasTable('dokumen_pegawais')) {
            Schema::create('dokumen_pegawais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
                $table->string('nama_dokumen'); 
                $table->string('kategori_dokumen')->nullable(); 
                $table->string('file_path');
                $table->string('tipe_file')->nullable(); 
                $table->date('tanggal_kadaluarsa')->nullable(); 
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }
        
        // 5. Tabel Riwayat Jabatan
        if (!Schema::hasTable('riwayat_jabatan_pegawais')) {
            Schema::create('riwayat_jabatan_pegawais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
                $table->string('jabatan_baru');
                $table->string('unit_kerja_baru')->nullable();
                $table->string('nomor_sk')->nullable();
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai')->nullable();
                $table->string('jenis_mutasi')->default('Promosi'); 
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatan_pegawais');
        Schema::dropIfExists('dokumen_pegawais');
        Schema::dropIfExists('riwayat_pendidikan_pegawais');
        Schema::dropIfExists('keluarga_pegawais');
        
        Schema::table('pegawais', function (Blueprint $table) {
            $columnsToDrop = [
                'jenis_kelamin', 'agama', 'golongan_darah', 'status_pernikahan', 
                'kontak_darurat_relasi', 'npwp', 'pemilik_rekening', 
                'no_bpjs_kesehatan', 'no_bpjs_ketenagakerjaan', 'tanggal_berhenti', 
                'alasan_berhenti', 'is_active'
            ];
            
            // Only drop if exists to avoid error
            foreach($columnsToDrop as $col) {
                if(Schema::hasColumn('pegawais', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};