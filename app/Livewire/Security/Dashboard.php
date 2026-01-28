<?php

namespace App\Livewire\Security;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use App\Models\RiwayatLogin;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Aktivitas & Ancaman
        $logsToday = Activity::whereDate('created_at', Carbon::today())->count();
        $logsWeek = Activity::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        // 2. Login Tracking
        $loginSuccessToday = RiwayatLogin::whereDate('created_at', Carbon::today())->where('status', 'Berhasil')->count();
        $loginFailedToday = RiwayatLogin::whereDate('created_at', Carbon::today())->where('status', 'Gagal')->count();

        // 3. User Baru Bulan Ini
        $newUsersMonth = User::whereMonth('created_at', Carbon::now()->month)->count();

        // 4. Analitik Aktivitas per User (Top 5 Active Users)
        $topActiveUsers = Activity::select('causer_id', DB::raw('count(*) as total'))
            ->whereNotNull('causer_id')
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('causer_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('causer')
            ->get();

        // 5. Recent Critical Activities (Deleted / Updated sensitive tables)
        $recentCritical = Activity::whereIn('event', ['deleted', 'updated'])
            ->with('causer')
            ->latest()
            ->take(8)
            ->get();

        // 6. Cyber Security Status (Simulasi/Metrics)
        $securityStatus = [
            'firewall' => 'Aktif',
            'ssl_expiry' => '245 Hari lagi',
            'last_backup' => Carbon::now()->subHours(2)->diffForHumans(),
            'encryption' => 'AES-256-CBC',
            'threat_level' => $loginFailedToday > 10 ? 'Tinggi' : 'Rendah',
        ];

        // 7. Grafik Tren Ancaman (Login Gagal 7 Hari)
        $trenAncaman = $this->getTrenAncaman();

        return view('livewire.security.dashboard', compact(
            'logsToday',
            'logsWeek',
            'loginSuccessToday',
            'loginFailedToday',
            'newUsersMonth',
            'topActiveUsers',
            'recentCritical',
            'securityStatus',
            'trenAncaman'
        ))->layout('layouts.app', ['header' => 'Pusat Keamanan Siber & Sistem']);
    }

    private function getTrenAncaman()
    {
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = RiwayatLogin::whereDate('created_at', $date)->where('status', 'Gagal')->count();
        }
        return ['labels' => $labels, 'data' => $data];
    }
}
