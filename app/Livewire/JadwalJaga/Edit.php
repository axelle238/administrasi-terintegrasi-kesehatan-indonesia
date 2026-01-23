<?php

namespace App\Livewire\JadwalJaga;

use App\Models\JadwalJaga;
use App\Models\Pegawai;
use App\Models\Shift;
use Livewire\Component;

class Edit extends Component
{
    public JadwalJaga $jadwalJaga;
    public $pegawai_id;
    public $shift_id;
    public $tanggal;
    public $status_kehadiran;

    protected $rules = [
        'pegawai_id' => 'required|exists:pegawais,id',
        'shift_id' => 'required|exists:shifts,id',
        'tanggal' => 'required|date',
        'status_kehadiran' => 'required|in:Hadir,Izin,Sakit,Alpha,Belum Hadir',
    ];

    public function mount(JadwalJaga $jadwalJaga)
    {
        $this->jadwalJaga = $jadwalJaga;
        $this->pegawai_id = $jadwalJaga->pegawai_id;
        $this->shift_id = $jadwalJaga->shift_id;
        $this->tanggal = $jadwalJaga->tanggal;
        $this->status_kehadiran = $jadwalJaga->status_kehadiran;
    }

    public function update()
    {
        $this->validate();

        // Check duplicate if changing date/pegawai
         if ($this->pegawai_id != $this->jadwalJaga->pegawai_id || $this->tanggal != $this->jadwalJaga->tanggal) {
             $exists = JadwalJaga::where('pegawai_id', $this->pegawai_id)
                    ->where('tanggal', $this->tanggal)
                    ->where('id', '!=', $this->jadwalJaga->id)
                    ->exists();
            if ($exists) {
                $this->addError('pegawai_id', 'Pegawai ini sudah memiliki jadwal pada tanggal tersebut.');
                return;
            }
         }

        $this->jadwalJaga->update([
            'pegawai_id' => $this->pegawai_id,
            'shift_id' => $this->shift_id,
            'tanggal' => $this->tanggal,
            'status_kehadiran' => $this->status_kehadiran,
        ]);

        $this->dispatch('notify', 'success', 'Jadwal berhasil diperbarui.');
        return $this->redirect(route('jadwal-jaga.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.jadwal-jaga.edit', [
            'pegawais' => Pegawai::with('user')->get(),
            'shifts' => Shift::all(),
        ])->layout('layouts.app', ['header' => 'Edit Jadwal Jaga']);
    }
}