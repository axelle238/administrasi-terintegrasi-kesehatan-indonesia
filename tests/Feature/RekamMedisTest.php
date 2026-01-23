<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Antrean;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RekamMedisTest extends TestCase
{
    use RefreshDatabase;

    public function test_dokter_can_create_medical_record()
    {
        // Setup Data
        $dokter = User::factory()->create(['role' => 'dokter']);
        $pasien = Pasien::create([
            'nik' => '1111111111111111',
            'nama_lengkap' => 'Pasien Sakit',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Sakit',
            'no_telepon' => '0811111111',
        ]);
        
        $antrean = Antrean::create([
            'pasien_id' => $pasien->id,
            'poli_tujuan' => 'Poli Umum',
            'nomor_antrean' => 'A-001',
            'tanggal_antrean' => Carbon::today(),
            'status' => 'Diperiksa',
        ]);

        $obat = Obat::create([
            'kode_obat' => 'TEST-01',
            'nama_obat' => 'Obat Test',
            'jenis_obat' => 'Tablet',
            'stok' => 10,
            'min_stok' => 1,
            'satuan' => 'Pcs',
            'harga_satuan' => 1000,
            'tanggal_kedaluwarsa' => '2030-01-01',
        ]);

        // Act
        $this->actingAs($dokter);

        $component = Livewire::test(\App\Livewire\RekamMedis\Create::class, ['antrean_id' => $antrean->id])
            ->set('keluhan', 'Sakit Kepala')
            ->set('diagnosa', 'Cephalgia')
            ->set('resep.0.obat_id', $obat->id)
            ->set('resep.0.jumlah', 2)
            ->set('resep.0.aturan_pakai', '2x1')
            ->call('save');
            
        $component->assertDispatched('notify');

        // Assert
        $this->assertDatabaseHas('rekam_medis', [
            'pasien_id' => $pasien->id,
            'diagnosa' => 'Cephalgia',
            'status_resep' => 'Menunggu Obat'
        ]);

        $this->assertDatabaseHas('antreans', [
            'id' => $antrean->id,
            'status' => 'Farmasi'
        ]);
    }
}