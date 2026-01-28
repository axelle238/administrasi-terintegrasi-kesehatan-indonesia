<div class="space-y-8">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-xs font-bold text-emerald-100 uppercase tracking-widest">Pendapatan Hari Ini</p>
                <h3 class="text-3xl font-black mt-2">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
            </div>
            <svg class="absolute bottom-0 right-0 w-24 h-24 text-white opacity-10 -mr-6 -mb-6 transform group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" /></svg>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendapatan Bulan Ini</p>
            <h3 class="text-2xl font-black text-slate-800 dark:text-white mt-2">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-500 font-bold mt-2">+ vs bulan lalu (est)</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Estimasi Pengeluaran Gaji</p>
            <h3 class="text-2xl font-black text-slate-800 dark:text-white mt-2">Rp {{ number_format($pengeluaranGajiBulan, 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-400 mt-2">Bulan Ini</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Tahun Ini</p>
            <h3 class="text-xl font-black text-slate-800 dark:text-white mt-2 truncate">Rp {{ number_format($pendapatanTahunIni, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue Trend -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Tren Pendapatan Tahunan</h3>
            <div class="h-64 flex items-end justify-between gap-2 px-4">
                @foreach($grafikPendapatan['data'] as $index => $val)
                    <div class="flex flex-col items-center flex-1 group" title="Rp {{ number_format($val) }}">
                        <div class="w-full bg-emerald-500 dark:bg-emerald-600 rounded-t-sm relative transition-all duration-300 hover:bg-emerald-400" 
                             style="height: {{ $val > 0 ? ($val / (max($grafikPendapatan['data']) ?: 1) * 100) : 0 }}%">
                        </div>
                        <span class="text-[10px] text-slate-400 mt-2 font-bold">{{ substr($grafikPendapatan['labels'][$index], 0, 3) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Metode Pembayaran</h3>
            <div class="space-y-4">
                @foreach($metodeBayar as $m)
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-600 dark:text-gray-300">{{ $m->metode_pembayaran }}</span>
                        <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-full text-xs font-black">{{ $m->total }} Trx</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($m->total / $metodeBayar->sum('total')) * 100 }}%"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
