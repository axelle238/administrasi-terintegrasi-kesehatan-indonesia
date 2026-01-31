<?php

namespace App\Livewire\Kepegawaian\Presensi;

use Livewire\Component;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class History extends Component
{
    public $bulan;
    public $tahun;
    public $daysInMonth = [];
    public $attendanceData = [];
    
    public $stats = [
        'Hadir' => 0,
        'Terlambat' => 0,
        'Dinas Luar' => 0,
        'Absen' => 0
    ];

    public function mount()
    {
        $this->bulan = Carbon::now()->month;
        $this->tahun = Carbon::now()->year;
        $this->loadData();
    }

    public function updated($field)
    {
        if ($field == 'bulan' || $field == 'tahun') {
            $this->loadData();
        }
    }

    public function loadData()
    {
        // 1. Generate Struktur Kalender
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1);
        $daysInMonth = $date->daysInMonth;
        
        $this->daysInMonth = [];
        // Padding awal bulan (kosong jika tanggal 1 bukan Senin)
        // Carbon dayOfWeek: 0 (Sun) - 6 (Sat). Kita mau Senin=0 atau Minggu=0?
        // Default View Kalender biasanya Minggu - Sabtu.
        $startDayOfWeek = $date->dayOfWeek; // 0 (Sun) to 6 (Sat)
        
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $this->daysInMonth[] = null;
        }

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $this->daysInMonth[] = $i;
        }

        // 2. Ambil Data Presensi
        $presensis = Presensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->keyBy(function($item) {
                return Carbon::parse($item->tanggal)->day;
            });

        $this->attendanceData = $presensis;

        // 3. Hitung Statistik
        $this->stats['Hadir'] = $presensis->where('status_kehadiran', 'Hadir')->count();
        $this->stats['Terlambat'] = $presensis->where('status_kehadiran', 'Terlambat')->count();
        $this->stats['Dinas Luar'] = $presensis->filter(function($p) {
            return str_contains($p->status_kehadiran, 'Dinas') || str_contains($p->jenis_presensi, 'DL');
        })->count();
        
        // Asumsi hari kerja standar (Senin-Jumat) dikurangi total hadir/cuti/libur untuk 'Absen'
        // Untuk sederhananya kita hitung Absen = Hari Kerja Lalu - Data Presensi
        // (Logic kompleks butuh data libur & shift, kita skip dulu)
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1)->subMonth();
        $this->bulan = $date->month;
        $this->tahun = $date->year;
        $this->loadData();
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1)->addMonth();
        $this->bulan = $date->month;
        $this->tahun = $date->year;
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.kepegawaian.presensi.history')
            ->layout('layouts.app', ['header' => 'Kalender Kehadiran']);
    }
}
