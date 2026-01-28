<div class="space-y-8">
    <!-- Row 1: Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Kunjungan Hari Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kunjungan Hari Ini</p>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-2">{{ $totalKunjunganHariIni }}</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4"><span class="text-emerald-500 font-bold">+{{ $totalKunjunganBulanIni }}</span> bulan ini</p>
        </div>

        <!-- Bed Occupancy Rate (BOR) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Okupansi Bed (BOR)</p>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-2">{{ number_format($bor, 1) }}%</h3>
                </div>
                <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-4">
                <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ $bor }}%"></div>
            </div>
            <p class="text-xs text-slate-500 mt-2">{{ $bedTerisi }} Terisi / {{ $totalBed }} Total</p>
        </div>

        <!-- Rata-rata Waktu Layanan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border-l-4 border-orange-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Avg Waktu Layanan</p>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-2">{{ number_format($avgWaktuLayanan, 0) }} <span class="text-sm font-medium text-slate-400">Menit</span></h3>
                </div>
                <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4">Per Pasien Hari Ini</p>
        </div>

        <!-- Pasien Baru -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border-l-4 border-emerald-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pasien Baru</p>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white mt-2">{{ $pasienBaru }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4">Bulan Ini</p>
        </div>
    </div>

    <!-- Row 2: Charts & Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik Kunjungan -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Tren Kunjungan 7 Hari Terakhir</h3>
            <div class="h-64 flex items-end justify-between gap-2 px-4">
                @foreach($trenKunjungan['data'] as $index => $val)
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-full bg-blue-500 dark:bg-blue-600 rounded-t-lg relative transition-all duration-300 hover:bg-blue-400" 
                             style="height: {{ $val > 0 ? ($val / (max($trenKunjungan['data']) ?: 1) * 100) : 0 }}%">
                             <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-bold text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity">{{ $val }}</span>
                        </div>
                        <span class="text-[10px] text-slate-400 mt-2 font-bold">{{ $trenKunjungan['labels'][$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Diagnosa -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Top Diagnosa (ICD-10)</h3>
            <div class="space-y-4">
                @forelse($topDiagnosa as $diag)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-xs">
                                {{ substr($diag->diagnosa, 0, 1) }}
                            </div>
                            <span class="text-sm font-bold text-slate-700 dark:text-gray-300 truncate max-w-[150px]" title="{{ $diag->diagnosa }}">{{ $diag->diagnosa }}</span>
                        </div>
                        <span class="text-sm font-black text-slate-900 dark:text-white">{{ $diag->total }}</span>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-sm py-4">Belum ada data diagnosa.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Row 3: Distribusi Pasien & Aktivitas Poli -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Distribusi Pasien (BPJS/Umum) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Jenis Pembayaran Hari Ini</h3>
            <div class="space-y-4">
                @forelse($distribusiPembayaran as $dist)
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-600 dark:text-gray-300">{{ $dist->asuransi ?? 'Umum' }}</span>
                        <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-full text-xs font-black">{{ $dist->total }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ ($dist->total / max($totalKunjunganHariIni, 1)) * 100 }}%"></div>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-sm">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        <!-- Aktivitas Poli -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Aktivitas Poliklinik Hari Ini</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($poliActivity as $poli)
                    <div class="p-4 rounded-xl border border-slate-100 hover:border-blue-500 hover:shadow-md transition-all bg-slate-50 dark:bg-slate-700/30">
                        <div class="flex justify-between items-center">
                            <h4 class="font-bold text-slate-700 dark:text-gray-200">{{ $poli->poli->nama_poli }}</h4>
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-black rounded-lg">{{ $poli->total }} Ps</span>
                        </div>
                        <div class="mt-2 w-full bg-slate-200 rounded-full h-1">
                            <div class="bg-blue-500 h-1 rounded-full" style="width: {{ min(100, ($poli->total / 20) * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>