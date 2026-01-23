<?php

namespace App\Livewire\JadwalJaga;

use App\Models\JadwalJaga;
use App\Models\Pegawai;
use App\Models\Shift;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class Create extends Component
{
    public $pegawai_id;
    public $shift_id;
    public $tanggal;
    public $status_kehadiran = 'Belum Hadir';

    protected $rules = [
        'pegawai_id' => 'required|exists:pegawais,id',
        'shift_id' => 'required|exists:shifts,id',
        'tanggal' => 'required|date|after_or_equal:today',
        'status_kehadiran' => 'required|in:Hadir,Izin,Sakit,Alpha,Belum Hadir',
    ];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        $targetShift = Shift::find($this->shift_id);

        // Advanced Validation: Check for overlapping shifts
        // Get all schedules for this employee on the same day
        $existingSchedules = JadwalJaga::where('pegawai_id', $this->pegawai_id)
            ->where('tanggal', $this->tanggal)
            ->with('shift')
            ->get();

        foreach ($existingSchedules as $existing) {
            $existingShift = $existing->shift;
            
            // Logic: If (StartA < EndB) and (EndA > StartB) then Overlap
            // We assume shifts are within 24h for simplicity, or handle crossover if needed.
            // Puskesmas usually 3 shifts: Pagi, Siang, Malam.
            // If user has Pagi, they shouldn't have Siang usually, or at least warn.
            // For now, strict rule: 1 shift per day per person is standard, but if overtime allowed, we check times.
            
            // Let's stick to 1 shift per day per person for safety/health compliance (Permenkes limit on work hours)
            // Unless it's a specific 'Lembur' shift.
            
            throw ValidationException::withMessages([
                'pegawai_id' => "Pegawai ini sudah memiliki jadwal shift {$existingShift->nama_shift} pada tanggal {$this->tanggal}."
            ]);
        }

        // Compliance Check: Ensure Staffing Levels (Optional but good)
        // e.g., ensure not too many people on one shift? No, that's planning. 
        
        JadwalJaga::create([
            'pegawai_id' => $this->pegawai_id,
            'shift_id' => $this->shift_id,
            'tanggal' => $this->tanggal,
            'status_kehadiran' => $this->status_kehadiran,
        ]);

        $this->dispatch('notify', 'success', 'Jadwal berhasil dibuat.');
        return $this->redirect(route('jadwal-jaga.index'), navigate: true);
    }

    public function render()
    {
        // Sort pegawais alphabetically
        $pegawais = Pegawai::with('user')
            ->get()
            ->sortBy('user.name');

        return view('livewire.jadwal-jaga.create', [
            'pegawais' => $pegawais,
            'shifts' => Shift::all(),
        ])->layout('layouts.app', ['header' => 'Buat Jadwal Jaga']);
    }
}
