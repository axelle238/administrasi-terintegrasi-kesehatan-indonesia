<?php

namespace App\Livewire\Hrd\Presensi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Presensi;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $tanggal;
    public $filterStatus = '';

    public function mount()
    {
        $this->tanggal = Carbon::today()->format('Y-m-d');
    }

    public function render()
    {
        $presensis = Presensi::with(['user.pegawai'])
            ->whereDate('tanggal', $this->tanggal)
            ->when($this->filterStatus, function($q) {
                $q->where('status_kehadiran', $this->filterStatus);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'Hadir' => Presensi::whereDate('tanggal', $this->tanggal)->where('status_kehadiran', 'Hadir')->count(),
            'Terlambat' => Presensi::whereDate('tanggal', $this->tanggal)->where('status_kehadiran', 'Terlambat')->count(),
            'Dinas' => Presensi::whereDate('tanggal', $this->tanggal)->where('status_kehadiran', 'like', '%Dinas%')->count(),
        ];

        return view('livewire.hrd.presensi.index', [
            'presensis' => $presensis,
            'stats' => $stats
        ])->layout('layouts.app', ['header' => 'Monitoring Presensi Harian']);
    }
}
