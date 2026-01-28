<div class="space-y-8">
    <!-- Row 1: Inventory Health -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Item Obat</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ number_format($totalItemObat) }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Resep Hari Ini</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $resepHariIni }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Stok Menipis</p>
                    <h3 class="text-2xl font-black text-yellow-600">{{ $stokMenipis }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kedaluwarsa (EWS)</p>
                    <h3 class="text-2xl font-black text-red-600">{{ $obatExpired }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Top Medicine Usage -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Top 5 Obat Paling Sering Diresepkan</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-400 uppercase bg-slate-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">Nama Obat</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Jumlah Keluar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                    @forelse($topObat as $item)
                        <tr>
                            <td class="px-4 py-3 font-bold text-slate-700 dark:text-gray-300">
                                {{ $obatNames[$item->obat_id] ?? 'Unknown Item' }}
                            </td>
                            <td class="px-4 py-3 text-right font-black text-slate-900 dark:text-white">
                                {{ number_format($item->total_keluar) }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center py-4 text-slate-400">Belum ada data transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
