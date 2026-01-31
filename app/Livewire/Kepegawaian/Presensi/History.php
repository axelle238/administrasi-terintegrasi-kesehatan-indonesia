<?php

namespace App\Livewire\Kepegawaian\Presensi;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Presensi;
use App\Models\LaporanKinerjaHarian;
use App\Models\PengajuanCuti;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class History extends Component
{
    use WithFileUploads;

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

    // Selected Date State
    public $selectedDate = null;
    public $isCuti = false;
    public $selectedPresensi = null;
    public $selectedLkhList = []; // List LKH hari itu
    public $totalDurasiHariIni = 0; // Total menit
    
    // LKH Form State (Input Fields)
    public $aktivitas;
    public $kategori_kegiatan = 'Tugas Utama';
    public $deskripsi;
    public $jam_mulai;
    public $jam_selesai;
    public $durasi_menit;
    public $persentase_selesai = 100;
    public $prioritas = 'Normal';
    public $kendala_teknis;
    public $tautan_dokumen;
    public $file_bukti_kerja;

    protected $rules = [
        'aktivitas' => 'required|string|max:255',
        'kategori_kegiatan' => 'required|string',
        'deskripsi' => 'required|string',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required|after:jam_mulai',
        'durasi_menit' => 'required|integer|min:1',
        'persentase_selesai' => 'required|integer|min:0|max:100',
        'file_bukti_kerja' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',
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
            $this->selectedDate = null; // Reset selection on month change
        }
        
        // Auto calculate duration
        if ($field == 'jam_mulai' || $field == 'jam_selesai') {
            if ($this->jam_mulai && $this->jam_selesai) {
                $start = Carbon::parse($this->jam_mulai);
                $end = Carbon::parse($this->jam_selesai);
                if ($end > $start) {
                    $this->durasi_menit = $start->diffInMinutes($end);
                }
            }
        }
    }

    public function loadData()
    {
        // 1. Generate Struktur Kalender
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1);
        $daysInMonth = $date->daysInMonth;
        $startDayOfWeek = $date->dayOfWeek; 
        
        $this->daysInMonth = [];
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $this->daysInMonth[] = null;
        }
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $this->daysInMonth[] = $i;
        }

        // 2. Ambil Data
        $userId = Auth::id();

        $this->attendanceData = Presensi::where('user_id', $userId)
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->keyBy(function($item) {
                return Carbon::parse($item->tanggal)->day;
            });

        $this->lkhData = LaporanKinerjaHarian::where('user_id', $userId)
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->tanggal)->day;
            });

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
            for ($date = $start; $date->lte($end); $date->addDay()) {
                if ($date->month == $this->bulan && $date->year == $this->tahun) {
                    $this->cutiData[$date->day] = $cuti;
                }
            }
        }

        // 3. Stats
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
        $this->selectedPresensi = $this->attendanceData[$day] ?? null;
        
        // Refresh LKH List for selected day
        $this->selectedLkhList = LaporanKinerjaHarian::where('user_id', Auth::id())
            ->whereDate('tanggal', $this->selectedDate)
            ->orderBy('jam_mulai')
            ->get();
        
        $this->calculateDailyStats();
        $this->resetForm();
    }

    public function calculateDailyStats()
    {
        $this->totalDurasiHariIni = $this->selectedLkhList->sum('durasi_menit');
    }

    public function resetForm()
    {
        $this->aktivitas = '';
        $this->kategori_kegiatan = 'Tugas Utama';
        $this->deskripsi = '';
        // Auto set next time slot based on last activity
        $lastActivity = $this->selectedLkhList->last();
        if ($lastActivity) {
            $this->jam_mulai = Carbon::parse($lastActivity->jam_selesai)->format('H:i');
            $this->jam_selesai = Carbon::parse($lastActivity->jam_selesai)->addHour()->format('H:i');
        } else {
            $this->jam_mulai = '08:00';
            $this->jam_selesai = '09:00';
        }
        
        $this->durasi_menit = 60;
        $this->persentase_selesai = 100;
        $this->prioritas = 'Normal';
        $this->kendala_teknis = '';
        $this->tautan_dokumen = '';
        $this->file_bukti_kerja = null;
    }

    public function saveLKH()
    {
        if ($this->isCuti) return;

        $this->validate();

        $path = null;
        if ($this->file_bukti_kerja) {
            $path = $this->file_bukti_kerja->store('bukti-kerja', 'public');
        }

        LaporanKinerjaHarian::create([
            'user_id' => Auth::id(),
            'tanggal' => $this->selectedDate,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'durasi_menit' => $this->durasi_menit,
            'aktivitas' => $this->aktivitas,
            'kategori_kegiatan' => $this->kategori_kegiatan,
            'deskripsi' => $this->deskripsi,
            'persentase_selesai' => $this->persentase_selesai,
            'prioritas' => $this->prioritas,
            'kendala_teknis' => $this->kendala_teknis,
            'tautan_dokumen' => $this->tautan_dokumen,
            'file_bukti_kerja' => $path,
            'status' => 'Pending'
        ]);

        $this->dispatch('notify', 'success', 'Aktivitas berhasil dicatat.');
        $this->loadData(); // Refresh calendar counts
        
        // Refresh local list without reload
        $this->selectedLkhList = LaporanKinerjaHarian::where('user_id', Auth::id())
            ->whereDate('tanggal', $this->selectedDate)
            ->orderBy('jam_mulai')
            ->get();
            
        $this->calculateDailyStats();
        $this->resetForm();
    }

    public function deleteLKH($id)
    {
        LaporanKinerjaHarian::where('user_id', Auth::id())->find($id)->delete();
        $this->dispatch('notify', 'success', 'Laporan dihapus.');
        
        $this->loadData(); 
        $this->selectedLkhList = LaporanKinerjaHarian::where('user_id', Auth::id())
            ->whereDate('tanggal', $this->selectedDate)
            ->orderBy('jam_mulai')
            ->get();
            
        $this->calculateDailyStats();
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1)->subMonth();
        $this->bulan = $date->month;
        $this->tahun = $date->year;
        $this->loadData();
        $this->selectedDate = null;
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1)->addMonth();
        $this->bulan = $date->month;
        $this->tahun = $date->year;
        $this->loadData();
        $this->selectedDate = null;
    }

    public function render()
    {
        return view('livewire.kepegawaian.presensi.history')
            ->layout('layouts.app', ['header' => 'Kalender Kehadiran & Aktivitas']);
    }
}