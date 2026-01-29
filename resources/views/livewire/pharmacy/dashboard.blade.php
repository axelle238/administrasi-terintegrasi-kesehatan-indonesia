<div class="space-y-8">
    <!-- Critical Alerts -->
    @if($stokHabis > 0)
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm animate-pulse">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-black text-red-800 uppercase tracking-wide">Tindakan Segera Diperlukan!</h3>
                    <div class="text-sm text-red-700 mt-1">
                        Terdapat <span class="font-bold text-lg">{{ $stokHabis }} item obat</span> dengan stok 0 (Habis). Segera lakukan pengadaan ulang.
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('obat.index') }}?filter=habis" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-lg text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
    @endif

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
            <p class="text-xs text-slate-500 mt-4">Valuasi: <span class="font-bold text-emerald-600">Rp {{ number_format($valuasiAset, 0, ',', '.') }}</span></p>
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
            <p class="text-xs text-red-500 mt-4 font-bold">{{ $stokHabis }} Stok Habis</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kedaluwarsa</p>
                    <h3 class="text-2xl font-black text-red-600">{{ $obatExpired }}</h3>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4">Dalam 3 Bulan</p>
        </div>
    </div>

    <!-- Row 2: Charts & Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik Tren Penggunaan -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Tren Penggunaan Obat (7 Hari Terakhir)</h3>
            <div class="h-64 flex items-end justify-between gap-2 px-4">
                @foreach($trenObat['data'] as $index => $val)
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-full bg-emerald-500 dark:bg-emerald-600 rounded-t-lg relative transition-all duration-300 hover:bg-emerald-400" 
                             style="height: {{ $val > 0 ? ($val / (max($trenObat['data']) ?: 1) * 100) : 0 }}%">
                             <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-bold text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity">{{ $val }}</span>
                        </div>
                        <span class="text-[10px] text-slate-400 mt-2 font-bold">{{ $trenObat['labels'][$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Obat -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Obat Paling Sering Keluar</h3>
            <div class="space-y-4">
                @forelse($topObat as $item)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                        <span class="text-sm font-bold text-slate-700 dark:text-gray-300 truncate max-w-[150px]">
                            {{ $obatNames[$item->obat_id] ?? 'Unknown' }}
                        </span>
                        <span class="text-sm font-black text-slate-900 dark:text-white">{{ number_format($item->total_keluar) }}</span>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-sm py-4">Belum ada data transaksi.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Row 3: Expiring Soon -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Peringatan Kedaluwarsa (6 Bulan Ke Depan)</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @forelse($listExpired as $obat)
                <div class="p-4 rounded-xl border border-red-100 bg-red-50 dark:bg-red-900/20 dark:border-red-800">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-black text-red-600 bg-red-200 px-2 py-0.5 rounded">{{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->format('d M Y') }}</span>
                    </div>
                    <h4 class="font-bold text-slate-800 dark:text-white text-sm truncate">{{ $obat->nama_obat }}</h4>
                    <p class="text-xs text-slate-500 mt-1">Stok: {{ $obat->stok }}</p>
                </div>
            @empty
                <div class="col-span-full text-center py-4 text-emerald-600 font-bold bg-emerald-50 rounded-xl">
                    Tidak ada obat yang akan kedaluwarsa dalam waktu dekat.
                </div>
            @endforelse
        </div>
    </div>
</div>