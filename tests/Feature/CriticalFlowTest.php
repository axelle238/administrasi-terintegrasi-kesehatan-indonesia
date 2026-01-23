<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Antrean;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Poli;
use App\Models\RekamMedis;
use App\Models\Surat;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CriticalFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_tindakan()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $poli = Poli::create([
            'nama_poli' => 'Poli Umum',
            'kode_poli' => 'P001'
        ]);

        $this->actingAs($admin);

        // Test Create
        Livewire::test(\App\Livewire\System\Tindakan\Index::class)
            ->call('create')
            ->set('nama_tindakan', 'Suntik Vitamin')
            ->set('poli_id', $poli->id)
            ->set('harga', 50000)
            ->call('save')
            ->assertDispatched('notify');

        $this->assertDatabaseHas('tindakans', [
            'nama_tindakan' => 'Suntik Vitamin',
            'poli_id' => $poli->id,
            'harga' => 50000
        ]);

        $tindakan = Tindakan::where('nama_tindakan', 'Suntik Vitamin')->first();

        // Test Edit
        Livewire::test(\App\Livewire\System\Tindakan\Index::class)
            ->call('edit', $tindakan->id)
            ->set('harga', 60000)
            ->call('save')
            ->assertDispatched('notify');

        $this->assertDatabaseHas('tindakans', [
            'id' => $tindakan->id,
            'harga' => 60000
        ]);
    }

    public function test_apotek_can_process_prescription()
    {
        $apoteker = User::factory()->create(['role' => 'apoteker']);
        $pasien = Pasien::create([
            'nik' => '1234567890123456',
            'nama_lengkap' => 'Pasien Obat',
            'no_telepon' => '08123456789',
            'alamat' => 'Jl. Obat',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Jakarta'
        ]);

        $obat = Obat::create([
            'kode_obat' => 'PARA',
            'nama_obat' => 'Paracetamol',
            'jenis_obat' => 'Tablet',
            'stok' => 100,
            'min_stok' => 10,
            'satuan' => 'Strip',
            'harga_satuan' => 500,
            'tanggal_kedaluwarsa' => '2026-01-01'
        ]);

        // Create Rekam Medis with Prescription (Status Menunggu)
        $rekamMedis = RekamMedis::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $apoteker->id, // Mock doctor
            'tanggal_periksa' => now(),
            'keluhan' => 'Demam',
            'diagnosa' => 'Febris',
            'status_resep' => 'Menunggu'
        ]);

        $rekamMedis->obats()->attach($obat->id, ['jumlah' => 10, 'aturan_pakai' => '3x1']);

        // Create Antrean with status Farmasi
        $antrean = Antrean::create([
            'pasien_id' => $pasien->id,
            'status' => 'Farmasi',
            'nomor_antrean' => 'F-001',
            'tanggal_antrean' => now()
        ]);

        $this->actingAs($apoteker);

        // Test Index (List)
        Livewire::test(\App\Livewire\Apotek\Index::class)
            ->assertSee('Pasien Obat');

        // Test Process
        Livewire::test(\App\Livewire\Apotek\Process::class, ['rekamMedis' => $rekamMedis])
            ->call('process')
            ->assertDispatched('notify');

        // Assert Database Changes
        $this->assertDatabaseHas('rekam_medis', [
            'id' => $rekamMedis->id,
            'status_resep' => 'Selesai'
        ]);

        $this->assertDatabaseHas('antreans', [
            'id' => $antrean->id,
            'status' => 'Kasir'
        ]);

        $this->assertDatabaseHas('obats', [
            'id' => $obat->id,
            'stok' => 90 // 100 - 10
        ]);
        
        $this->assertDatabaseHas('transaksi_obats', [
            'obat_id' => $obat->id,
            'jumlah' => 10,
            'jenis_transaksi' => 'Keluar'
        ]);
    }

    public function test_admin_can_manage_surat()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $this->actingAs($admin);

        // Test Create Surat Masuk
        Livewire::test(\App\Livewire\Surat\Create::class)
            ->set('nomor_surat', 'SRT/001/2026')
            ->set('tanggal_surat', '2026-01-20')
            ->set('perihal', 'Undangan Rapat')
            ->set('jenis_surat', 'Masuk')
            ->set('pengirim', 'Dinas Kesehatan')
            ->set('status_disposisi', 'Pending')
            ->call('save')
            ->assertDispatched('notify');

        $this->assertDatabaseHas('surats', [
            'nomor_surat' => 'SRT/001/2026',
            'jenis_surat' => 'Masuk',
            'status_disposisi' => 'Pending'
        ]);
    }
}