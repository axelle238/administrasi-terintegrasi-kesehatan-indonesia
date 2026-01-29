<div class="space-y-6">
    <!-- Header Command Center -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                Analitik Keuangan Terpadu
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 ml-12">
                Monitoring pendapatan, arus kas, dan margin laba operasional fasilitas kesehatan.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <select wire:model.live="periodeTahun" class="rounded-xl border-gray-300 text-sm focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="{{ date('Y') }}">Tahun {{ date('Y') }}</option>
                <option value="{{ date('Y')-1 }}">Tahun {{ date('Y')-1 }}</option>
            </select>
            <button wire:click="$refresh" class="p-2.5 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 text-gray-500 hover:text-emerald-600 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            </button>
        </div>
    </div>

    <!-- Top Key Performance Indicators -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Pendapatan Card -->
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 p-6 rounded-3xl text-white shadow-xl shadow-emerald-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-emerald-100 uppercase tracking-widest mb-1">Pendapatan Bulan Ini</p>
            <h3 class="text-2xl font-black">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center gap-2">
                <span class="text-[10px] bg-emerald-500/30 px-2 py-0.5 rounded font-bold">Harian: Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Margin Laba Card -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Estimasi Laba Bersih</p>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white">Rp {{ number_format($labaBersihBulan, 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center gap-2">
                <div class="flex-1 bg-gray-100 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $rasioMargin }}%"></div>
                </div>
                <span class="text-[10px] font-bold text-emerald-600">{{ number_format($rasioMargin, 1) }}% Margin</span>
            </div>
        </div>

        <!-- Pengeluaran Card -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Operasional & Gaji</p>
            <h3 class="text-2xl font-black text-red-600">Rp {{ number_format($totalPengeluaranBulan, 0, ',', '.') }}</h3>
            <p class="mt-4 text-[10px] text-gray-500 font-medium">Beban Gaji: Rp {{ number_format($pengeluaranGajiBulan, 0, ',', '.') }}</p>
        </div>

        <!-- Piutang/Pending Card -->
        <div class="bg-amber-50 dark:bg-amber-900/20 p-6 rounded-3xl border border-amber-100 dark:border-amber-900/30 relative overflow-hidden group">
            <p class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest mb-1">Piutang Pending</p>
            <h3 class="text-2xl font-black text-amber-700 dark:text-amber-300">Rp {{ number_format($piutangPending, 0, ',', '.') }}</h3>
            <p class="mt-4 text-[10px] text-amber-600 font-bold flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Ditunggu dari {{ $piutangCount }} Transaksi
            </p>
        </div>
    </div>

    <!-- Tabbed Analysis Area -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="border-b border-gray-100 dark:border-gray-700 px-6 pt-4 flex gap-8">
            <button wire:click="setTab('ikhtisar')" class="pb-4 text-sm font-bold transition-all relative {{ $activeTab == 'ikhtisar' ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
                Ringkasan Arus Kas
                @if($activeTab == 'ikhtisar') <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('analitik')" class="pb-4 text-sm font-bold transition-all relative {{ $activeTab == 'analitik' ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
                Analitik & Proyeksi
                @if($activeTab == 'analitik') <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-600 rounded-t-full"></div> @endif
            </button>
        </div>

        <div class="p-8">
            @if($activeTab == 'ikhtisar')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 animate-fade-in-up">
                    <!-- Grafik Arus Kas -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">Performa Keuangan 6 Bulan</h4>
                            <div class="flex gap-4 text-xs font-bold">
                                <span class="flex items-center gap-1.5 text-emerald-600"><div class="w-3 h-3 bg-emerald-500 rounded-sm"></div> Pendapatan</span>
                                <span class="flex items-center gap-1.5 text-red-500"><div class="w-3 h-3 bg-red-500 rounded-sm"></div> Pengeluaran</span>
                            </div>
                        </div>
                        
                        <div class="h-64 flex items-end justify-between gap-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                            @foreach($grafikData['labels'] as $index => $label)
                                <div class="flex-1 flex flex-col items-center group h-full justify-end">
                                    <div class="flex items-end gap-1 h-full w-full justify-center">
                                        <!-- Income Bar -->
                                        <div class="w-3 bg-emerald-500 rounded-t-sm transition-all duration-500 group-hover:bg-emerald-600 relative" 
                                             style="height: {{ $grafikData['income'][$index] > 0 ? ($grafikData['income'][$index] / (max($grafikData['income']) ?: 1) * 100) : 0 }}%">
                                             <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 z-20 whitespace-nowrap">
                                                 Rp {{ number_format($grafikData['income'][$index], 0, ',', '.') }}
                                             </div>
                                        </div>
                                        <!-- Expense Bar -->
                                        <div class="w-3 bg-red-400 rounded-t-sm transition-all duration-500 group-hover:bg-red-500 relative" 
                                             style="height: {{ $grafikData['expense'][$index] > 0 ? ($grafikData['expense'][$index] / (max($grafikData['income']) ?: 1) * 100) : 0 }}%">
                                             <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 z-20 whitespace-nowrap">
                                                 Rp {{ number_format($grafikData['expense'][$index], 0, ',', '.') }}
                                             </div>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-400 mt-3">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Side Stats -->
                    <div class="space-y-8">
                        <div>
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Top Revenue by Poli</h4>
                            <div class="space-y-4">
                                @foreach($pendapatanPoli as $poli)
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $poli->nama_poli }}</p>
                                            <div class="w-32 bg-gray-100 dark:bg-gray-700 h-1 rounded-full mt-1">
                                                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ ($poli->total / ($pendapatanBulanIni ?: 1)) * 100 }}%"></div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-black text-gray-900 dark:text-white">Rp {{ number_format($poli->total, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-900/30">
                            <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400 mb-2">Metrik Pasien</p>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-2xl font-black text-emerald-800 dark:text-emerald-300">Rp {{ number_format($rataTransaksiPasien, 0, ',', '.') }}</p>
                                    <p class="text-[10px] text-emerald-600 font-medium italic">Rata-rata pendapatan per pasien</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($activeTab == 'analitik')
                <div class="space-y-6 animate-fade-in-up">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-6 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                            <h4 class="text-sm font-bold text-slate-500 uppercase mb-4">Efisiensi Biaya</h4>
                            <div class="flex items-center gap-6">
                                <div class="relative w-24 h-24">
                                    <svg class="w-full h-full transform -rotate-90">
                                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-200 dark:text-slate-600" />
                                        <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-emerald-500" 
                                            stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 - (251.2 * $rasioMargin / 100) }}" />
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center font-black text-lg text-slate-800 dark:text-white">
                                        {{ round($rasioMargin) }}%
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-slate-500 leading-relaxed">
                                        Persentase laba bersih setelah dikurangi beban operasional dan gaji pegawai bulan ini. 
                                        Target margin sehat adalah di atas 20%.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                            <h4 class="text-sm font-bold text-slate-500 uppercase mb-4">Status Tagihan Pending</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between text-xs">
                                    <span class="font-bold text-slate-600 dark:text-slate-300">Piutang Menunggu Konfirmasi</span>
                                    <span class="font-black text-amber-600">Rp {{ number_format($piutangPending, 0, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-600 h-2 rounded-full">
                                    <div class="bg-amber-500 h-full rounded-full" style="width: 45%"></div> <!-- Placeholder % -->
                                </div>
                                <p class="text-[10px] text-slate-400 italic font-medium">Segera lakukan follow-up pada transaksi berstatus 'Menunggu'.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Live Transaction Feed -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-8 py-5 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center">
            <h4 class="text-lg font-black text-gray-900 dark:text-white">Alur Transaksi Terakhir</h4>
            <a href="{{ route('kasir.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua Transaksi</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 dark:bg-gray-700/50 font-bold">
                    <tr>
                        <th class="px-8 py-4">Waktu</th>
                        <th class="px-8 py-4">Pasien</th>
                        <th class="px-8 py-4">Metode</th>
                        <th class="px-8 py-4 text-right">Total Bayar</th>
                        <th class="px-8 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($transaksiTerakhir as $trx)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors group">
                            <td class="px-8 py-4 whitespace-nowrap text-xs text-gray-500 font-mono">
                                {{ $trx->created_at->format('H:i:s') }}
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-800 dark:text-white">{{ $trx->pasien->nama_pasien ?? 'Umum' }}</div>
                                <div class="text-[10px] text-gray-400 font-mono">{{ $trx->nomor_pembayaran }}</div>
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                {{ $trx->metode_pembayaran }}
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-right font-black text-gray-900 dark:text-white">
                                Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-center">
                                @php
                                    $statusColor = match($trx->status) {
                                        'Lunas' => 'bg-emerald-100 text-emerald-700',
                                        'Menunggu' => 'bg-amber-100 text-amber-700',
                                        'Batal' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $statusColor }}">
                                    {{ $trx->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-gray-400">Belum ada transaksi terekam.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
