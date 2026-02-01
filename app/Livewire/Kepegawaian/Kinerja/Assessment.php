<?php

namespace App\Livewire\Kepegawaian\Kinerja;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PeriodePenilaian;
use App\Models\IndikatorKinerja;
use App\Models\PenilaianPegawai;
use App\Models\DetailPenilaian;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Assessment extends Component
{
    use WithPagination;

    // View State
    public $viewMode = 'list'; // list, create_period, scoring
    public $selectedPeriodeId;
    public $selectedPegawaiId;

    // Form Periode
    public $judul_periode;
    public $tgl_mulai;
    public $tgl_selesai;

    // Form Scoring
    public $scores = []; // [indikator_id => nilai]
    public $catatan_penilai;

    public function render()
    {
        $periodes = PeriodePenilaian::withCount('penilaians')->latest()->get();
        
        $pegawais = [];
        if ($this->viewMode == 'scoring') {
            // Load pegawai yang belum dinilai atau sedang dinilai di periode ini
            $pegawais = Pegawai::with(['user', 'poli'])->orderBy('jabatan')->get();
        }

        return view('livewire.kepegawaian.kinerja.assessment', [
            'periodes' => $periodes,
            'pegawais' => $pegawais,
            'indikators' => IndikatorKinerja::all()
        ])->layout('layouts.app', ['header' => 'Manajemen Kinerja (KPI)']);
    }

    // === PERIODE MANAGEMENT ===
    
    public function createPeriode()
    {
        $this->reset(['judul_periode', 'tgl_mulai', 'tgl_selesai']);
        $this->viewMode = 'create_period';
    }

    public function savePeriode()
    {
        $this->validate([
            'judul_periode' => 'required',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_mulai',
        ]);

        PeriodePenilaian::create([
            'judul' => $this->judul_periode,
            'tanggal_mulai' => $this->tgl_mulai,
            'tanggal_selesai' => $this->tgl_selesai,
            'is_active' => true
        ]);

        $this->dispatch('notify', 'success', 'Periode penilaian baru dibuka.');
        $this->viewMode = 'list';
    }

    public function openScoring($periodeId)
    {
        $this->selectedPeriodeId = $periodeId;
        $this->viewMode = 'scoring';
    }

    // === SCORING LOGIC ===

    public function selectPegawai($pegawaiId)
    {
        $this->selectedPegawaiId = $pegawaiId;
        
        // Load existing scores if any
        $existing = PenilaianPegawai::where('periode_id', $this->selectedPeriodeId)
            ->where('pegawai_id', $pegawaiId)
            ->with('details')
            ->first();

        $this->scores = [];
        $this->catatan_penilai = '';

        if ($existing) {
            foreach ($existing->details as $detail) {
                $this->scores[$detail->indikator_id] = $detail->skor;
            }
            $this->catatan_penilai = $existing->catatan_penilai;
        } else {
            // Initialize with 0
            $indikators = IndikatorKinerja::all();
            foreach ($indikators as $ind) {
                $this->scores[$ind->id] = 0;
            }
        }
    }

    public function saveScore()
    {
        $this->validate([
            'scores.*' => 'required|numeric|min:0|max:100',
            'catatan_penilai' => 'nullable|string'
        ]);

        DB::transaction(function() {
            // 1. Calculate Final Score
            $totalBobot = 0;
            $totalNilai = 0;
            $indikators = IndikatorKinerja::all()->keyBy('id');

            foreach ($this->scores as $indId => $skor) {
                if (isset($indikators[$indId])) {
                    $bobot = $indikators[$indId]->bobot;
                    $totalBobot += $bobot;
                    $totalNilai += ($skor * $bobot) / 100; // Weighted score (assuming bobot is percent)
                }
            }

            // Predikat
            $predikat = 'Kurang';
            if ($totalNilai >= 90) $predikat = 'Sangat Baik';
            elseif ($totalNilai >= 75) $predikat = 'Baik';
            elseif ($totalNilai >= 60) $predikat = 'Cukup';

            // 2. Save Header
            $penilaian = PenilaianPegawai::updateOrCreate(
                [
                    'periode_id' => $this->selectedPeriodeId,
                    'pegawai_id' => $this->selectedPegawaiId
                ],
                [
                    'penilai_id' => Auth::id(),
                    'skor_akhir' => $totalNilai,
                    'predikat' => $predikat,
                    'catatan_penilai' => $this->catatan_penilai,
                    'status' => 'Final'
                ]
            );

            // 3. Save Details
            foreach ($this->scores as $indId => $skor) {
                $bobot = $indikators[$indId]->bobot ?? 0;
                $nilaiTerbobot = ($skor * $bobot) / 100;

                DetailPenilaian::updateOrCreate(
                    [
                        'penilaian_id' => $penilaian->id,
                        'indikator_id' => $indId
                    ],
                    [
                        'skor' => $skor,
                        'nilai_terbobot' => $nilaiTerbobot
                    ]
                );
            }
        });

        $this->dispatch('notify', 'success', 'Penilaian berhasil disimpan.');
        $this->selectedPegawaiId = null; // Close detailed view
    }

    public function backToList()
    {
        $this->viewMode = 'list';
        $this->selectedPeriodeId = null;
        $this->selectedPegawaiId = null;
    }
}