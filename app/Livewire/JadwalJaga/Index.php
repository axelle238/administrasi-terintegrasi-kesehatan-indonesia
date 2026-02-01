<?php

namespace App\Livewire\JadwalJaga;

use Livewire\Component;
use App\Models\Pegawai;
use App\Models\Shift;
use App\Models\Poli;
use App\Models\JadwalJaga;
use Carbon\Carbon;

class Index extends Component
{
    public $bulan, $tahun;
    public $filterPoli = '';
    
    // Editor State
    public $isEditorOpen = false;
    public $selectedDate;
    public $selectedPegawai; // Object Pegawai
    public $selectedJadwal; // Object JadwalJaga (if exists)
    
    // Form Input
    public $shift_id, $status_kehadiran = 'Hadir', $kuota_online = 20, $kuota_offline = 30, $catatan;

    public function mount()
    {
        $this->bulan = Carbon::now()->month;
        $this->tahun = Carbon::now()->year;
    }

    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1)->subMonth();
        $this->bulan = $date->month;
        $this->tahun = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->tahun, $this->bulan, 1)->addMonth();
        $this->bulan = $date->month;
        $this->tahun = $date->year;
    }

    // === ADVANCED FEATURES ===
    public function copyLastMonth()
    {
        // 1. Cek apakah bulan ini sudah ada jadwal? (Safety check)
        $countThisMonth = JadwalJaga::whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->count();
        if ($countThisMonth > 0) {
            $this->dispatch('notify', 'error', 'Jadwal bulan ini sudah terisi. Hapus dulu jika ingin menyalin.');
            return;
        }

        // 2. Ambil data bulan lalu
        $lastMonthDate = Carbon::createFromDate($this->tahun, $this->bulan, 1)->subMonth();
        $lastMonthSchedules = JadwalJaga::whereMonth('tanggal', $lastMonthDate->month)
            ->whereYear('tanggal', $lastMonthDate->year)
            ->get();

        if ($lastMonthSchedules->isEmpty()) {
            $this->dispatch('notify', 'warning', 'Tidak ada jadwal di bulan sebelumnya untuk disalin.');
            return;
        }

        // 3. Salin Pattern (Logic: Tanggal 1 ke Tanggal 1, dst. Jika tanggal tidak valid di bulan ini, skip)
        $newSchedules = [];
        $now = Carbon::now();
        
        foreach ($lastMonthSchedules as $old) {
            $day = $old->tanggal->day;
            
            // Cek validitas tanggal di bulan ini (misal: tgl 31 di Februari)
            if (!checkdate($this->bulan, $day, $this->tahun)) continue;

            $newDate = Carbon::createFromDate($this->tahun, $this->bulan, $day);

            $newSchedules[] = [
                'pegawai_id' => $old->pegawai_id,
                'shift_id' => $old->shift_id,
                'tanggal' => $newDate->format('Y-m-d'),
                'status_kehadiran' => $old->status_kehadiran, // Reset ke Hadir jika mau, tapi kita copy status juga gapapa
                'kuota_online' => $old->kuota_online,
                'kuota_offline' => $old->kuota_offline,
                'catatan' => 'Salinan otomatis',
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        if (count($newSchedules) > 0) {
            JadwalJaga::insert($newSchedules);
            $this->dispatch('notify', 'success', count($newSchedules) . ' jadwal berhasil disalin dari bulan lalu.');
        }
    }

    public function clearMonth()
    {
        JadwalJaga::whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->delete();
            
        $this->dispatch('notify', 'success', 'Semua jadwal bulan ini telah dihapus.');
    }

    public function editCell($pegawaiId, $dateStr)
    {
        $this->selectedDate = $dateStr;
        $this->selectedPegawai = Pegawai::with('user', 'poli')->find($pegawaiId);
        
        $jadwal = JadwalJaga::where('pegawai_id', $pegawaiId)->where('tanggal', $dateStr)->first();
        $this->selectedJadwal = $jadwal;

        // Populate Form
        if ($jadwal) {
            $this->shift_id = $jadwal->shift_id;
            $this->status_kehadiran = $jadwal->status_kehadiran;
            $this->kuota_online = $jadwal->kuota_online;
            $this->kuota_offline = $jadwal->kuota_offline;
            $this->catatan = $jadwal->catatan;
        } else {
            $this->resetForm();
        }

        $this->isEditorOpen = true;
    }

    public function save()
    {
        if (!$this->shift_id && $this->status_kehadiran == 'Hadir') {
            $this->addError('shift_id', 'Pilih shift jaga.');
            return;
        }

        JadwalJaga::updateOrCreate(
            ['pegawai_id' => $this->selectedPegawai->id, 'tanggal' => $this->selectedDate],
            [
                'shift_id' => $this->shift_id,
                'status_kehadiran' => $this->status_kehadiran,
                'kuota_online' => $this->kuota_online,
                'kuota_offline' => $this->kuota_offline,
                'catatan' => $this->catatan
            ]
        );

        $this->isEditorOpen = false;
        $this->dispatch('notify', 'success', 'Jadwal berhasil disimpan.');
    }

    public function delete()
    {
        if ($this->selectedJadwal) {
            $this->selectedJadwal->delete();
            $this->isEditorOpen = false;
            $this->dispatch('notify', 'success', 'Jadwal dihapus (Libur).');
        }
    }

    public function closeEditor()
    {
        $this->isEditorOpen = false;
    }

    private function resetForm()
    {
        $this->shift_id = null;
        $this->status_kehadiran = 'Hadir';
        $this->kuota_online = 20;
        $this->kuota_offline = 30;
        $this->catatan = '';
    }

    public function render()
    {
        $daysInMonth = Carbon::createFromDate($this->tahun, $this->bulan)->daysInMonth;
        
        $pegawais = Pegawai::with(['user', 'poli'])
            ->when($this->filterPoli, function($q) {
                $q->where('poli_id', $this->filterPoli);
            })
            ->whereHas('user', function($q) {
                $q->whereIn('role', ['dokter', 'perawat', 'bidan']); // Hanya tenaga medis
            })
            ->orderBy('poli_id')
            ->get();

        $jadwals = JadwalJaga::with('shift')
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->whereIn('pegawai_id', $pegawais->pluck('id'))
            ->get()
            ->groupBy(function($item) {
                return $item->pegawai_id . '-' . $item->tanggal->format('Y-m-d');
            });

        return view('livewire.jadwal-jaga.index', [
            'daysInMonth' => $daysInMonth,
            'pegawais' => $pegawais,
            'jadwalMap' => $jadwals,
            'shifts' => Shift::all(),
            'polis' => Poli::all(),
            'currentDate' => Carbon::createFromDate($this->tahun, $this->bulan, 1)
        ])->layout('layouts.app', ['header' => 'Roster Jadwal Dinas']);
    }
}
