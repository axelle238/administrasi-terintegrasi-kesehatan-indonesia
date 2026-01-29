<?php

namespace App\Livewire\JadwalJaga;

use App\Models\JadwalJaga;
use App\Models\Pegawai;
use App\Models\Shift;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

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
        // Stats
        $totalJadwalHariIni = JadwalJaga::whereDate('tanggal', $this->dateFilter)->count();
        
        $statsShift = JadwalJaga::whereDate('tanggal', $this->dateFilter)
            ->select('shift_id', DB::raw('count(*) as total'))
            ->groupBy('shift_id')
            ->with('shift')
            ->get();

        // Data Table
        $jadwals = JadwalJaga::with(['pegawai.user', 'shift', 'ruangan'])
            ->when($this->dateFilter, function($query) {
                $query->whereDate('tanggal', $this->dateFilter);
            })
            ->when($this->pegawaiFilter, function($query) {
                $query->where('pegawai_id', $this->pegawaiFilter);
            })
            ->orderBy('shift_id') // Group by shift visually
            ->paginate(15);

        return view('livewire.jadwal-jaga.index', compact(
            'jadwals', 
            'totalJadwalHariIni', 
            'statsShift'
        ))->with('pegawais', Pegawai::with('user')->get())
          ->layout('layouts.app', ['header' => 'Manajemen Jadwal Jaga']);
    }
}
