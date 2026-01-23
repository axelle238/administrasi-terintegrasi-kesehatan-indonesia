<?php

namespace App\Livewire\Antrean;

use App\Models\Antrean;
use App\Models\Pasien;
use App\Models\Poli;
use App\Services\BpjsBridgingService;
use Carbon\Carbon;
use Livewire\Component;

class Kiosk extends Component
{
    public $step = 1; // 1: Input NIK/BPJS, 2: Pilih Poli, 3: Cetak Tiket
    public $identifier; // NIK or No BPJS
    public $pasien;
    public $polis;
    public $selected_poli_id;
    public $nomor_antrean;
    public $message;

    public function mount()
    {
        $this->polis = Poli::all();
    }

    public function checkPasien(BpjsBridgingService $bpjs)
    {
        $this->validate([
            'identifier' => 'required|numeric|digits_between:10,16'
        ]);

        // 1. Cek DB Lokal
        $this->pasien = Pasien::where('nik', $this->identifier)
            ->orWhere('no_bpjs', $this->identifier)
            ->first();

        // 2. Jika tidak ada, Cek BPJS (Bridging) dan Auto Register
        if (!$this->pasien) {
            $res = $bpjs->getPeserta($this->identifier);
            if ($res['status'] == 'success') {
                $data = $res['data'];
                // Auto Create Pasien
                $this->pasien = Pasien::create([
                    'nik' => $data['nik'],
                    'no_bpjs' => $data['noKartu'],
                    'nama_lengkap' => $data['nama'],
                    'tanggal_lahir' => $data['tglLahir'],
                    'jenis_kelamin' => $data['sex'] == 'L' ? 'Laki-laki' : 'Perempuan',
                    'alamat' => 'Alamat BPJS', // Placeholder
                    'no_telepon' => '0000000000', // Placeholder
                    'asuransi' => 'BPJS',
                ]);
            } else {
                $this->addError('identifier', 'Pasien tidak ditemukan. Silakan ke loket pendaftaran manual.');
                return;
            }
        }

        // Cek apakah sudah ambil antrean hari ini
        $exists = Antrean::where('pasien_id', $this->pasien->id)
            ->whereDate('tanggal_antrean', Carbon::today())
            ->exists();

        if ($exists) {
            $this->addError('identifier', 'Anda sudah mengambil antrean hari ini.');
            return;
        }

        $this->step = 2;
    }

    public function selectPoli($poli_id)
    {
        $this->selected_poli_id = $poli_id;
        $this->processAntrean();
    }

    public function processAntrean()
    {
        $poli = Poli::find($this->selected_poli_id);
        
        // Generate Nomor
        $prefix = 'A'; // Default
        if (str_contains(strtolower($poli->nama_poli), 'gigi')) $prefix = 'B';
        if (str_contains(strtolower($poli->nama_poli), 'kia')) $prefix = 'C';

        $count = Antrean::whereDate('tanggal_antrean', Carbon::today())
                 ->where('poli_id', $this->selected_poli_id)
                 ->count();
        
        $this->nomor_antrean = $prefix . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        Antrean::create([
            'pasien_id' => $this->pasien->id,
            'poli_id' => $this->selected_poli_id,
            'nomor_antrean' => $this->nomor_antrean,
            'tanggal_antrean' => Carbon::today(),
            'status' => 'Menunggu',
            'task_id_last' => 1 // Checkin
        ]);

        $this->step = 3;
    }

    public function resetKiosk()
    {
        $this->reset(['step', 'identifier', 'pasien', 'selected_poli_id', 'nomor_antrean']);
    }

    public function render()
    {
        return view('livewire.antrean.kiosk')->layout('layouts.guest'); // Fullscreen layout
    }
}
