<?php

namespace App\Livewire\Surat\Keterangan;

use App\Models\SuratKeterangan;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $isOpen = false;
    
    // Form
    public $pasien_id;
    public $jenis_surat = 'Sehat';
    public $keperluan;
    public $lama_istirahat;
    public $mulai_istirahat;
    public $catatan;
    
    // Medical Data
    public $tinggi_badan;
    public $berat_badan;
    public $tekanan_darah;
    public $golongan_darah;
    public $buta_warna; // Normal/Buta Warna

    public function mount()
    {
        //
    }

    public function create()
    {
        $this->resetInput();
        $this->isOpen = true;
    }

    public function resetInput()
    {
        $this->reset([
            'pasien_id', 'jenis_surat', 'keperluan', 'lama_istirahat', 
            'mulai_istirahat', 'catatan', 'tinggi_badan', 'berat_badan', 
            'tekanan_darah', 'golongan_darah', 'buta_warna'
        ]);
        $this->jenis_surat = 'Sehat';
        $this->mulai_istirahat = date('Y-m-d');
    }

    public function save()
    {
        $rules = [
            'pasien_id' => 'required|exists:pasiens,id',
            'jenis_surat' => 'required|in:Sehat,Sakit,Buta Warna,Bebas Narkoba',
        ];

        if ($this->jenis_surat == 'Sehat' || $this->jenis_surat == 'Buta Warna') {
            $rules['tinggi_badan'] = 'required|numeric';
            $rules['berat_badan'] = 'required|numeric';
            $rules['tekanan_darah'] = 'required|string';
            $rules['keperluan'] = 'required|string';
        }

        if ($this->jenis_surat == 'Sakit') {
            $rules['lama_istirahat'] = 'required|numeric|min:1';
            $rules['mulai_istirahat'] = 'required|date';
        }

        $this->validate($rules);

        // Generate Number: SK/2024/001 (Simplified)
        $count = SuratKeterangan::whereYear('created_at', date('Y'))->count() + 1;
        $number = 'SK/' . date('Y') . '/' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $dataMedis = [
            'tinggi_badan' => $this->tinggi_badan,
            'berat_badan' => $this->berat_badan,
            'tekanan_darah' => $this->tekanan_darah,
            'golongan_darah' => $this->golongan_darah,
            'buta_warna' => $this->buta_warna,
        ];

        SuratKeterangan::create([
            'nomor_surat' => $number,
            'pasien_id' => $this->pasien_id,
            'dokter_id' => Auth::id(),
            'jenis_surat' => $this->jenis_surat,
            'tanggal_surat' => now(),
            'data_medis' => $dataMedis,
            'keperluan' => $this->keperluan,
            'lama_istirahat' => $this->lama_istirahat,
            'mulai_istirahat' => $this->mulai_istirahat,
            'catatan' => $this->catatan,
        ]);

        $this->dispatch('notify', 'success', 'Surat Keterangan berhasil dibuat.');
        $this->isOpen = false;
    }

    public function render()
    {
        $surats = SuratKeterangan::with(['pasien', 'dokter'])
            ->whereHas('pasien', function($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        $pasiens = Pasien::orderBy('nama_lengkap')->limit(50)->get(); // Should use search for scalability

        return view('livewire.surat.keterangan.index', [
            'surats' => $surats,
            'pasiens' => $pasiens
        ])->layout('layouts.app', ['header' => 'Surat Keterangan Dokter']);
    }
}