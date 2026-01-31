<?php

namespace App\Livewire\Kepegawaian\Presensi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Presensi;
use App\Models\LaporanHarian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class History extends Component
{
    use WithPagination;

    public $bulan;
    public $tahun;

    public function mount()
    {
        $this->bulan = Carbon::now()->month;
        $this->tahun = Carbon::now()->year;
    }

    public function render()
    {
        // Ambil Data Presensi
        $history = Presensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        // Ambil Data Laporan Aktivitas untuk dicocokkan (Eager Loading tidak bisa langsung cross model dinamis tanpa relasi fix, kita query manual atau relasi di model user)
        // Cara terbaik: Ambil koleksi laporan di bulan ini, key by tanggal
        $laporanList = LaporanHarian::where('user_id', Auth::id())
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->keyBy(function($item) {
                return $item->tanggal->format('Y-m-d');
            });

        return view('livewire.kepegawaian.presensi.history', [
            'history' => $history,
            'laporanList' => $laporanList
        ])->layout('layouts.app', ['header' => 'Data Kehadiran & Aktivitas']);
    }
}