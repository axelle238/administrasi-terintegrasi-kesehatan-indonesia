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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Environment</p>
                    <h3 class="text-2xl font-bold text-slate-800 capitalize">{{ $serverInfo['app_environment'] }}</h3>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between text-sm text-slate-500">
                <span>Debug Mode</span>
                <span class="font-bold {{ $serverInfo['debug_mode'] === 'Enabled' ? 'text-red-500' : 'text-green-500' }}">{{ $serverInfo['debug_mode'] }}</span>
            </div>
        </div>
    </div>

    <!-- Detailed Tabs -->
    <div x-data="{ activeTab: 'server' }" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-50/50 px-6">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'server'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'server', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'server' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Server & Konfigurasi
                </button>
                <button @click="activeTab = 'stats'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'stats', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'stats' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Statistik Data
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
                        </dl>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 border-b pb-2">Database Config</h4>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Connection</dt>
                                <dd class="font-mono text-slate-800 capitalize">{{ $serverInfo['database_connection'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-slate-500">Database Name</dt>
                                <dd class="font-mono text-slate-800">{{ $serverInfo['database_name'] }}</dd>
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
                    <dd class="text-2xl font-bold text-slate-800">{{ number_format($value) }}</dd>
                </div>
                @endforeach
            </div>

            <!-- Modules Tab -->
            <div x-show="activeTab === 'modules'" class="space-y-4" x-transition style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="font-bold text-slate-700">Modul Rekam Medis (RME)</span>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="font-bold text-slate-700">Modul Farmasi & Obat</span>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="font-bold text-slate-700">Modul Kepegawaian (HR)</span>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="font-bold text-slate-700">Modul Aset & Inventaris</span>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded">Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
