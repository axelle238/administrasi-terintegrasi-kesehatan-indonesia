<?php

namespace App\Livewire\Security;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use App\Models\RiwayatLogin;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class Dashboard extends Component
{
    use WithPagination;

    // State Management
    public $activeTab = 'overview'; // overview, threats, sessions, logs
    public $newBlockedIp = '';
    
    // Filter Log
    public $logSearch = '';
    public $logLevel = 'all';

    // Lockdown State
    public $isLockdown = false;

    public function mount()
    {
        $this->isLockdown = Setting::ambil('security_lockdown_mode', '0') == '1';
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // --- Actions: Lockdown ---
    public function toggleLockdown()
    {
        $this->isLockdown = !$this->isLockdown;
        Setting::simpan('security_lockdown_mode', $this->isLockdown ? '1' : '0', 'boolean', 'Mode Darurat Sistem');
        
        $msg = $this->isLockdown 
            ? 'MODE LOCKDOWN DIAKTIFKAN! Hanya admin yang dapat login.' 
            : 'Mode Lockdown dinonaktifkan. Akses kembali normal.';
            
        $this->dispatch('notify', 'warning', $msg);
        
        // Log Critical Action
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengubah status Security Lockdown menjadi: ' . ($this->isLockdown ? 'AKTIF' : 'NON-AKTIF'));
    }

    // --- Actions: IP Blocking ---
    public function addBlockedIp()
    {
        $this->validate([
            'newBlockedIp' => 'required|ip|unique:settings,value' // Simplifikasi, aslinya perlu tabel khusus
        ]);

        // Karena belum ada tabel BlockedIP khusus, kita simpan di Setting sebagai JSON array
        // Mengambil daftar existing
        $blockedIps = json_decode(Setting::ambil('security_blocked_ips', '[]'), true);
        
        if (!in_array($this->newBlockedIp, $blockedIps)) {
            $blockedIps[] = $this->newBlockedIp;
            Setting::simpan('security_blocked_ips', json_encode($blockedIps), 'json', 'Daftar IP Terblokir');
            
            activity()->log("Memblokir IP: {$this->newBlockedIp}");
            $this->dispatch('notify', 'success', "IP {$this->newBlockedIp} berhasil dimasukkan ke daftar blokir.");
        }

        $this->newBlockedIp = '';
    }

    public function removeBlockedIp($ip)
    {
        $blockedIps = json_decode(Setting::ambil('security_blocked_ips', '[]'), true);
        
        if (($key = array_search($ip, $blockedIps)) !== false) {
            unset($blockedIps[$key]);
            Setting::simpan('security_blocked_ips', json_encode(array_values($blockedIps)), 'json', 'Daftar IP Terblokir');
            
            activity()->log("Membuka blokir IP: {$ip}");
            $this->dispatch('notify', 'success', "Blokir IP {$ip} dihapus.");
        }
    }

    // --- Actions: Session Management ---
    public function killUserSession($userId)
    {
        // Simulasi Kill Session (Idealnya menggunakan DB Session driver)
        // Di sini kita update 'remember_token' user untuk invalidasi sesi "remember me"
        // Dan bisa set flag 'force_logout' di user table jika ada fieldnya.
        
        $user = User::find($userId);
        if ($user) {
            $user->remember_token = null;
            $user->save();
            
            // Log activity
            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->log("Memutuskan paksa sesi pengguna: {$user->name}");
                
            $this->dispatch('notify', 'success', "Sesi pengguna {$user->name} telah direset (Logout paksa).");
        }
    }

    public function render()
    {
        // Data Overview
        $stats = [
            'logs_today' => Activity::whereDate('created_at', Carbon::today())->count(),
            'failed_logins' => RiwayatLogin::whereDate('created_at', Carbon::today())->where('status', 'Gagal')->count(),
            'active_users' => User::count(), // Simulasi active users
            'blocked_ips_count' => count(json_decode(Setting::ambil('security_blocked_ips', '[]'), true)),
        ];

        // Data Grafik
        $trenAncaman = $this->getTrenAncaman();

        // Data Tab: Threats
        $blockedIps = json_decode(Setting::ambil('security_blocked_ips', '[]'), true);

        // Data Tab: Sessions (Active Users Simulation - last login < 24h)
        $activeSessions = User::whereHas('riwayatLogins', function($q) {
                $q->where('created_at', '>=', Carbon::now()->subDay());
            })
            ->with(['riwayatLogins' => function($q) {
                $q->latest()->limit(1);
            }])
            ->limit(10)
            ->get();

        // Data Tab: Logs
        $logs = Activity::with('causer')
            ->when($this->logSearch, function($q) {
                $q->where('description', 'like', '%'.$this->logSearch.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.security.dashboard', compact(
            'stats',
            'trenAncaman',
            'blockedIps',
            'activeSessions',
            'logs'
        ))->layout('layouts.app', ['header' => 'Pusat Komando Keamanan Siber']);
    }

    private function getTrenAncaman()
    {
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d/m');
            // Randomize data jika kosong untuk visualisasi prototype, 
            // aslinya pakai RiwayatLogin where status=Gagal
            $count = RiwayatLogin::whereDate('created_at', $date)->where('status', 'Gagal')->count();
            // Fallback mock data jika DB kosong agar grafik terlihat
            if ($count == 0 && app()->environment('local')) $count = rand(0, 5); 
            $data[] = $count;
        }
        return ['labels' => $labels, 'data' => $data];
    }
}