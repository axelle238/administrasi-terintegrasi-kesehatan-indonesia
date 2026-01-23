<?php

namespace App\Livewire\Laporan;

use App\Models\RekamMedis;
use App\Models\Pembayaran;
use App\Models\Obat;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $tab = 'kunjungan'; // kunjungan, keuangan, obat, penyakit
    
    // Filter
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $data = [];

        if ($this->tab == 'kunjungan') {
            $data = RekamMedis::with(['pasien', 'dokter', 'tindakans']) 
                ->whereBetween('tanggal_periksa', [$this->startDate, $this->endDate . ' 23:59:59'])
                ->latest()
                ->get();
        } 
        elseif ($this->tab == 'keuangan') {
            $data = Pembayaran::with(['rekamMedis.pasien'])
                ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
                ->where('status', 'Lunas') // Fixed column name from status_pembayaran to status
                ->latest()
                ->get();
        }
        elseif ($this->tab == 'obat') {
            // Laporan Stok Opname
            $data = Obat::orderBy('stok', 'asc')->get();
        }
        elseif ($this->tab == 'penyakit') {
            // Laporan 10 Besar Penyakit
            $data = RekamMedis::select('diagnosa', DB::raw('count(*) as total'))
                ->whereBetween('tanggal_periksa', [$this->startDate, $this->endDate . ' 23:59:59'])
                ->whereNotNull('diagnosa')
                ->groupBy('diagnosa')
                ->orderByDesc('total')
                ->take(10)
                ->get();
        }

        return view('livewire.laporan.index', [
            'data' => $data
        ])->layout('layouts.app', ['header' => 'Laporan & Statistik']);
    }
}
