<?php

namespace App\Livewire\JadwalJaga;

use Livewire\Component;
use App\Models\Pegawai;
use App\Models\Shift;
use App\Models\JadwalJaga;
use Carbon\Carbon;

class Index extends Component
{
    public $bulan, $tahun;
    public $pegawais;
    public $shifts;
    
    // Modal State
    public $isOpen = false;
    public $selectedDate, $selectedPegawaiId;
    public $inputShiftId;

    public function mount()
    {
        $this->bulan = Carbon::now()->month;
        $this->tahun = Carbon::now()->year;
        $this->pegawais = Pegawai::with('user')->get();
        $this->shifts = Shift::all();
    }

    public function openModal($date, $pegawaiId)
    {
        $this->selectedDate = $date;
        $this->selectedPegawaiId = $pegawaiId;
        
        // Cek existing
        $existing = JadwalJaga::where('pegawai_id', $pegawaiId)
            ->where('tanggal', $date)
            ->first();
            
        $this->inputShiftId = $existing ? $existing->shift_id : null;
        $this->isOpen = true;
    }

    public function saveJadwal()
    {
        if ($this->inputShiftId) {
            JadwalJaga::updateOrCreate(
                ['pegawai_id' => $this->selectedPegawaiId, 'tanggal' => $this->selectedDate],
                ['shift_id' => $this->inputShiftId]
            );
        } else {
            // Jika kosong, hapus jadwal (Libur)
            JadwalJaga::where('pegawai_id', $this->selectedPegawaiId)
                ->where('tanggal', $this->selectedDate)
                ->delete();
        }
        
        $this->isOpen = false;
        $this->dispatch('notify', 'success', 'Jadwal diperbarui.');
    }

    public function render()
    {
        $daysInMonth = Carbon::createFromDate($this->tahun, $this->bulan)->daysInMonth;
        
        // Eager load jadwal untuk bulan ini
        $jadwals = JadwalJaga::whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get()
            ->groupBy(function($item) {
                return $item->pegawai_id . '-' . $item->tanggal->format('Y-m-d');
            });

        return view('livewire.jadwal-jaga.index', [
            'daysInMonth' => $daysInMonth,
            'jadwalMap' => $jadwals
        ])->layout('layouts.app', ['header' => 'Ploting Jadwal Dinas']);
    }
}