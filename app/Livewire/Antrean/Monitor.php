<?php

namespace App\Livewire\Antrean;

use App\Models\Antrean;
use Carbon\Carbon;
use Livewire\Component;

class Monitor extends Component
{
    public $lastCalledId;

    public function render()
    {
        $sedangDipanggil = Antrean::with('pasien')
            ->whereDate('tanggal_antrean', Carbon::today())
            ->where('status', 'Diperiksa')
            ->latest('updated_at')
            ->first();

        // Check if new call
        if ($sedangDipanggil && $sedangDipanggil->id !== $this->lastCalledId) {
            $this->lastCalledId = $sedangDipanggil->id;
            $this->dispatch('announce-queue', [
                'id' => $sedangDipanggil->id,
                'nomor_antrean' => $sedangDipanggil->nomor_antrean,
                'poli_tujuan' => $sedangDipanggil->poli->nama_poli ?? 'Poli Tujuan'
            ]);
        }

        $sedangDipanggilFarmasi = Antrean::with('pasien')
            ->whereDate('tanggal_antrean', Carbon::today())
            ->where('status', 'Farmasi')
            ->latest('updated_at')
            ->first();

        $antreanBerikutnya = Antrean::with('pasien')
            ->whereDate('tanggal_antrean', Carbon::today())
            ->where('status', 'Menunggu')
            ->orderBy('id', 'asc')
            ->take(4)
            ->get();

        return view('livewire.antrean.monitor', [
            'sedangDipanggil' => $sedangDipanggil,
            'sedangDipanggilFarmasi' => $sedangDipanggilFarmasi,
            'antreanBerikutnya' => $antreanBerikutnya
        ])->layout('layouts.fullscreen'); 
    }
}