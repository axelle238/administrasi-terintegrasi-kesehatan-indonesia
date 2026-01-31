<?php

namespace App\Livewire\Kepegawaian\Presensi;

use Livewire\Component;
use App\Models\Presensi;
use App\Models\LaporanKinerjaHarian;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class History extends Component
{
    public $bulan;
    public $tahun;
    public $daysInMonth = [];
    
    // Data Collections
    public $attendanceData = [];
    public $lkhData = [];
    public $cutiData = [];
    
    public $stats = [
        'Hadir' => 0,
        'Terlambat' => 0,
        'Dinas Luar' => 0,
        'Cuti' => 0
    ];

    // Modal State
    public $selectedDate = null;
    public $isOpen = false;
    
    // LKH Form State
    public $aktivitas;
    public $deskripsi;
    public $isCuti = false;

    protected $rules = [
        'aktivitas' => 'required|string|max:255',
        'deskripsi' => 'required|string',
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
        $startDayOfWeek = $date->dayOfWeek; // 0 (Sun) - 6 (Sat)
        
        $this->daysInMonth = [];
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $this->daysInMonth[] = null;
        }
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $this->daysInMonth[] = $i;
        }

        // 2. Ambil Data
        $userId = Auth::id();

        // Presensi
        $this->attendanceData = Presensi::where('user_id', $userId)
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->keyBy(function($item) {
                return Carbon::parse($item->tanggal)->day;
            });

        // LKH
        $this->lkhData = LaporanKinerjaHarian::where('user_id', $userId)
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->tanggal)->day;
            });

        // Cuti (Disetujui)
        // Cuti bisa rentang tanggal, jadi perlu loop
        $cutis = PengajuanCuti::where('user_id', $userId)
            ->where('status', 'Disetujui')
            ->where(function($q) {
                $q->whereMonth('tanggal_mulai', $this->bulan)
                  ->whereYear('tanggal_mulai', $this->tahun)
                  ->orWhereMonth('tanggal_selesai', $this->bulan)
                  ->whereYear('tanggal_selesai', $this->tahun);
            })
            ->get();

        $this->cutiData = [];
        foreach ($cutis as $cuti) {
            $start = Carbon::parse($cuti->tanggal_mulai);
            $end = Carbon::parse($cuti->tanggal_selesai);
            
            // Loop setiap hari dalam range cuti
            for ($date = $start; $date->lte($end); $date->addDay()) {
                if ($date->month == $this->bulan && $date->year == $this->tahun) {
                    $this->cutiData[$date->day] = $cuti;
                }
            }
        }

        // 3. Hitung Statistik
        $this->stats['Hadir'] = $this->attendanceData->where('status_kehadiran', 'Hadir')->count();
        $this->stats['Terlambat'] = $this->attendanceData->where('status_kehadiran', 'Terlambat')->count();
        $this->stats['Dinas Luar'] = $this->attendanceData->filter(function($p) {
            return str_contains($p->status_kehadiran, 'Dinas') || str_contains($p->jenis_presensi, 'DL');
        })->count();
        $this->stats['Cuti'] = count($this->cutiData);
    }

    public function selectDate($day)
    {
        if (!$day) return;

        $this->selectedDate = Carbon::createFromDate($this->tahun, $this->bulan, $day)->format('Y-m-d');
        $this->isCuti = isset($this->cutiData[$day]);
        
        // Reset Form
        $this->aktivitas = '';
        $this->deskripsi = '';
        
        $this->isOpen = true;
    }

    public function saveLKH()
    {
        if ($this->isCuti) {
            $this->addError('aktivitas', 'Anda sedang cuti pada tanggal ini.');
            return;
        }

        $this->validate();

        LaporanKinerjaHarian::create([
            'user_id' => Auth::id(),
            'tanggal' => $this->selectedDate,
            'jam_mulai' => '08:00', // Default jam kerja jika input cepat
            'jam_selesai' => '16:00',
            'aktivitas' => $this->aktivitas,
            'deskripsi' => $this->deskripsi,
            'persentase_selesai' => 100, // Quick add assumes completed
            'prioritas' => 'Normal',
            'status' => 'Pending'
        ]);

        $this->dispatch('notify', 'success', 'Laporan aktivitas berhasil ditambahkan.');
        $this->loadData(); // Refresh data kalender
        $this->isOpen = false;
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
            ->layout('layouts.app', ['header' => 'Kalender Kehadiran & Aktivitas']);
    }
}