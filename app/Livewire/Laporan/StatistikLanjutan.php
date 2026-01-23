<?php

namespace App\Livewire\Laporan;

use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Poli;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StatistikLanjutan extends Component
{
    public $year;

    public function mount()
    {
        $this->year = date('Y');
    }

    public function render()
    {
        // 1. Gender Distribution
        $genderData = [
            'Laki-laki' => Pasien::where('jenis_kelamin', 'Laki-laki')->count(),
            'Perempuan' => Pasien::where('jenis_kelamin', 'Perempuan')->count(),
        ];

        // 2. Age Group Distribution
        $ageGroups = [
            'Balita (0-5)' => Pasien::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) <= 5')->count(),
            'Anak (6-12)' => Pasien::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 6 AND 12')->count(),
            'Remaja (13-18)' => Pasien::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 18')->count(),
            'Dewasa (19-59)' => Pasien::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 19 AND 59')->count(),
            'Lansia (60+)' => Pasien::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60')->count(),
        ];

        // 3. Polyclinic Usage (Antrean data or RekamMedis with Poli if available)
        // Since RekamMedis is linked to Antrean which is linked to Poli
        $poliStats = DB::table('antreans')
            ->join('polis', 'antreans.poli_id', '=', 'polis.id')
            ->select('polis.nama_poli', DB::raw('count(*) as total'))
            ->groupBy('polis.nama_poli')
            ->get();

        return view('livewire.laporan.statistik-lanjutan', [
            'genderData' => $genderData,
            'ageGroups' => $ageGroups,
            'poliStats' => $poliStats,
        ])->layout('layouts.app', ['header' => 'Statistik & Analitik Lanjutan']);
    }
}
