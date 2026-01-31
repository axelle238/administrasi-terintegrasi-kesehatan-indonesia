<?php

namespace App\Livewire\Kepegawaian\Presensi;

use Livewire\Component;
use App\Models\Presensi;
use App\Models\LaporanHarian;
use App\Models\HariLibur;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class History extends Component
{
    public $bulan;
    public $tahun;
    public $selectedDate = null; // Tanggal yang diklik user untuk detail

    public function mount()
    {
        $this->bulan = Carbon::now()->month;
        $this->tahun = Carbon::now()->year;
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function render()
    {
        // 1. Siapkan Struktur Kalender
        $startOfMonth = Carbon::createFromDate($this->tahun, $this->bulan, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $firstDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 (Senin) - 7 (Minggu)

        // 2. Ambil Data Presensi Bulan Ini
        $presensiData = Presensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->keyBy(fn($item) => $item->tanggal->format('Y-m-d'));

        // 3. Ambil Data Hari Libur
        $hariLiburData = HariLibur::whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->keyBy(fn($item) => $item->tanggal->format('Y-m-d'));

        $calendar = [];
        
        // Padding hari kosong di awal bulan (jika tgl 1 bukan Senin)
        for ($i = 1; $i < $firstDayOfWeek; $i++) {
            $calendar[] = null;
        }

        // Isi tanggal
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = Carbon::createFromDate($this->tahun, $this->bulan, $day);
            $dateString = $currentDate->format('Y-m-d');
            
            $isWeekend = $currentDate->isWeekend();
            $libur = $hariLiburData[$dateString] ?? null;
            $presensi = $presensiData[$dateString] ?? null;
            
            $status = 'Absen'; // Default alpha
            if ($presensi) {
                $status = $presensi->status_masuk == 'Terlambat' ? 'Terlambat' : 'Hadir';
                if ($presensi->status_keluar == 'Pulang Cepat') $status = 'Pulang Cepat';
                if (str_contains($presensi->kategori, 'Dinas Luar')) $status = 'Dinas Luar';
                if ($presensi->kategori == 'WFH') $status = 'WFH';
            } elseif ($libur) {
                $status = 'Libur';
            } elseif ($isWeekend) {
                $status = 'Akhir Pekan';
            } elseif ($currentDate->isFuture()) {
                $status = 'Future';
            }

            $calendar[] = [
                'date' => $dateString,
                'day' => $day,
                'is_today' => $currentDate->isToday(),
                'status' => $status,
                'presensi' => $presensi,
                'libur' => $libur
            ];
        }

        // Detail Data untuk Panel Bawah (Selected Date)
        $detailPresensi = null;
        $detailLaporan = null;
        
        if ($this->selectedDate) {
            $detailPresensi = Presensi::where('user_id', Auth::id())
                ->whereDate('tanggal', $this->selectedDate)
                ->first();
                
            $detailLaporan = LaporanHarian::with('details')
                ->where('user_id', Auth::id())
                ->whereDate('tanggal', $this->selectedDate)
                ->first();
        }

        return view('livewire.kepegawaian.presensi.history', [
            'calendar' => $calendar,
            'detailPresensi' => $detailPresensi,
            'detailLaporan' => $detailLaporan,
            'namaBulan' => $startOfMonth->translatedFormat('F Y')
        ])->layout('layouts.app', ['header' => 'Kalender Kehadiran']);
    }
}