<?php

namespace App\Livewire\RekamMedis;

use App\Models\Antrean;
use App\Models\RekamMedis;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai; // Pastikan user memiliki relasi pegawai

        // Base Query untuk Antrean Hari Ini
        $queryAntrean = Antrean::with(['pasien'])
            ->whereDate('tanggal_antrean', Carbon::today());

        if ($pegawai && $pegawai->poli_id) {
            $queryAntrean->where('poli_id', $pegawai->poli_id);
        }

        // Stats
        $totalMenunggu = (clone $queryAntrean)->whereIn('status', ['Menunggu', 'Diperiksa'])->count();
        $totalSelesaiHariIni = (clone $queryAntrean)->where('status', 'Selesai')->count();
        
        $totalDitanganiBulanIni = RekamMedis::where('dokter_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Data List Antrean (Prioritas Diperiksa)
        $antreanMenunggu = $queryAntrean
            ->whereIn('status', ['Menunggu', 'Diperiksa'])
            ->orderByRaw("FIELD(status, 'Diperiksa', 'Menunggu')")
            ->orderBy('id', 'asc')
            ->get();

        // History Pemeriksaan Dokter Ini
        $history = RekamMedis::where('dokter_id', $user->id)
            ->with('pasien')
            ->latest()
            ->paginate(5);

        return view('livewire.rekam-medis.index', compact(
            'antreanMenunggu', 
            'history',
            'totalMenunggu',
            'totalSelesaiHariIni',
            'totalDitanganiBulanIni'
        ))->layout('layouts.app', ['header' => 'Pemeriksaan Medis (Dokter)']);
    }
}
