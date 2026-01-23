<?php

namespace App\Livewire\Components;

use App\Models\RekamMedis;
use Carbon\Carbon;
use Livewire\Component;

/**
 * Komponen Chart Dashboard
 * 
 * Menampilkan statistik kunjungan pasien 7 hari terakhir.
 * Di-load secara Lazy agar halaman Dashboard utama terbuka instan.
 */
class DashboardChart extends Component
{
    public function placeholder()
    {
        return <<<'HTML'
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100 h-64 flex items-center justify-center">
            <div class="animate-pulse flex flex-col items-center">
                <div class="h-4 w-32 bg-gray-200 rounded mb-4"></div>
                <div class="h-32 w-full bg-gray-100 rounded"></div>
            </div>
        </div>
        HTML;
    }

    public function render()
    {
        // Chart Data: Visits Last 7 Days
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = RekamMedis::whereDate('tanggal_periksa', $date)->count();
            $chartData[] = [
                'day' => $date->isoFormat('dddd'),
                'date' => $date->format('d/m'),
                'count' => $count
            ];
        }
        
        $counts = array_column($chartData, 'count');
        $maxCount = !empty($counts) ? (max($counts) ?: 1) : 1;

        return view('livewire.components.dashboard-chart', [
            'chartData' => $chartData,
            'maxCount' => $maxCount
        ]);
    }
}