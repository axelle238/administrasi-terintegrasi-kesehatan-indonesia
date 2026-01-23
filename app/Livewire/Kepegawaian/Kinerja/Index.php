<?php

namespace App\Livewire\Kepegawaian\Kinerja;

use App\Models\KinerjaPegawai;
use App\Models\Pegawai;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $pegawai_id;
    public $bulan;
    public $tahun;
    
    // Scores
    public $orientasi_pelayanan = 0;
    public $integritas = 0;
    public $komitmen = 0;
    public $disiplin = 0;
    public $kerjasama = 0;
    public $catatan_atasan;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function create()
    {
        $this->reset(['pegawai_id', 'orientasi_pelayanan', 'integritas', 'komitmen', 'disiplin', 'kerjasama', 'catatan_atasan']);
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric',
            'orientasi_pelayanan' => 'required|numeric|min:0|max:100',
            // ... add validation for others
        ]);

        KinerjaPegawai::updateOrCreate(
            ['pegawai_id' => $this->pegawai_id, 'bulan' => $this->bulan, 'tahun' => $this->tahun],
            [
                'orientasi_pelayanan' => $this->orientasi_pelayanan,
                'integritas' => $this->integritas,
                'komitmen' => $this->komitmen,
                'disiplin' => $this->disiplin,
                'kerjasama' => $this->kerjasama,
                'catatan_atasan' => $this->catatan_atasan,
                'penilai' => Auth::user()->name
            ]
        );

        $this->dispatch('notify', 'success', 'Penilaian kinerja berhasil disimpan.');
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.kepegawaian.kinerja.index', [
            'kinerjas' => KinerjaPegawai::with('pegawai.user')->where('tahun', $this->tahun)->where('bulan', $this->bulan)->paginate(10),
            'pegawais' => Pegawai::with('user')->get()
        ])->layout('layouts.app', ['header' => 'Penilaian Kinerja Pegawai (SKP)']);
    }
}
