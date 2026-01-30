<div class="space-y-8">
    
    <!-- Section 1: Welcome & Overview -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight mb-2">
                Selamat Datang, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-slate-500 font-medium">Berikut adalah ringkasan operasional fasilitas kesehatan hari ini.</p>
        </div>
        <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100">
            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-slate-400 uppercase">Hari Ini</p>
                <p class="text-sm font-black text-slate-800">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Section 2: Key Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pasien -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-blue-500 transform rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pasien</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1">{{ number_format($totalPasien) }}</h3>
                <p class="text-xs font-medium text-emerald-500 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    +{{ $pasienBaruBulanIni }} Bulan Ini
                </p>
            </div>
        </div>

        <!-- Antrean Hari Ini -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-purple-500 transform -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Antrean Hari Ini</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $antreanHariIni }}</h3>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-xs font-medium text-slate-500">Selesai: <strong>{{ $antreanSelesai }}</strong></span>
                    <span class="text-[10px] px-2 py-0.5 rounded bg-purple-100 text-purple-700 font-bold">Avg: {{ $avgWaktuLayanan }}m</span>
                </div>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-emerald-500 transform rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pendapatan Harian</span>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-1">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 truncate">Total bulan ini: <span class="font-bold text-slate-700">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</span></p>
            </div>
        </div>

        <!-- Rawat Inap -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-orange-500 transform -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rawat Inap</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $pasienRawatInap }}</h3>
                <p class="text-xs text-slate-500">Bed Tersedia: <span class="font-bold text-orange-600">{{ $kamarTersedia }}</span></p>
            </div>
        </div>
    </div>

    <!-- Section 3: Charts & Medical Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Chart: Kunjungan -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100" x-data="chartKunjungan()">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-slate-800 text-lg">Tren Kunjungan Pasien</h3>
                <select class="text-xs border-none bg-slate-50 rounded-lg text-slate-500 font-bold focus:ring-0 cursor-pointer hover:bg-slate-100 transition-colors">
                    <option>6 Bulan Terakhir</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
            <div id="chart-kunjungan" class="w-full h-[300px]"></div>
        </div>

        <!-- Side Stats: Poli & EWS -->
        <div class="space-y-6">
            <!-- Top Poli -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 h-max">
                <h3 class="font-bold text-slate-800 text-lg mb-4">Kunjungan Poli (Hari Ini)</h3>
                <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($kunjunganPoli as $poli)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors cursor-default border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-xs font-black text-slate-700 shadow-sm">
                                {{ substr($poli->poli->nama_poli ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">{{ $poli->poli->nama_poli ?? 'N/A' }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Poli</p>
                            </div>
                        </div>
                        <span class="text-sm font-black text-slate-800 bg-white px-2 py-1 rounded shadow-sm">{{ $poli->total }}</span>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-400 text-xs">Belum ada data kunjungan.</div>
                    @endforelse
                </div>
            </div>

            <!-- EWS Alerts -->
            @if($strExpired > 0 || $sipExpired > 0 || $obatExpired > 0 || $obatMenipis > 0)
            <div class="bg-red-50 p-6 rounded-2xl border border-red-100">
                <div class="flex items-center gap-2 mb-4 text-red-700">
                    <svg class="w-5 h-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <h3 class="font-bold text-lg">Peringatan Dini</h3>
                </div>
                <div class="space-y-2">
                    @if($strExpired > 0) <div class="flex justify-between text-sm text-red-600 font-medium"><span>STR Expired</span><span class="bg-red-200 px-2 rounded font-bold">{{ $strExpired }}</span></div> @endif
                    @if($sipExpired > 0) <div class="flex justify-between text-sm text-red-600 font-medium"><span>SIP Expired</span><span class="bg-red-200 px-2 rounded font-bold">{{ $sipExpired }}</span></div> @endif
                    @if($obatExpired > 0) <div class="flex justify-between text-sm text-red-600 font-medium"><span>Obat Expired</span><span class="bg-red-200 px-2 rounded font-bold">{{ $obatExpired }}</span></div> @endif
                    @if($obatMenipis > 0) <div class="flex justify-between text-sm text-red-600 font-medium"><span>Stok Menipis</span><span class="bg-red-200 px-2 rounded font-bold">{{ $obatMenipis }}</span></div> @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Section 4: Secondary Charts & Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Diagnosa Terbanyak -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-800 text-lg mb-6">Diagnosa Terpopuler Bulan Ini</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-3 rounded-tl-lg">Peringkat</th>
                            <th class="px-4 py-3">Diagnosa (ICD-10)</th>
                            <th class="px-4 py-3 text-right rounded-tr-lg">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($topPenyakit as $index => $penyakit)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 font-bold text-slate-500">#{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $penyakit->diagnosa }}</td>
                            <td class="px-4 py-3 text-right font-black text-slate-800">{{ $penyakit->total }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-6 text-slate-400">Belum ada data diagnosa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Grafik Keuangan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100" x-data="chartPendapatan()">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-slate-800 text-lg">Arus Pendapatan (7 Hari)</h3>
                <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded">Gross Revenue</span>
            </div>
            <div id="chart-pendapatan" class="w-full h-[300px]"></div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <a href="{{ route('antrean.index') }}" wire:navigate class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 hover:-translate-y-1 transition-all group flex flex-col items-center justify-center gap-3 text-center">
            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-blue-600">Antrean Baru</span>
        </a>
        <a href="{{ route('pasien.create') }}" wire:navigate class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 hover:-translate-y-1 transition-all group flex flex-col items-center justify-center gap-3 text-center">
            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-emerald-600">Daftar Pasien</span>
        </a>
        <a href="{{ route('rekam-medis.create') }}" wire:navigate class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md hover:border-rose-200 hover:-translate-y-1 transition-all group flex flex-col items-center justify-center gap-3 text-center">
            <div class="w-10 h-10 rounded-full bg-rose-50 flex items-center justify-center text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-rose-600">Rekam Medis</span>
        </a>
        <a href="{{ route('kasir.index') }}" wire:navigate class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md hover:border-orange-200 hover:-translate-y-1 transition-all group flex flex-col items-center justify-center gap-3 text-center">
            <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-orange-600">Kasir</span>
        </a>
        <a href="{{ route('obat.index') }}" wire:navigate class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md hover:border-teal-200 hover:-translate-y-1 transition-all group flex flex-col items-center justify-center gap-3 text-center">
            <div class="w-10 h-10 rounded-full bg-teal-50 flex items-center justify-center text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-teal-600">Stok Obat</span>
        </a>
        <a href="{{ route('pegawai.index') }}" wire:navigate class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 hover:-translate-y-1 transition-all group flex flex-col items-center justify-center gap-3 text-center">
            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-indigo-600">Pegawai</span>
        </a>
    </div>

    @push('scripts')
    <script>
        function chartKunjungan() {
            return {
                init() {
                    const options = {
                        series: [{
                            name: 'Total Pasien',
                            data: @json($dataGrafik['data'])
                        }],
                        chart: {
                            type: 'area',
                            height: 300,
                            toolbar: { show: false },
                            fontFamily: 'Plus Jakarta Sans, sans-serif'
                        },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 2 },
                        xaxis: {
                            categories: @json($dataGrafik['labels']),
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        yaxis: { show: false },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0.05,
                                stops: [0, 90, 100]
                            }
                        },
                        colors: ['#3b82f6'],
                        tooltip: {
                            y: { formatter: function (val) { return val + " Pasien" } }
                        }
                    };
                    const chart = new ApexCharts(document.querySelector("#chart-kunjungan"), options);
                    chart.render();
                }
            }
        }

        function chartPendapatan() {
            return {
                init() {
                    const options = {
                        series: [{
                            name: 'Pendapatan',
                            data: @json($dataPendapatan['data'])
                        }],
                        chart: {
                            type: 'bar',
                            height: 300,
                            toolbar: { show: false },
                            fontFamily: 'Plus Jakarta Sans, sans-serif'
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                columnWidth: '40%',
                            }
                        },
                        dataLabels: { enabled: false },
                        xaxis: {
                            categories: @json($dataPendapatan['labels']),
                            axisBorder: { show: false },
                            axisTicks: { show: false }
                        },
                        colors: ['#10b981'],
                        tooltip: {
                            y: { formatter: function (val) { return "Rp " + new Intl.NumberFormat('id-ID').format(val) } }
                        }
                    };
                    const chart = new ApexCharts(document.querySelector("#chart-pendapatan"), options);
                    chart.render();
                }
            }
        }
    </script>
    @endpush
</div>