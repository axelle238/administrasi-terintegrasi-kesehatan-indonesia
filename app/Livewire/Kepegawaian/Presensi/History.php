<?php

namespace App\Livewire\Kepegawaian\Presensi;

use Livewire\Component;
use App\Models\Presensi;
use App\Models\LaporanHarian;
use App\Models\HariLibur;
use App\Models\PengajuanCuti;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class History extends Component
{
    public $bulan;
    public $tahun;
    public $selectedDate = null;

    public function mount()
    {
        $this->bulan = Carbon::now()->month;
        $this->tahun = Carbon::now()->year;
    }

    // Navigasi Bulan Modern
    public function prevMonth()
    {
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1)->subMonth();
        $this->bulan = $date->month;
        $this->tahun = $date->year;
        $this->selectedDate = null; // Reset seleksi
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1)->addMonth();
        $this->bulan = $date->month;
        $this->tahun = $date->year;
        $this->selectedDate = null;
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function render()
    {
        $startOfMonth = Carbon::createFromDate($this->tahun, $this->bulan, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $firstDayOfWeek = $startOfMonth->dayOfWeekIso; 

        // Data Fetching
        $userId = Auth::id();
        
        $presensiData = Presensi::where('user_id', $userId)
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->keyBy(fn($item) => $item->tanggal->format('Y-m-d'));

        $hariLiburData = HariLibur::whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->keyBy(fn($item) => $item->tanggal->format('Y-m-d'));

        $cutiData = PengajuanCuti::where('user_id', $userId)
            ->where('status', 'Disetujui')
            ->where(function($q) use ($startOfMonth, $endOfMonth) {
                 $q->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                   ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
            })
            ->get();

        // Statistik Bulanan (Real-time Calculation)
        $stats = [
            'hadir' => $presensiData->where('status_masuk', '!=', 'Terlambat')->count(),
            'terlambat' => $presensiData->where('status_masuk', 'Terlambat')->count(),
            'cuti' => 0, // Hitung nanti di loop
            'alpha' => 0 // Hitung nanti
        ];

        $calendar = [];
        
        // Padding
        for ($i = 1; $i < $firstDayOfWeek; $i++) {
            $calendar[] = null;
        }

        // Logic Loop Tanggal
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = Carbon::createFromDate($this->tahun, $this->bulan, $day);
            $dateString = $currentDate->format('Y-m-d');
            
            $isWeekend = $currentDate->isWeekend();
            $libur = $hariLiburData[$dateString] ?? null;
            $presensi = $presensiData[$dateString] ?? null;
            
            $cuti = $cutiData->first(function($item) use ($currentDate) {
                return $currentDate->between(
                    Carbon::parse($item->tanggal_mulai), 
                    Carbon::parse($item->tanggal_selesai)
                );
            });
            
            $status = 'Absen'; 
            if ($presensi) {
                $status = $presensi->status_masuk == 'Terlambat' ? 'Terlambat' : 'Hadir';
                if ($presensi->status_keluar == 'Pulang Cepat') $status = 'Pulang Cepat';
                if (str_contains($presensi->kategori, 'Dinas Luar')) $status = 'Dinas Luar';
                if ($presensi->kategori == 'WFH') $status = 'WFH';
            } elseif ($cuti) {
                $status = 'Cuti';
                $stats['cuti']++;
            } elseif ($libur) {
                $status = 'Libur';
            } elseif ($isWeekend) {
                $status = 'Akhir Pekan';
            } elseif ($currentDate->isFuture()) {
                $status = 'Future';
            } else {
                // Jika masa lalu, bukan weekend, bukan libur, dan tidak ada presensi
                $status = 'Alpha';
                $stats['alpha']++;
            }

            $calendar[] = [
                'date' => $dateString,
                'day' => $day,
                'is_today' => $currentDate->isToday(),
                'status' => $status,
                'presensi' => $presensi,
                'libur' => $libur,
                'cuti' => $cuti
            ];
        }

        // Detail Data
        $detailPresensi = null;
        $detailLaporan = null;
        $detailCuti = null;
        
        if ($this->selectedDate) {
            $detailPresensi = Presensi::where('user_id', $userId)
                ->whereDate('tanggal', $this->selectedDate)
                ->first();
                
            $detailLaporan = LaporanHarian::with('details')
                ->where('user_id', $userId)
                ->whereDate('tanggal', $this->selectedDate)
                ->first();

            $selDate = Carbon::parse($this->selectedDate);
            $detailCuti = $cutiData->first(function($item) use ($selDate) {
                return $selDate->between(
                    Carbon::parse($item->tanggal_mulai), 
                    Carbon::parse($item->tanggal_selesai)
                );
            });
        }

        return view('livewire.kepegawaian.presensi.history', [
            'calendar' => $calendar,
            'stats' => $stats, // Pass stats to view
            'detailPresensi' => $detailPresensi,
            'detailLaporan' => $detailLaporan,
            'detailCuti' => $detailCuti,
            'namaBulan' => $startOfMonth->translatedFormat('F Y')
        ])->layout('layouts.app', ['header' => 'Kalender Kehadiran']);
    }
}