<div class="space-y-6 animate-fade-in">
    <!-- Header Command Center -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 flex items-center gap-3">
                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                Pusat Analitik Keuangan
            </h2>
            <p class="text-sm text-slate-500 mt-1 ml-12 font-medium">
                Pantauan waktu nyata pendapatan, margin laba, dan efisiensi biaya operasional.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <select wire:model.live="periodeTahun" class="rounded-xl border-slate-200 text-sm font-bold text-slate-600 focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50">
                <option value="{{ date('Y') }}">Tahun {{ date('Y') }}</option>
                <option value="{{ date('Y')-1 }}">Tahun {{ date('Y')-1 }}</option>
            </select>
            <button wire:click="$refresh" class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            </button>
        </div>
    </div>

    <!-- Top KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pendapatan Card -->
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 p-6 rounded-3xl text-white shadow-xl shadow-emerald-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex justify-between items-start mb-2">
                <p class="text-xs font-bold text-emerald-100 uppercase tracking-widest relative z-10">Pendapatan Bulan Ini</p>
                <div class="px-2 py-0.5 rounded bg-white/20 text-[10px] font-black backdrop-blur-sm flex items-center gap-1">
                    @if($pertumbuhanBulanan >= 0)
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        +{{ number_format($pertumbuhanBulanan, 1) }}%
                    @else
                        <svg class="w-3 h-3 text-rose-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6 6" /></svg>
                        {{ number_format($pertumbuhanBulanan, 1) }}%
                    @endif
                </div>
            </div>
            <h3 class="text-2xl font-black relative z-10">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center justify-between text-[10px] font-bold relative z-10">
                <span class="bg-emerald-500/30 px-2 py-1 rounded">Hari Ini: Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</span>
                <span class="opacity-70">Pendapatan Kotor</span>
            </div>
        </div>

        <!-- Margin Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Estimasi Laba Bersih</p>
            <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($labaBersihBulan, 0, ',', '.') }}</h3>
            <div class="mt-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-[10px] font-black text-emerald-600">{{ number_format($rasioMargin, 1) }}% Margin Bersih</span>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, $rasioMargin) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Pengeluaran Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Beban Operasional</p>
            <h3 class="text-2xl font-black text-rose-600">Rp {{ number_format($totalPengeluaranBulan, 0, ',', '.') }}</h3>
            <div class="flex gap-2 mt-4">
                <div class="flex-1 bg-slate-50 p-2 rounded-xl text-center border border-slate-100">
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Gaji</p>
                    <p class="text-xs font-black text-slate-700">{{ number_format(($pengeluaranGajiBulan / ($totalPengeluaranBulan ?: 1)) * 100, 0) }}%</p>
                </div>
                <div class="flex-1 bg-slate-50 p-2 rounded-xl text-center border border-slate-100">
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Aset</p>
                    <p class="text-xs font-black text-slate-700">{{ number_format(($pengeluaranBarangBulan / ($totalPengeluaranBulan ?: 1)) * 100, 0) }}%</p>
                </div>
            </div>
        </div>

        <!-- Cost Per Patient Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Rata-rata Biaya Layanan</p>
            <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($costPerPatient, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-4 uppercase">Beban per Pasien</p>
        </div>
    </div>

    <!-- Main Analysis Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Cashflow Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-100" x-data="chartFinance()">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-black text-slate-800 text-lg">Performa Arus Kas (6 Bulan)</h3>
                <div class="flex items-center gap-4 text-[10px] font-black uppercase">
                    <span class="flex items-center gap-1.5 text-emerald-600"><div class="w-3 h-3 bg-emerald-500 rounded-sm"></div> Pendapatan</span>
                    <span class="flex items-center gap-1.5 text-rose-500"><div class="w-3 h-3 bg-rose-500 rounded-sm"></div> Pengeluaran</span>
                </div>
            </div>
            <div id="chart-finance-main" class="w-full h-[350px]"></div>
        </div>

        <!-- Right Side: Revenue Distribution -->
        <div class="space-y-6">
            <!-- Revenue Sources (Donut) -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100" x-data="chartSources()">
                <h3 class="font-black text-slate-800 text-lg mb-2">Sumber Pendapatan</h3>
                <div id="chart-revenue-sources" class="flex justify-center h-[200px]"></div>
                <div class="grid grid-cols-3 gap-2 mt-2 text-center">
                    @foreach($distribusiPendapatan['labels'] as $index => $label)
                    <div class="p-2 bg-slate-50 rounded-lg">
                        <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $label }}</p>
                        <p class="text-[10px] font-black text-slate-800">Rp {{ number_format(($distribusiPendapatan['data'][$index] ?? 0)/1000000, 1) }}jt</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Methods (NEW) -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest mb-4">Preferensi Pembayaran</h3>
                <div class="space-y-3">
                    @foreach($metodePembayaran as $mp)
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-600">{{ $mp->metode_pembayaran }}</span>
                        <span class="font-black text-slate-800">{{ $mp->total }} Transaksi</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Revenue by Poli -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="font-black text-slate-800 text-lg mb-4">Top 5 Poliklinik</h3>
                <div class="space-y-4">
                    @forelse($pendapatanPoli as $poli)
                        <div class="group">
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-xs font-bold text-slate-700">{{ $poli->nama_poli }}</span>
                                <span class="text-xs font-black text-slate-800">Rp {{ number_format($poli->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-slate-50 h-1.5 rounded-full overflow-hidden border border-slate-100">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000 group-hover:bg-emerald-600" style="width: {{ ($poli->total / ($pendapatanBulanIni ?: 1)) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-xs text-slate-400 font-medium py-4">Belum ada data pendapatan poli.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Live Transaction Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h4 class="text-lg font-black text-slate-800">Riwayat Transaksi Terbaru</h4>
                <p class="text-xs text-slate-500 font-medium mt-0.5 uppercase tracking-wider">Jejak Audit Keuangan</p>
            </div>
            <a href="{{ route('kasir.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-black text-slate-600 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm">Buka Buku Kas &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="text-[10px] text-slate-400 uppercase bg-white font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-5">Waktu</th>
                        <th class="px-8 py-5">Identitas Pasien</th>
                        <th class="px-8 py-5">Metode Bayar</th>
                        <th class="px-8 py-5 text-right">Nominal</th>
                        <th class="px-8 py-5 text-center">Status Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transaksiTerakhir as $trx)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-8 py-5 whitespace-nowrap text-xs text-slate-500 font-mono font-bold">
                                {{ $trx->created_at->format('H:i') }} <span class="opacity-50">WIB</span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="text-sm font-black text-slate-800">{{ $trx->pasien->nama_pasien ?? 'Pasien Umum' }}</div>
                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $trx->nomor_pembayaran }}</div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded-lg">{{ $trx->metode_pembayaran }}</span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-right font-black text-slate-900">
                                Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-center">
                                @php
                                    $statusStyle = match($trx->status) {
                                        'Lunas' => 'bg-emerald-100 text-emerald-700',
                                        'Menunggu' => 'bg-amber-100 text-amber-700',
                                        'Batal' => 'bg-rose-100 text-rose-700',
                                        default => 'bg-slate-100 text-slate-700'
                                    };
                                @endphp
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider {{ $statusStyle }}">
                                    {{ $trx->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium">Belum ada aktivitas transaksi hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        function chartFinance() {
            return {
                init() {
                    const data = @json($dataGrafik);
                    const options = {
                        series: [
                            { name: 'Pendapatan', data: data.pendapatan },
                            { name: 'Pengeluaran', data: data.pengeluaran }
                        ],
                        chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: { show: false },
                            fontFamily: 'Plus Jakarta Sans, sans-serif'
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                borderRadius: 6,
                                dataLabels: { position: 'top' },
                            },
                        },
                        dataLabels: { enabled: false },
                        stroke: { show: true, width: 2, colors: ['transparent'] },
                        xaxis: {
                            categories: data.labels,
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: {
                            labels: {
                                formatter: function (val) {
                                    return "Rp " + (val / 1000000).toFixed(1) + "jt";
                                }
                            }
                        },
                        fill: { opacity: 1 },
                        colors: ['#10b981', '#f43f5e'],
                        tooltip: {
                            y: { formatter: function (val) { return "Rp " + new Intl.NumberFormat('id-ID').format(val) } }
                        },
                        legend: { show: false }
                    };
                    new ApexCharts(document.querySelector("#chart-finance-main"), options).render();
                }
            }
        }

        function chartSources() {
            return {
                init() {
                    const data = @json($distribusiPendapatan);
                    const options = {
                        series: data.data,
                        labels: data.labels,
                        chart: { type: 'donut', height: 200, fontFamily: 'Plus Jakarta Sans' },
                        colors: ['#3b82f6', '#10b981', '#f59e0b'],
                        plotOptions: { pie: { donut: { size: '65%' } } },
                        dataLabels: { enabled: false },
                        legend: { show: false },
                        tooltip: {
                            y: { formatter: function (val) { return "Rp " + new Intl.NumberFormat('id-ID').format(val) } }
                        }
                    };
                    new ApexCharts(document.querySelector("#chart-revenue-sources"), options).render();
                }
            }
        }
    </script>
    @endpush
</div>