<?php

namespace App\Livewire\Pasien;

use App\Models\Pasien;
use App\Services\BpjsBridgingService;
use Livewire\Component;

class Create extends Component
{
    public $nik;
    public $no_bpjs;
    public $nama_lengkap;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $no_telepon;
    public $golongan_darah;
    public $asuransi = 'Umum';
    public $faskes_asal;
    public $prolanis;
    
    // PRB Data
    public $is_prb = false;
    public $no_prb;
    public $catatan_prb;
    
    // BPJS Status Data
    public $bpjsStatus = null;
    public $bpjsMessage = '';

    protected $rules = [
        'nik' => 'required|digits:16|unique:pasiens,nik',
        'no_bpjs' => 'nullable|numeric|unique:pasiens,no_bpjs',
        'nama_lengkap' => 'required|string|max:255',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'alamat' => 'required|string',
        'no_telepon' => 'required|string|max:15',
        'golongan_darah' => 'nullable|in:A,B,AB,O',
        'asuransi' => 'required|string',
        'faskes_asal' => 'nullable|string',
        'prolanis' => 'nullable|string',
        'is_prb' => 'boolean',
        'no_prb' => 'nullable|string',
        'catatan_prb' => 'nullable|string',
    ];

    public function checkBpjs(BpjsBridgingService $bpjsService)
    {
        if (empty($this->no_bpjs) && empty($this->nik)) {
            $this->addError('no_bpjs', 'Masukkan No BPJS atau NIK untuk pengecekan.');
            return;
        }

        $keyword = $this->no_bpjs ?: $this->nik;
        $result = $bpjsService->getPeserta($keyword);

        if ($result['status'] == 'success') {
            $data = $result['data'];
            
            // Auto Fill Form
            $this->nama_lengkap = $data['nama'];
            $this->nik = $data['nik'];
            $this->no_bpjs = $data['noKartu'];
            $this->tanggal_lahir = $data['tglLahir'];
            $this->jenis_kelamin = $data['sex'] == 'L' ? 'Laki-laki' : 'Perempuan';
            $this->asuransi = 'BPJS';
            $this->faskes_asal = $data['provUmum']['nmProvider'] ?? '';
            
            // Mock PRB Detection (In real BPJS API, check peserta.informasi.prolanisPRB)
            if (isset($data['informasi']['prolanisPRB'])) {
                $this->is_prb = true;
                $this->catatan_prb = $data['informasi']['prolanisPRB'];
            }
            
            // Set Status
            if ($data['statusPeserta']['keterangan'] == 'AKTIF') {
                $this->bpjsStatus = 'active';
                $this->bpjsMessage = '✔ Peserta AKTIF - ' . ($data['kelasTanggungan']['nmKelas'] ?? 'Kelas -');
            } else {
                $this->bpjsStatus = 'inactive';
                $this->bpjsMessage = '❌ Peserta TIDAK AKTIF: ' . $data['statusPeserta']['keterangan'];
            }
            
            $this->dispatch('notify', 'success', 'Data ditemukan di BPJS Kesehatan.');
        } else {
            $this->bpjsStatus = 'error';
            $this->bpjsMessage = 'Data tidak ditemukan di BPJS.';
            $this->dispatch('notify', 'error', 'Data tidak ditemukan.');
        }
    }
    
    public function save()
    {
        $this->validate();

        Pasien::create([
            'nik' => $this->nik,
            'no_bpjs' => $this->no_bpjs,
            'nama_lengkap' => $this->nama_lengkap,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'no_telepon' => $this->no_telepon,
            'golongan_darah' => $this->golongan_darah,
            'asuransi' => $this->asuransi,
            'faskes_asal' => $this->faskes_asal,
            'prolanis' => $this->prolanis,
            'is_prb' => $this->is_prb,
            'no_prb' => $this->no_prb,
            'catatan_prb' => $this->catatan_prb,
        ]);

        $this->dispatch('notify', 'success', 'Pasien baru berhasil didaftarkan.');
        return $this->redirect(route('pasien.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.pasien.create')->layout('layouts.app', ['header' => 'Pendaftaran Pasien Baru']);
    }
}
