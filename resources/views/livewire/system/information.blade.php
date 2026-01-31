<div class="space-y-6 animate-fade-in">
    <!-- Header Page -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Status Sistem & Informasi Server</h2>
            <p class="text-sm text-slate-500 font-medium">Monitoring kesehatan teknis aplikasi dan infrastruktur server.</p>
        </div>
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-black uppercase tracking-wider flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Sistem Online
            </span>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 rounded-[2rem] p-6 text-white shadow-lg shadow-indigo-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest">Kerangka Kerja</p>
                    <h3 class="text-2xl font-black">Laravel v{{ $serverInfo['laravel_version'] }}</h3>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-white/10 flex justify-between text-sm text-indigo-100 relative z-10">
                <span class="font-medium">Versi PHP</span>
                <span class="font-mono font-bold">{{ $serverInfo['php_version'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-200 group hover:border-emerald-200 transition-all">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Ukuran Basis Data</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $dbSizeMB }} MB</h3>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between text-sm text-slate-500">
                <span class="font-medium">Total Tabel</span>
                <span class="font-bold text-slate-700">{{ $tableCount }} Tabel</span>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-200 group hover:border-amber-200 transition-all">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Penggunaan Disk</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $serverInfo['disk_used_percent'] }}%</h3>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between text-sm text-slate-500">
                <span class="font-medium">Ruang Tersedia</span>
                <span class="font-bold text-slate-700">{{ $serverInfo['disk_free'] }} / {{ $serverInfo['disk_total'] }}</span>
            </div>
        </div>
    </div>

    <!-- Detailed Tabs -->
    <div x-data="{ activeTab: 'server' }" class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-50/50 px-8 overflow-x-auto">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'server'" :class="{ 'border-indigo-600 text-indigo-700': activeTab === 'server', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'server' }" class="whitespace-nowrap py-5 px-1 border-b-2 font-bold text-sm tracking-wide transition-colors">
                    Server & Konfigurasi
                </button>
                <button @click="activeTab = 'stats'" :class="{ 'border-indigo-600 text-indigo-700': activeTab === 'stats', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'stats' }" class="whitespace-nowrap py-5 px-1 border-b-2 font-bold text-sm tracking-wide transition-colors">
                    Statistik Data
                </button>
                <button @click="activeTab = 'logs'" :class="{ 'border-indigo-600 text-indigo-700': activeTab === 'logs', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'logs' }" class="whitespace-nowrap py-5 px-1 border-b-2 font-bold text-sm tracking-wide transition-colors">
                    Log & Audit
                </button>
                <button @click="activeTab = 'modules'" :class="{ 'border-indigo-600 text-indigo-700': activeTab === 'modules', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'modules' }" class="whitespace-nowrap py-5 px-1 border-b-2 font-bold text-sm tracking-wide transition-colors">
                    Modul Aplikasi
                </button>
            </nav>
        </div>

        <div class="p-8">
            <!-- Server Tab -->
            <div x-show="activeTab === 'server'" class="space-y-8 animate-fade-in">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Informasi Server</h4>
                        <dl class="space-y-4 text-sm">
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <dt class="text-slate-500 font-medium">Sistem Operasi</dt>
                                <dd class="font-mono font-bold text-slate-800">{{ $serverInfo['server_os'] }}</dd>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <dt class="text-slate-500 font-medium">Versi PHP</dt>
                                <dd class="font-mono font-bold text-slate-800">{{ $serverInfo['php_version'] }}</dd>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <dt class="text-slate-500 font-medium">Zona Waktu</dt>
                                <dd class="font-mono font-bold text-slate-800">{{ $serverInfo['timezone'] }}</dd>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <dt class="text-slate-500 font-medium">Environment</dt>
                                <dd class="font-mono font-bold text-slate-800 capitalize">{{ $serverInfo['app_environment'] }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-6 pb-2 border-b border-slate-100">Konfigurasi Layanan</h4>
                        <dl class="space-y-4 text-sm">
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <dt class="text-slate-500 font-medium">Koneksi Database</dt>
                                <dd class="font-mono font-bold text-slate-800 capitalize">{{ $serverInfo['database_connection'] }}</dd>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <dt class="text-slate-500 font-medium">Nama Database</dt>
                                <dd class="font-mono font-bold text-slate-800">{{ $serverInfo['database_name'] }}</dd>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <dt class="text-slate-500 font-medium">Driver Cache</dt>
                                <dd class="font-mono font-bold text-slate-800">{{ $serverInfo['cache_driver'] }}</dd>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <dt class="text-slate-500 font-medium">Driver Antrean</dt>
                                <dd class="font-mono font-bold text-slate-800">{{ $serverInfo['queue_driver'] }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Stats Tab -->
            <div x-show="activeTab === 'stats'" class="grid grid-cols-2 md:grid-cols-4 gap-6 animate-fade-in" style="display: none;">
                @php
                    $statLabels = [
                        'users' => 'Total Pengguna',
                        'patients' => 'Total Pasien',
                        'medicines' => 'Data Obat',
                        'employees' => 'Total Pegawai',
                        'failed_jobs' => 'Antrean Gagal',
                        'activity_logs' => 'Log Tersimpan'
                    ];
                @endphp
                @foreach($stats as $key => $value)
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm text-center hover:shadow-md transition-shadow">
                    <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">{{ $statLabels[$key] ?? ucwords(str_replace('_', ' ', $key)) }}</dt>
                    <dd class="text-3xl font-black {{ $key == 'failed_jobs' && $value > 0 ? 'text-rose-600' : 'text-slate-800' }}">{{ number_format($value) }}</dd>
                </div>
                @endforeach
            </div>

            <!-- Logs Tab -->
            <div x-show="activeTab === 'logs'" class="space-y-6 animate-fade-in" style="display: none;">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4">Aktivitas Sistem Terbaru</h4>
                <div class="overflow-hidden border border-slate-200 rounded-2xl">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-black uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">Pengguna</th>
                                <th class="px-6 py-4">Aktivitas</th>
                                <th class="px-6 py-4">Entitas Terkait</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentLogs as $log)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-slate-500 font-mono font-bold">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $log->causer->name ?? 'Sistem' }}</td>
                                <td class="px-6 py-4 text-slate-600 font-medium">{{ $log->description }}</td>
                                <td class="px-6 py-4 text-slate-500 italic">{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 font-medium">Belum ada log aktivitas tercatat.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modules Tab -->
            <div x-show="activeTab === 'modules'" class="space-y-6 animate-fade-in" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($capabilities as $category => $items)
                    <div class="p-6 bg-white border border-slate-100 rounded-[2rem] shadow-sm hover:border-indigo-100 transition-colors">
                        <h5 class="font-black text-slate-800 mb-4 flex items-center gap-3 text-sm uppercase tracking-wider">
                            <span class="w-2.5 h-2.5 bg-indigo-500 rounded-full"></span> {{ $category }}
                        </h5>
                        <ul class="space-y-3">
                            @foreach($items as $item)
                            <li class="text-sm text-slate-600 font-medium flex items-start gap-3">
                                <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>