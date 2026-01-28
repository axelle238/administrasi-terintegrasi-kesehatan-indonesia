<?php

namespace App\Livewire\Security;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Aktivitas Hari Ini
        $logsToday = Activity::whereDate('created_at', Carbon::today())->count();
        $logsWeek = Activity::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        // 2. Login Failed (Mock logic if not tracked yet, or filter 'login_failed' event)
        // Asumsi event 'login_failed' dicatat
        $loginFailedToday = Activity::whereDate('created_at', Carbon::today())
            ->where('event', 'login_failed')
            ->count();

        // 3. User Baru Bulan Ini
        $newUsersMonth = User::whereMonth('created_at', Carbon::now()->month)->count();

        // 4. Aktivitas per User (Top 5 Active Users)
        $topActiveUsers = Activity::select('causer_id', DB::raw('count(*) as total'))
            ->whereNotNull('causer_id')
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('causer_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('causer')
            ->get();

        // 5. Recent Critical Activities (Deleted / Updated)
        $recentCritical = Activity::whereIn('event', ['deleted', 'updated'])
            ->with('causer')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.security.dashboard', compact(
            'logsToday',
            'logsWeek',
            'loginFailedToday',
            'newUsersMonth',
            'topActiveUsers',
            'recentCritical'
        ))->layout('layouts.app', ['header' => 'Dashboard Keamanan Sistem']);
    }
}
