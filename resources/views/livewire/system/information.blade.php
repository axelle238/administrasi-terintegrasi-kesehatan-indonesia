<div class="space-y-6">
    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-100 text-sm font-medium uppercase tracking-wider">Framework</p>
                    <h3 class="text-2xl font-bold">Laravel v{{ $serverInfo['laravel_version'] }}</h3>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/10 flex justify-between text-sm text-indigo-100">
                <span>PHP Version</span>
                <span class="font-mono font-bold">{{ $serverInfo['php_version'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Database Size</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $dbSizeMB }} MB</h3>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between text-sm text-slate-500">
                <span>Total Tables</span>
                <span class="font-bold text-slate-700">{{ $tableCount }} Tables</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Disk Usage</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $serverInfo['disk_used_percent'] }}%</h3>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between text-sm text-slate-500">
                <span>Free Space</span>
                <span class="font-bold text-slate-700">{{ $serverInfo['disk_free'] }} / {{ $serverInfo['disk_total'] }}</span>
            </div>
        </div>
    </div>

    <!-- Detailed Tabs -->
    <div x-data="{ activeTab: 'server' }" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-50/50 px-6 overflow-x-auto">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'server'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'server', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'server' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Server & Konfigurasi
                </button>
                <button @click="activeTab = 'stats'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'stats', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'stats' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Statistik Data
                </button>
                <button @click="activeTab = 'logs'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'logs', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'logs' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Logs & Audit
                </button>
                <button @click="activeTab = 'modules'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'modules', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'modules' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Modul Aplikasi
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Server Tab -->
            <div x-show="activeTab === 'server'" class="space-y-6" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b pb-2">Informasi Server</h4>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-slate-500">OS Server</dt>
                                <dd class="font-mono text-slate-800">{{ $serverInfo['server_os'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500">PHP Version</dt>
                                <dd class="font-mono text-slate-800">{{ $serverInfo['php_version'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Timezone</dt>
                                <dd class="font-mono text-slate-800">{{ $serverInfo['timezone'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500">App Environment</dt>
                                <dd class="font-mono text-slate-800 capitalize">{{ $serverInfo['app_environment'] }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b pb-2">Service Config</h4>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Database Driver</dt>
                                <dd class="font-mono text-slate-800 capitalize">{{ $serverInfo['database_connection'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Database Name</dt>
                                <dd class="font-mono text-slate-800">{{ $serverInfo['database_name'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Cache Driver</dt>
                                <dd class="font-mono text-slate-800">{{ $serverInfo['cache_driver'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Queue Driver</dt>
                                <dd class="font-mono text-slate-800">{{ $serverInfo['queue_driver'] }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Stats Tab -->
            <div x-show="activeTab === 'stats'" class="grid grid-cols-2 md:grid-cols-4 gap-6" x-transition style="display: none;">
                @foreach($stats as $key => $value)
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-center">
                    <dt class="text-xs font-bold text-slate-400 uppercase mb-1">{{ str_replace('_', ' ', $key) }}</dt>
                    <dd class="text-2xl font-bold {{ $key == 'failed_jobs' && $value > 0 ? 'text-red-600' : 'text-slate-800' }}">{{ number_format($value) }}</dd>
                </div>
                @endforeach
            </div>

            <!-- Logs Tab -->
            <div x-show="activeTab === 'logs'" class="space-y-4" x-transition style="display: none;">
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Aktivitas Sistem Terbaru</h4>
                <div class="overflow-hidden border border-slate-200 rounded-xl">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase">
                            <tr>
                                <th class="px-4 py-3">Waktu</th>
                                <th class="px-4 py-3">User</th>
                                <th class="px-4 py-3">Aktivitas</th>
                                <th class="px-4 py-3">Subjek</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentLogs as $log)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-500 font-mono">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td class="px-4 py-3 font-bold text-slate-700">{{ $log->causer->name ?? 'System' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $log->description }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-slate-400">Belum ada log aktivitas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modules Tab -->
            <div x-show="activeTab === 'modules'" class="space-y-4" x-transition style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($capabilities as $category => $items)
                    <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <h5 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span> {{ $category }}
                        </h5>
                        <ul class="space-y-2">
                            @foreach($items as $item)
                            <li class="text-xs text-slate-600 flex items-start gap-2">
                                <svg class="w-3.5 h-3.5 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
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