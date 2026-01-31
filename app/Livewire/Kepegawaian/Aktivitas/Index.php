<?php

namespace App\Livewire\Kepegawaian\Aktivitas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LaporanHarian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $bulanFilter;
    public $tahunFilter;

    public function mount()
    {
        $this->bulanFilter = Carbon::now()->month;
        $this->tahunFilter = Carbon::now()->year;
    }

    public function render()
    {
        $laporan = LaporanHarian::where('user_id', Auth::id())
            ->whereMonth('tanggal', $this->bulanFilter)
            ->whereYear('tanggal', $this->tahunFilter)
            ->withCount('details')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('livewire.kepegawaian.aktivitas.index', [
            'laporan' => $laporan
        ])->layout('layouts.app', ['header' => 'Laporan Aktivitas Harian (LKH)']);
    }
}