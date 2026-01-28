<div class="space-y-8">
    <!-- Row 1: Financial Health Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pendapatan Hari Ini -->
        <div class="card-health p-6 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-primary-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendapatan Hari Ini</p>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mb-2 overflow-hidden">
                    <div class="bg-primary-500 h-full rounded-full animate-pulse" style="width: 45%"></div>
                </div>
                <p class="text-[10px] text-slate-400 font-medium flex justify-between">
                    <span>Target Harian</span>
                    <span class="text-primary-600 font-bold">45%</span>
                </p>
            </div>
        </div>

        <!-- Pendapatan Bulan Ini -->
        <div class="card-health p-6 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-health-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-health-500 to-health-600 flex items-center justify-center text-white shadow-lg shadow-health-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akumulasi Bulan Ini</p>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-health-600 bg-white/80 backdrop-blur-sm px-3 py-1.5 rounded-lg border border-health-100 w-max shadow-sm">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    Proyeksi: Rp {{ number_format($proyeksiAkhirBulan, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Pengeluaran Gaji -->
        <div class="card-health p-6 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Beban Gaji (Estimasi)</p>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">Rp {{ number_format($pengeluaranGajiBulan, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-orange-600 bg-white/80 backdrop-blur-sm px-3 py-1.5 rounded-lg border border-orange-100 w-max shadow-sm">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                    Beban Operasional Utama
                </div>
            </div>
        </div>

        <!-- Profitabilitas -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-48 h-48 bg-white/5 rounded-full -mr-16 -mt-16 blur-3xl group-hover:bg-white/10 transition-colors"></div>
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Net Cash Flow (Est)</p>
                    <h3 class="text-3xl font-black text-white tracking-tight">Rp {{ number_format($pendapatanBulanIni - $pengeluaranGajiBulan, 0, ',', '.') }}</h3>
                </div>
                <div class="mt-4 pt-4 border-t border-white/10 flex justify-between items-end">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold">Rata-rata Harian</p>
                        <p class="text-sm font-bold text-primary-300">Rp {{ number_format($rataRataHarian, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Analytics & Methods -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue Chart -->
        <div class="lg:col-span-2 card-health">
            <div class="card-health-header">
                <div>
                    <h3 class="text-lg font-black text-slate-800">Analitik Pendapatan</h3>
                    <p class="text-xs text-slate-500 font-bold mt-1">Tren Keuangan 12 Bulan Terakhir</p>
                </div>
                <button class="btn-icon">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                </button>
            </div>
            <div class="card-health-body">
                <div class="h-72 flex items-end justify-between gap-3 px-2">
                    @foreach($grafikPendapatan['data'] as $index => $val)
                        <div class="flex flex-col items-center flex-1 group h-full justify-end">
                            <div class="w-full bg-gradient-to-t from-primary-600 to-primary-400 rounded-t-lg relative transition-all duration-500 group-hover:from-primary-500 group-hover:to-primary-300 shadow-lg shadow-primary-500/20" 
                                 style="height: {{ $val > 0 ? ($val / (max($grafikPendapatan['data']) ?: 1) * 100) : 0 }}%">
                                 <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                 
                                 <!-- Tooltip -->
                                 <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-[10px] font-bold px-2 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all z-20 pointer-events-none whitespace-nowrap shadow-xl">
                                     Rp {{ number_format($val/1000000, 1) }}Jt
                                     <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1 w-2 h-2 bg-slate-800 rotate-45"></div>
                                 </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 mt-3 uppercase tracking-wider rotate-0 md:rotate-0">{{ $grafikPendapatan['labels'][$index] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="card-health">
            <div class="card-health-header">
                <div>
                    <h3 class="text-lg font-black text-slate-800">Metode Pembayaran</h3>
                    <p class="text-xs text-slate-500 font-bold mt-1">Distribusi Transaksi Bulan Ini</p>
                </div>
            </div>
            <div class="card-health-body space-y-5">
                @foreach($metodeBayar as $metode)
                    <div class="group">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                @if(strtolower($metode->metode_pembayaran) == 'tunai')
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                @elseif(strtolower($metode->metode_pembayaran) == 'bpjs')
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                @endif
                                {{ $metode->metode_pembayaran }}
                            </span>
                            <span class="text-xs font-black text-slate-900 bg-slate-100 px-2 py-1 rounded-lg">{{ $metode->total }} Transaksi</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000 group-hover:scale-x-105 origin-left
                                @if(strtolower($metode->metode_pembayaran) == 'tunai') bg-emerald-500
                                @elseif(strtolower($metode->metode_pembayaran) == 'bpjs') bg-green-500
                                @else bg-blue-500 @endif" 
                                style="width: {{ ($metode->total / $metodeBayar->sum('total')) * 100 }}%">
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Empty State -->
                @if($metodeBayar->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-slate-400 text-sm font-medium">Belum ada data transaksi bulan ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Row 3: Live Transactions -->
    <div class="card-health">
        <div class="card-health-header">
            <div>
                <h3 class="text-lg font-black text-slate-800">Transaksi Langsung Terkini</h3>
                <p class="text-xs text-slate-500 font-bold mt-1">Monitor Pembayaran Real-time</p>
            </div>
            <a href="{{ route('kasir.index') }}" wire:navigate class="btn-secondary text-xs">
                Lihat Semua Transaksi
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Pasien</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Metode</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Kasir</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-right">Jumlah</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-center">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transaksiTerakhir as $trx)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4 font-mono font-bold text-primary-600">
                                #{{ substr($trx->id, 0, 8) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700">{{ $trx->pasien->nama ?? 'Umum' }}</div>
                                <div class="text-xs text-slate-400">{{ $trx->pasien->no_rm ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge-pill 
                                    @if(strtolower($trx->metode_pembayaran) == 'tunai') badge-health
                                    @elseif(strtolower($trx->metode_pembayaran) == 'bpjs') badge-success
                                    @else badge-primary @endif">
                                    {{ $trx->metode_pembayaran }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium text-xs">
                                {{ $trx->kasir->name ?? 'Sistem' }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-slate-800">
                                Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center text-slate-400 text-xs font-bold">
                                {{ $trx->created_at->format('H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold">Belum ada transaksi pembayaran hari ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>