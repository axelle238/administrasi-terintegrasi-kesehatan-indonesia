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

        // 6. Cyber Security Status (Realtime Config)
        $securityStatus = [
            'firewall' => \App\Models\Setting::ambil('ip_whitelist') ? 'Restricted (IP)' : 'Standard',
            'ssl_expiry' => \App\Models\Setting::ambil('force_https') == '1' ? 'Enforced' : 'Optional',
            'last_backup' => \App\Models\Setting::ambil('enable_auto_backup') == '1' ? 'Auto-Active' : 'Manual',
            'encryption' => 'AES-256-CBC',
            'threat_level' => $loginFailedToday > 10 ? 'Tinggi' : ($loginFailedToday > 3 ? 'Sedang' : 'Rendah'),
            'recaptcha' => \App\Models\Setting::ambil('recaptcha_active') == '1' ? 'Aktif' : 'Non-Aktif',
        ];

        // 7. Grafik Tren Ancaman (Login Gagal 7 Hari)
        $trenAncaman = $this->getTrenAncaman();

        // 8. Geo Distribusi Akses (Simulasi Threat Intelligence)
        $geoDistribution = [
            ['negara' => 'Indonesia', 'total' => $loginSuccessToday + 45, 'status' => 'Aman'],
            ['negara' => 'Amerika Serikat', 'total' => 12, 'status' => 'Waspada'],
            ['negara' => 'Tiongkok', 'total' => 8, 'status' => 'Blokir'],
            ['negara' => 'Rusia', 'total' => 5, 'status' => 'Blokir'],
            ['negara' => 'Lainnya', 'total' => 3, 'status' => 'Waspada'],
        ];

        // 9. Kesehatan Server Infrastruktur (Simulasi Monitoring)
        $serverHealth = [
            'cpu_load' => rand(15, 45), // Persentase
            'ram_usage' => rand(40, 70), // Persentase
            'disk_space' => 68, // Persentase terpakai
            'uptime' => '14 Hari 3 Jam'
        ];

        return view('livewire.security.dashboard', compact(
            'logsToday',
            'logsWeek',
            'loginSuccessToday',
            'loginFailedToday',
            'newUsersMonth',
            'topActiveUsers',
            'recentCritical',
            'securityStatus',
            'trenAncaman',
            'geoDistribution',
            'serverHealth'
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
