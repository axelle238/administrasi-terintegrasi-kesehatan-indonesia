<div class="space-y-8">
    <!-- Row 1: Security Status & KPI -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- System Health -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                    </span>
                    <p class="text-xs font-bold text-emerald-100 uppercase tracking-widest">Status Sistem</p>
                </div>
                <h3 class="text-3xl font-black mb-1">Aman</h3>
                <p class="text-[10px] text-emerald-100 font-mono">Enkripsi: {{ $securityStatus['encryption'] }}</p>
            </div>
        </div>

        <!-- Firewall Status -->
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-4 h-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    <p class="text-xs font-bold text-blue-100 uppercase tracking-widest">Firewall</p>
                </div>
                <h3 class="text-3xl font-black mb-1">{{ $securityStatus['firewall'] }}</h3>
                <p class="text-[10px] text-blue-100 font-mono">SSL: {{ $securityStatus['ssl_expiry'] }}</p>
            </div>
        </div>

        <!-- Threat Level -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tingkat Ancaman</p>
                </div>
                <h3 class="text-3xl font-black mb-1 text-red-500">{{ $securityStatus['threat_level'] }}</h3>
                <p class="text-[10px] text-slate-400 font-mono">{{ $loginFailedToday }} Percobaan Ilegal Hari Ini</p>
            </div>
        </div>

        <!-- Total Activity -->
        <div class="card-health p-6 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-primary-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Total Log Aktivitas</p>
                <h3 class="text-3xl font-black text-slate-800">{{ number_format($logsToday) }}</h3>
                <p class="text-[10px] text-slate-500 font-medium mt-1">Minggu Ini: {{ number_format($logsWeek) }}</p>
            </div>
        </div>
    </div>

    <!-- Row 2: Charts & Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Threat Analysis Chart -->
        <div class="lg:col-span-2 card-health">
            <div class="card-health-header">
                <div>
                    <h3 class="text-lg font-black text-slate-800">Analisis Ancaman Siber</h3>
                    <p class="text-xs text-slate-500 font-bold mt-1">Grafik Percobaan Login Gagal (Brute Force)</p>
                </div>
                <div class="bg-red-50 text-red-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider animate-pulse">
                    Monitoring Aktif
                </div>
            </div>
            <div class="card-health-body">
                <div class="h-64 flex items-end justify-between gap-3 px-2">
                    @foreach($trenAncaman['data'] as $index => $val)
                        <div class="flex flex-col items-center flex-1 group">
                            <div class="w-full bg-red-500 rounded-t-sm relative transition-all duration-300 hover:bg-red-600 shadow-[0_0_15px_rgba(239,68,68,0.5)]" 
                                 style="height: {{ $val > 0 ? ($val / (max($trenAncaman['data']) ?: 1) * 100) : 0 }}%">
                                 <!-- Data Label -->
                                 <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-slate-900 text-white text-[10px] font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-20">
                                     {{ $val }}
                                 </span>
                            </div>
                            <span class="text-[10px] font-mono font-bold text-slate-400 mt-2 uppercase tracking-wide">{{ $trenAncaman['labels'][$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Top Active Users -->
        <div class="card-health">
            <div class="card-health-header">
                <div>
                    <h3 class="text-lg font-black text-slate-800">Pengguna Teraktif</h3>
                    <p class="text-xs text-slate-500 font-bold mt-1">Berdasarkan Log Sistem</p>
                </div>
            </div>
            <div class="card-health-body p-0">
                <div class="divide-y divide-slate-50">
                    @forelse($topActiveUsers as $log)
                        <div class="flex items-center justify-between p-4 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs">
                                    {{ substr($log->causer->name ?? 'S', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-700">{{ $log->causer->name ?? 'System' }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wider">{{ $log->causer->role ?? 'Bot' }}</p>
                                </div>
                            </div>
                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-[10px] font-black">{{ $log->total }} Aksi</span>
                        </div>
                    @empty
                        <div class="p-6 text-center text-slate-400 text-xs">Belum ada aktivitas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Critical Logs -->
    <div class="card-health">
        <div class="card-health-header">
            <div>
                <h3 class="text-lg font-black text-slate-800">Log Aktivitas Kritis (Realtime)</h3>
                <p class="text-xs text-slate-500 font-bold mt-1">Audit Trail Penghapusan & Perubahan Data</p>
            </div>
            <a href="{{ route('activity-log') }}" wire:navigate class="btn-secondary text-xs">
                Lihat Semua Log
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left font-mono">
                <thead class="text-xs text-slate-400 uppercase bg-slate-900 text-slate-300 border-b border-slate-700">
                    <tr>
                        <th class="px-6 py-3 font-bold tracking-wider">Waktu</th>
                        <th class="px-6 py-3 font-bold tracking-wider">Aktor</th>
                        <th class="px-6 py-3 font-bold tracking-wider">Kejadian</th>
                        <th class="px-6 py-3 font-bold tracking-wider">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-slate-50/50">
                    @forelse($recentCritical as $log)
                        <tr class="hover:bg-white transition-colors group">
                            <td class="px-6 py-3 text-slate-500 text-xs font-bold">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-6 py-3 font-bold text-slate-700">
                                {{ $log->causer->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-3">
                                @if($log->event == 'deleted')
                                    <span class="text-red-600 bg-red-100 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider">DIHAPUS</span>
                                @else
                                    <span class="text-blue-600 bg-blue-100 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider">DIUBAH</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-slate-600 text-xs truncate max-w-xs" title="{{ $log->description }}">
                                {{ $log->description }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs">
                                Tidak ada log kritis baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
