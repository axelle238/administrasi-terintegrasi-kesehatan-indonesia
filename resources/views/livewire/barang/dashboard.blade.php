<div class="space-y-8">
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Aset -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Item</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ number_format($totalAset) }}</h3>
                </div>
            </div>
        </div>

        <!-- Nilai Aset -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Valuasi Aset</p>
                    <h3 class="text-lg font-black text-slate-800 dark:text-white truncate">Rp {{ number_format($nilaiAset, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Kondisi Rusak -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/50 flex items-center justify-center text-red-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Aset Rusak</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $kondisiRusak }} <span class="text-sm font-medium text-slate-400">Unit</span></h3>
                </div>
            </div>
        </div>

        <!-- Maintenance Due -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-900/50 flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Jadwal Servis</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $maintenanceDue }} <span class="text-sm font-medium text-slate-400">Minggu Ini</span></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Low Stock Alert -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                Stok Menipis (Barang Habis Pakai)
            </h3>
            <div class="space-y-3">
                @forelse($lowStockItems as $item)
                    <div class="flex justify-between items-center p-3 rounded-xl bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-800">
                        <div>
                            <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $item->nama_barang }}</p>
                            <p class="text-xs text-slate-500">{{ $item->kode_barang }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-black text-red-600">{{ $item->stok }}</span>
                            <p class="text-[10px] font-bold text-red-400 uppercase">{{ $item->satuan }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-400 text-sm">Semua stok aman.</div>
                @endforelse
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('barang.index') }}" wire:navigate class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua Data &rarr;</a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Aktivitas Terkini</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Barang</th>
                            <th class="px-4 py-3">Aktivitas</th>
                            <th class="px-4 py-3">Oleh</th>
                            <th class="px-4 py-3 rounded-r-lg text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @forelse($recentActivities as $log)
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-white">
                                    {{ $log->barang->nama_barang ?? 'Item Terhapus' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $log->jenis_transaksi == 'Masuk' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ $log->jenis_transaksi }} ({{ $log->jumlah }})
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    {{ $log->user->name ?? 'System' }}
                                </td>
                                <td class="px-4 py-3 text-right text-slate-400 text-xs">
                                    {{ $log->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-6 text-slate-400">Belum ada aktivitas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>