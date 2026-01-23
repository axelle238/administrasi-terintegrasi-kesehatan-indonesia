<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Antrean;
use App\Models\Poli;
use App\Models\Obat;
use App\Models\Tindakan;
use App\Models\RekamMedis;
use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class FullFlowTest extends TestCase
{
    public function test_full_patient_journey()
    {
        // Cleanup potential leftovers
        Pasien::where('nik', '1234567890123456')->forceDelete();

        // 1. Setup Data
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
        $dokter = User::where('role', 'dokter')->first() ?? User::factory()->create(['role' => 'dokter']);
        
        $poli = Poli::first() ?? Poli::create(['nama_poli' => 'Poli Umum', 'kode_poli' => 'PU01']);
        $obat = Obat::where('stok', '>', 5)->first() ?? Obat::create([
            'nama_obat' => 'Paracetamol', 
            'kode_obat' => 'OB01', 
            'stok' => 100, 
            'harga_satuan' => 500, 
            'jenis_obat' => 'Tablet', 
            'satuan' => 'Strip',
            'tanggal_kedaluwarsa' => now()->addYear()
        ]);
        $tindakan = Tindakan::first() ?? Tindakan::create(['nama_tindakan' => 'Pemeriksaan Umum', 'kode_tindakan' => 'T01', 'harga' => 15000, 'poli_id' => $poli->id]);

        // A. Create Pasien
        $pasien = Pasien::create([
            'nik' => '1234567890123456',
            'nama_lengkap' => 'Test Pasien Flow',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Test',
            'no_telepon' => '08123456789',
            // 'asuransi' => 'Umum' // Assuming column exists or not required by fillable, check model
        ]);
        $this->assertDatabaseHas('pasiens', ['nik' => '1234567890123456']);

        // B. Create Antrean
        $antrean = Antrean::create([
            'pasien_id' => $pasien->id,
            'poli_id' => $poli->id,
            'nomor_antrean' => 'A-999',
            'tanggal_antrean' => now(),
            'status' => 'Menunggu'
        ]);
        $this->assertEquals('Menunggu', $antrean->status);

        // C. Dokter Examines (Rekam Medis)
        $antrean->update(['status' => 'Diperiksa']);
        
        $rekamMedis = RekamMedis::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id,
            'tanggal_periksa' => now(),
            'keluhan' => 'Sakit Kepala',
            'diagnosa' => 'A00 - Cholera',
            'status_resep' => 'Menunggu Obat',
            'status_pemeriksaan' => 'Selesai'
        ]);
        
        $rekamMedis->tindakans()->attach($tindakan->id, ['biaya' => $tindakan->harga]);
        $rekamMedis->obats()->attach($obat->id, ['jumlah' => 2, 'aturan_pakai' => '3x1']);
        
        $antrean->update(['status' => 'Farmasi']);
        
        $this->assertDatabaseHas('rekam_medis', ['id' => $rekamMedis->id]);
        $this->assertEquals('Menunggu Obat', $rekamMedis->status_resep);

        // D. Pharmacy Process
        $initialStock = $obat->fresh()->stok;
        $obat->decrement('stok', 2);
        $rekamMedis->update(['status_resep' => 'Selesai']);
        $antrean->update(['status' => 'Kasir']);

        $this->assertEquals($initialStock - 2, $obat->fresh()->stok);
        $this->assertEquals('Selesai', $rekamMedis->fresh()->status_resep);

        // E. Cashier Process (Billing)
        $totalTagihan = $tindakan->harga + ($obat->harga_satuan * 2) + 10000;
        
        $pembayaran = Pembayaran::create([
            'no_transaksi' => 'INV-TEST-001',
            'rekam_medis_id' => $rekamMedis->id,
            'pasien_id' => $pasien->id,
            'total_tagihan' => $totalTagihan,
            'jumlah_bayar' => $totalTagihan,
            'status' => 'Lunas',
            'kasir_id' => $admin->id
        ]);
        
        $antrean->update(['status' => 'Selesai']);

        $this->assertEquals('Lunas', $pembayaran->status);
        $this->assertEquals('Selesai', $antrean->fresh()->status);
        
        // Cleanup
        $pembayaran->delete();
        $rekamMedis->tindakans()->detach();
        $rekamMedis->obats()->detach();
        $rekamMedis->delete();
        $antrean->delete();
        $pasien->forceDelete();
    }
}
