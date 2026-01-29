<div class="space-y-6">
    
    <!-- Top Bar: Status & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                Status Keamanan Sistem
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Pantau ancaman, kelola akses, dan audit aktivitas pengguna secara real-time.
            </p>
        </div>

        <div class="flex items-center gap-4">
            <!-- Lockdown Toggle -->
            <div class="flex items-center gap-3 px-4 py-2 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                <span class="text-xs font-bold uppercase tracking-wider {{ $isLockdown ? 'text-red-600' : 'text-gray-500' }}">
                    {{ $isLockdown ? 'LOCKDOWN AKTIF' : 'NORMAL MODE' }}
                </span>
                <button wire:click="toggleLockdown" wire:confirm="Apakah Anda yakin ingin mengubah status Lockdown? Jika Aktif, hanya Admin yang bisa login." 
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 {{ $isLockdown ? 'bg-red-600' : 'bg-gray-200' }}">
                    <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $isLockdown ? 'translate-x-5' : 'translate-x-0' }}"></span>
                </button>
            </div>
            
            <button wire:click="$refresh" class="p-2 text-gray-400 hover:text-indigo-600 transition-colors" title="Refresh Data">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            </button>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button wire:click="setTab('overview')" 
                class="{{ $activeTab === 'overview' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                Ringkasan & Analitik
            </button>
            <button wire:click="setTab('threats')" 
                class="{{ $activeTab === 'threats' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                Ancaman & Blokir IP
            </button>
            <button wire:click="setTab('sessions')" 
                class="{{ $activeTab === 'sessions' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                Sesi Pengguna Aktif
            </button>
            <button wire:click="setTab('logs')" 
                class="{{ $activeTab === 'logs' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                Audit Log Lengkap
            </button>
        </nav>
    </div>

    <!-- Content Area -->
    <div class="min-h-[400px]">
        
        <!-- TAB 1: OVERVIEW -->
        @if($activeTab === 'overview')
            <div class="space-y-6 animate-fade-in-up">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <p class="text-xs font-bold text-gray-400 uppercase">Aktivitas Hari Ini</p>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-2">{{ $stats['logs_today'] }}</h3>
                        <div class="mt-2 text-xs text-green-600 font-bold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                            Data Masuk
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <p class="text-xs font-bold text-gray-400 uppercase">Login Gagal</p>
                        <h3 class="text-3xl font-black text-red-600 mt-2">{{ $stats['failed_logins'] }}</h3>
                        <div class="mt-2 text-xs text-red-500 font-bold">Percobaan mencurigakan</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <p class="text-xs font-bold text-gray-400 uppercase">User Terdaftar</p>
                        <h3 class="text-3xl font-black text-indigo-600 mt-2">{{ $stats['active_users'] }}</h3>
                        <div class="mt-2 text-xs text-indigo-500 font-bold">Akun dalam sistem</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <p class="text-xs font-bold text-gray-400 uppercase">IP Terblokir</p>
                        <h3 class="text-3xl font-black text-slate-700 dark:text-slate-300 mt-2">{{ $stats['blocked_ips_count'] }}</h3>
                        <div class="mt-2 text-xs text-slate-500 font-bold">Blacklist aktif</div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Tren Ancaman (7 Hari Terakhir)</h3>
                    <div class="h-64 flex items-end justify-between gap-4 px-4">
                        @foreach($trenAncaman['data'] as $index => $val)
                            <div class="flex flex-col items-center flex-1 group">
                                <div class="w-full bg-red-500 rounded-t-lg relative transition-all duration-500 hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/30" 
                                     style="height: {{ $val > 0 ? ($val / (max($trenAncaman['data']) ?: 1) * 100) : 5 }}%">
                                     <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                         {{ $val }}
                                     </span>
                                </div>
                                <span class="text-xs font-bold text-gray-400 mt-3">{{ $trenAncaman['labels'][$index] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- TAB 2: THREATS & IP BLOCKING -->
        @if($activeTab === 'threats')
            <div class="space-y-6 animate-fade-in-up">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Manajemen Blokir IP (Blacklist)</h3>
                    <p class="text-sm text-gray-500 mb-6">Tambahkan alamat IP yang dicurigai melakukan serangan Brute Force atau aktivitas ilegal lainnya. Akses dari IP ini akan ditolak otomatis oleh sistem.</p>
                    
                    <div class="flex gap-4 mb-8">
                        <input type="text" wire:model="newBlockedIp" placeholder="Contoh: 192.168.1.50" 
                            class="flex-1 rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <button wire:click="addBlockedIp" class="px-6 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors shadow-lg shadow-red-600/20">
                            Blokir IP
                        </button>
                    </div>

                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Alamat IP</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($blockedIps as $ip)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-medium text-gray-900 dark:text-white">{{ $ip }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Blocked
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="removeBlockedIp('{{ $ip }}')" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                Hapus Blokir
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                            Belum ada IP yang diblokir. Sistem aman.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- TAB 3: ACTIVE SESSIONS -->
        @if($activeTab === 'sessions')
            <div class="space-y-6 animate-fade-in-up">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Pengguna Aktif (24 Jam Terakhir)</h3>
                    <p class="text-sm text-gray-500 mb-6">Daftar pengguna yang baru saja login atau aktif berinteraksi dengan sistem.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($activeSessions as $user)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-2xl p-4 flex items-start gap-4 hover:shadow-md transition-shadow">
                                <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-lg flex-shrink-0">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $user->name }}</h4>
                                    <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                                    <p class="text-[10px] text-teal-600 font-bold mt-1">
                                        Login: {{ $user->riwayatLogins->first()->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <button wire:click="killUserSession({{ $user->id }})" wire:confirm="Paksa logout pengguna ini?" class="text-red-500 hover:text-red-700 p-2" title="Force Logout">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                </button>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                Tidak ada sesi aktif yang ditemukan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        <!-- TAB 4: AUDIT LOGS -->
        @if($activeTab === 'logs')
            <div class="space-y-6 animate-fade-in-up">
                <div class="flex gap-4 mb-4">
                    <div class="flex-1 relative">
                        <input type="text" wire:model.live.debounce.300ms="logSearch" placeholder="Cari aktivitas..." class="w-full pl-10 rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Aktor</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Metadata</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $log->causer->name ?? 'System' }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->causer->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $log->description }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400 font-mono max-w-xs truncate">
                                        {{ json_encode($log->properties) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        Tidak ada log aktivitas yang cocok.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>