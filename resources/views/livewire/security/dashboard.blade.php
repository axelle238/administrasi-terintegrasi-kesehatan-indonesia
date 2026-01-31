<div class="space-y-8 animate-fade-in pb-20">
    <!-- Header Command Center (SOC) -->
    <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl border border-slate-800 relative overflow-hidden">
        <!-- Visual Background Decoration -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#3b82f6 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-600/20 rounded-full blur-[100px]"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-blue-500/10 rounded-3xl border border-blue-500/30 flex items-center justify-center text-blue-400 shadow-[0_0_20px_rgba(59,130,246,0.2)]">
                    <svg class="w-10 h-10 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944V22m0-19.056c2.81 0 5.333.877 7.392 2.373a12.014 12.014 0 013.226 8.682 12.01 12.01 0 01-3.226 8.682c-2.059 1.496-4.582 2.373-7.392 2.373m0-19.056C9.19 2.944 6.667 3.821 4.608 5.317a12.014 12.014 0 00-3.226 8.682 12.01 12.01 0 003.226 8.682c2.059 1.496 4.582 2.373 7.392 2.373" /></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-white tracking-tight">Pusat Komando Keamanan Siber</h2>
                    <p class="text-blue-400/80 font-mono text-sm mt-1 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
                        Status Sistem: Terproteksi & Aktif
                    </p>
                </div>
            </div>

            <!-- Lockdown Mode Toggle -->
            <div class="flex flex-col items-end gap-3 bg-slate-800/50 p-6 rounded-[2rem] border border-slate-700 backdrop-blur-xl">
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-tighter">Mode Darurat (Lockdown)</p>
                        <p class="text-[10px] text-slate-500">Putuskan semua akses non-admin</p>
                    </div>
                    <button wire:click="toggleLockdown" 
                            class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors focus:outline-none {{ $isLockdown ? 'bg-rose-600 shadow-[0_0_15px_rgba(225,29,72,0.5)]' : 'bg-slate-600' }}">
                        <span class="sr-only">Toggle Lockdown</span>
                        <span class="inline-block h-6 w-6 transform rounded-full bg-white transition-transform {{ $isLockdown ? 'translate-x-7' : 'translate-x-1' }}"></span>
                    </button>
                </div>
                @if($isLockdown)
                    <p class="text-[10px] font-black text-rose-400 animate-pulse uppercase">⚠️ Sitem Sedang Dalam Penguncian Total</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Security KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between group hover:shadow-lg transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Login Gagal</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['failed_logins'] }} <span class="text-xs text-slate-400 font-medium">Hari Ini</span></h3>
                </div>
            </div>
            <p class="text-[10px] font-bold text-rose-500 uppercase tracking-tighter">Potensi Brute-Force: Rendah</p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between group hover:shadow-lg transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Aktivitas Sistem</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ number_format($stats['logs_today']) }} <span class="text-xs text-slate-400 font-medium">Log</span></h3>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                <div class="bg-indigo-500 h-full rounded-full" style="width: 65%"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between group hover:shadow-lg transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">IP Terblokir</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['blocked_ips_count'] }} <span class="text-xs text-slate-400 font-medium">Host</span></h3>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">Firewall Manual: Aktif</p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between group hover:shadow-lg transition-all">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sesi Aktif</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stats['active_users'] }} <span class="text-xs text-slate-400 font-medium">User</span></h3>
                </div>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Monitor Sesi Waktu Nyata</span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 pt-6 border-b border-slate-50 flex gap-10 overflow-x-auto">
            <button wire:click="setTab('overview')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative whitespace-nowrap {{ $activeTab == 'overview' ? 'text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                Ringkasan Ancaman
                @if($activeTab == 'overview') <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('threats')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative whitespace-nowrap {{ $activeTab == 'threats' ? 'text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                Firewall & Blokir IP
                @if($activeTab == 'threats') <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('sessions')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative whitespace-nowrap {{ $activeTab == 'sessions' ? 'text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                Kontrol Sesi User
                @if($activeTab == 'sessions') <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('logs')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative whitespace-nowrap {{ $activeTab == 'logs' ? 'text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                Jejak Audit Forensik
                @if($activeTab == 'logs') <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded-t-full"></div> @endif
            </button>
        </div>

        <div class="p-8">
            <!-- TAB: OVERVIEW -->
            @if($activeTab == 'overview')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 animate-fade-in-up">
                <div class="lg:col-span-2 space-y-6" x-data="chartAncaman()">
                    <div class="flex justify-between items-center">
                        <h4 class="text-lg font-black text-slate-800">Tren Deteksi Ancaman (Login Gagal)</h4>
                        <span class="text-xs font-bold text-slate-400">7 Hari Terakhir</span>
                    </div>
                    <div id="chart-ancaman" class="w-full h-[350px]"></div>
                </div>
                
                <div class="space-y-8">
                    <h4 class="text-lg font-black text-slate-800">Status Keamanan Inti</h4>
                    <div class="space-y-4">
                        <div class="p-5 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between">
                            <span class="text-sm font-bold text-slate-600">Enkripsi Database</span>
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase">Aktif</span>
                        </div>
                        <div class="p-5 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between">
                            <span class="text-sm font-bold text-slate-600">SSL / TLS Termination</span>
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase">Terverifikasi</span>
                        </div>
                        <div class="p-5 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between">
                            <span class="text-sm font-bold text-slate-600">Audit Logging</span>
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase">Lengkap</span>
                        </div>
                        <div class="p-5 bg-slate-50 rounded-3xl border border-slate-100 flex items-center justify-between">
                            <span class="text-sm font-bold text-slate-600">Multi-Factor Auth (MFA)</span>
                            <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-lg text-[10px] font-black uppercase">Opsional</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- TAB: THREATS -->
            @if($activeTab == 'threats')
            <div class="animate-fade-in-up grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <h4 class="text-lg font-black text-slate-800">Tambahkan IP ke Daftar Blokir</h4>
                    <div class="flex gap-3">
                        <input type="text" wire:model="newBlockedIp" placeholder="Contoh: 192.168.1.1" class="flex-1 rounded-2xl border-slate-200 focus:ring-rose-500 focus:border-rose-500 font-mono text-sm">
                        <button wire:click="addBlockedIp" class="px-6 py-3 bg-rose-600 text-white rounded-2xl text-sm font-black hover:bg-rose-700 transition-all shadow-lg shadow-rose-200">Blokir IP</button>
                    </div>
                    @error('newBlockedIp') <p class="text-xs text-rose-600 font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-6">
                    <h4 class="text-lg font-black text-slate-800">IP Terblokir Saat Ini</h4>
                    <div class="space-y-3 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($blockedIps as $ip)
                        <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-100 rounded-2xl group hover:bg-white hover:border-rose-200 transition-all">
                            <span class="font-mono font-bold text-slate-700">{{ $ip }}</span>
                            <button wire:click="removeBlockedIp('{{ $ip }}')" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </button>
                        </div>
                        @empty
                        <p class="text-center text-slate-400 py-10">Tidak ada IP yang terblokir.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @endif

            <!-- TAB: SESSIONS -->
            @if($activeTab == 'sessions')
            <div class="animate-fade-in-up space-y-6">
                <div class="flex justify-between items-center">
                    <h4 class="text-lg font-black text-slate-800">Sesi Pengguna Aktif (24 Jam Terakhir)</h4>
                    <span class="text-xs font-bold text-slate-400 uppercase">Kontrol Akses Langsung</span>
                </div>
                <div class="overflow-hidden border border-slate-100 rounded-[2rem]">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-400 font-black uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="px-8 py-5">Pengguna</th>
                                <th class="px-8 py-5">Peran</th>
                                <th class="px-8 py-5">Login Terakhir</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($activeSessions as $user)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-5 flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-black text-slate-500 text-xs">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800">{{ $user->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-mono">{{ $user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-[10px] font-black uppercase">{{ $user->role }}</span>
                                </td>
                                <td class="px-8 py-5 font-bold text-slate-600">
                                    {{ $user->riwayatLogins->first()->created_at->diffForHumans() ?? '-' }}
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <button wire:click="killUserSession({{ $user->id }})" 
                                            onclick="confirm('Putuskan paksa sesi pengguna ini?') || event.stopImmediatePropagation()"
                                            class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- TAB: LOGS -->
            @if($activeTab == 'logs')
            <div class="animate-fade-in-up space-y-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <h4 class="text-lg font-black text-slate-800">Log Aktivitas Keamanan</h4>
                    <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                        <input type="text" wire:model.live="userSearch" placeholder="Filter User..." class="rounded-xl border-slate-200 text-sm focus:ring-blue-500 w-full md:w-48">
                        <input type="text" wire:model.live="logSearch" placeholder="Cari aktivitas..." class="rounded-xl border-slate-200 text-sm focus:ring-blue-500 w-full md:w-64">
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach($logs as $log)
                    <div class="p-5 bg-slate-50 border border-slate-100 rounded-3xl flex flex-col md:flex-row justify-between gap-4 group hover:bg-white hover:shadow-md transition-all">
                        <div class="flex gap-4">
                            <div class="w-1 bg-blue-500 rounded-full h-full"></div>
                            <div>
                                <p class="text-sm font-black text-slate-800">{{ $log->description }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">
                                    Oleh: <span class="text-blue-600">{{ $log->causer->name ?? 'System' }}</span> • {{ $log->created_at->format('d M Y H:i:s') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right flex flex-col justify-center">
                            <span class="text-[10px] font-mono text-slate-400">ID: #{{ $log->id }}</span>
                            <span class="text-[10px] font-mono text-slate-400">IP: {{ $log->properties['ip'] ?? 'Local' }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $logs->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function chartAncaman() {
            return {
                init() {
                    const data = @json($trenAncaman);
                    const options = {
                        series: [{
                            name: 'Upaya Login Gagal',
                            data: data.data
                        }],
                        chart: {
                            type: 'area',
                            height: 350,
                            toolbar: { show: false },
                            fontFamily: 'Plus Jakarta Sans, sans-serif'
                        },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        colors: ['#3b82f6'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.45,
                                opacityTo: 0.05,
                                stops: [20, 100]
                            }
                        },
                        xaxis: {
                            categories: data.labels,
                            axisBorder: { show: false },
                            labels: { style: { colors: '#94a3b8', fontWeight: 700 } }
                        },
                        yaxis: {
                            labels: { style: { colors: '#94a3b8', fontWeight: 700 } }
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            strokeDashArray: 4
                        },
                        tooltip: { theme: 'dark' }
                    };
                    new ApexCharts(document.querySelector("#chart-ancaman"), options).render();
                }
            }
        }
    </script>
    @endpush
</div>