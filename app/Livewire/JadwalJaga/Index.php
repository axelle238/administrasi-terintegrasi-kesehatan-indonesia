<?php

namespace App\Livewire\JadwalJaga;

use App\Models\JadwalJaga;
use App\Models\Pegawai;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $dateFilter;
    public $pegawaiFilter;

    public function mount()
    {
        $this->dateFilter = now()->format('Y-m-d');
    }

    public function delete($id)
    {
        $jadwal = JadwalJaga::find($id);
        if ($jadwal) {
            $jadwal->delete();
            $this->dispatch('notify', 'success', 'Jadwal berhasil dihapus.');
        }
    }

    public function render()
    {
        $jadwals = JadwalJaga::with(['pegawai.user', 'shift'])
            ->when($this->dateFilter, function($query) {
                $query->whereDate('tanggal', $this->dateFilter);
            })
            ->when($this->pegawaiFilter, function($query) {
                $query->where('pegawai_id', $this->pegawaiFilter);
            })
            ->latest('tanggal')
            ->paginate(10);

        return view('livewire.jadwal-jaga.index', [
            'jadwals' => $jadwals,
            'pegawais' => Pegawai::with('user')->get(),
        ])->layout('layouts.app', ['header' => 'Jadwal Jaga Pegawai']);
    }
}