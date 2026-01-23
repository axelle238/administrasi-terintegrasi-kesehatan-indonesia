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
        $pegawai = $user->pegawai;

        $query = Antrean::with(['pasien', 'dokter']) // Load relasi dokter (locking)
            ->whereDate('tanggal_antrean', Carbon::today())
            ->whereIn('status', ['Menunggu', 'Diperiksa']);

        // Filter Poli berdasarkan Poli Dokter
        if ($pegawai && $pegawai->poli_id) {
            $query->where('poli_id', $pegawai->poli_id);
        }

        $antreanMenunggu = $query->orderByRaw("FIELD(status, 'Diperiksa', 'Menunggu')")
            ->orderBy('id', 'asc')
            ->get();

        // History
        $history = RekamMedis::where('dokter_id', $user->id)
            ->with('pasien')
            ->latest()
            ->paginate(5);

        return view('livewire.rekam-medis.index', [
            'antreanMenunggu' => $antreanMenunggu,
            'history' => $history
        ])->layout('layouts.app', ['header' => 'Pemeriksaan Medis (Dokter)']);
    }
}