<div class="space-y-8">
    <!-- Row 1: Security Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Aktivitas Hari Ini</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ number_format($logsToday) }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Aktivitas Minggu Ini</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ number_format($logsWeek) }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Login Gagal (Hari Ini)</p>
                    <h3 class="text-2xl font-black text-red-600">{{ $loginFailedToday }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">User Baru (Bulan Ini)</p>
                    <h3 class="text-2xl font-black text-emerald-600">{{ $newUsersMonth }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Top Active Users & Recent Critical -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Active Users -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">User Teraktif (Top 5)</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">User</th>
                            <th class="px-4 py-3 text-right rounded-r-lg">Total Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @forelse($topActiveUsers as $log)
                            <tr>
                                <td class="px-4 py-3 font-bold text-slate-700 dark:text-gray-300">
                                    {{ $log->causer->name ?? 'System' }}
                                </td>
                                <td class="px-4 py-3 text-right font-black text-slate-900 dark:text-white">
                                    {{ $log->total }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center py-4 text-slate-400">Belum ada aktivitas user.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Critical Activities -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Aktivitas Kritis Terkini</h3>
            <div class="space-y-4">
                @forelse($recentCritical as $log)
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                        <div class="mt-1">
                            @if($log->event == 'deleted')
                                <span class="text-red-500 font-bold text-xs uppercase bg-red-100 px-2 py-0.5 rounded">HAPUS</span>
                            @else
                                <span class="text-blue-500 font-bold text-xs uppercase bg-blue-100 px-2 py-0.5 rounded">UBAH</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $log->description }}</p>
                            <p class="text-xs text-slate-500 mt-1">Oleh: {{ $log->causer->name ?? 'System' }} • {{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-slate-400 text-sm">Tidak ada aktivitas kritis baru-baru ini.</div>
                @endforelse
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('activity-log') }}" wire:navigate class="text-xs font-bold text-blue-600 hover:text-blue-800 uppercase tracking-widest">Lihat Semua Log &rarr;</a>
            </div>
        </div>
    </div>
</div>
