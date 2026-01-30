<div class="space-y-8 animate-fade-in">
    <!-- Header Dashboard Publik -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-800 flex items-center gap-4">
                <div class="p-3 bg-amber-50 rounded-2xl text-amber-600 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                Sentra Komunikasi Masyarakat
            </h2>
            <p class="text-slate-500 font-medium mt-2 ml-16 leading-relaxed">
                Analisis kepuasan pelanggan, monitoring tindak lanjut pengaduan, dan pengelolaan opini publik secara terpadu.
            </p>
        </div>
        <div class="flex items-center gap-3 ml-16 lg:ml-0">
            <a href="{{ route('admin.masyarakat.pengaduan.index') }}" class="px-6 py-3 bg-slate-800 text-white rounded-2xl text-sm font-black hover:bg-slate-900 transition-all shadow-lg shadow-slate-200 flex items-center gap-2">
                Tindak Lanjut Pengaduan
            </a>
        </div>
    </div>

    <!-- Global KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- IKM Score -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-6 rounded-3xl text-white shadow-xl shadow-amber-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-amber-100 uppercase tracking-widest mb-1 relative z-10">Skor IKM Real-time</p>
            <h3 class="text-4xl font-black relative z-10">{{ number_format($ikmScore, 1) }}</h3>
            <p class="mt-4 text-[10px] font-bold text-amber-100 uppercase relative z-10 italic">Indeks Kepuasan Masyarakat</p>
        </div>

        <!-- Total Pengaduan -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-amber-200 transition-all">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pengaduan</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($totalPengaduan) }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-slate-50 text-slate-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
            </div>
        </div>

        <!-- Pending Resolution -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-rose-200 transition-all">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Belum Ditangani</p>
                <h3 class="text-3xl font-black text-rose-600 mt-1">{{ number_format($pengaduanPending) }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:animate-swing transition-transform">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>

        <!-- Response Time -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-all">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Rata-rata Respon</p>
                <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ $avgResponseTime }} <span class="text-sm font-medium text-slate-400">Jam</span></h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
        </div>
    </div>

    <!-- Charts & Feed Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Main Trend Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100" x-data="chartMasyarakat()">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h4 class="text-xl font-black text-slate-800">Tren Laporan Masyarakat</h4>
                    <p class="text-xs text-slate-400 font-bold uppercase mt-1">Volume Keluhan 6 Bulan Terakhir</p>
                </div>
                <div class="px-4 py-2 bg-slate-50 rounded-xl text-[10px] font-black uppercase text-slate-500 border border-slate-100 italic">Data Terverifikasi</div>
            </div>
            <div id="chart-tren-publik" class="w-full h-[350px]"></div>
        </div>

        <!-- Channel Distribution -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
            <h4 class="text-lg font-black text-slate-800 mb-8">Kanal Pengaduan Teraktif</h4>
            <div class="space-y-6">
                @foreach($kanalPengaduan as $kanal)
                <div class="group">
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-bold text-slate-700">{{ $kanal['nama'] }}</span>
                        <span class="text-xs font-black text-slate-800">{{ number_format($kanal['total']) }} Lap.</span>
                    </div>
                    <div class="w-full bg-slate-50 h-1.5 rounded-full overflow-hidden border border-slate-100">
                        <div class="bg-amber-500 h-full rounded-full transition-all duration-1000 group-hover:bg-amber-600" style="width: {{ ($kanal['total'] / ($totalPengaduan ?: 1)) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Responden Info -->
            <div class="mt-10 p-6 bg-slate-900 rounded-3xl text-white relative overflow-hidden group">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Partisipan Survei</p>
                <div class="flex items-end gap-3">
                    <h4 class="text-4xl font-black text-white">{{ number_format($totalResponden) }}</h4>
                    <span class="text-xs font-bold text-emerald-400 mb-1">Masyarakat</span>
                </div>
                <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-blue-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            </div>
        </div>
    </div>

    <!-- Feed Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h4 class="text-lg font-black text-slate-800">Laporan & Pengaduan Terbaru</h4>
                <p class="text-[10px] text-slate-400 font-black uppercase mt-0.5 tracking-wider italic">Real-time Public Voice Monitoring</p>
            </div>
            <a href="{{ route('admin.masyarakat.pengaduan.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black text-slate-600 hover:text-amber-600 hover:border-amber-200 transition-all">Manajemen Pengaduan &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="text-[10px] text-slate-400 uppercase bg-white font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-5">Pelapor</th>
                        <th class="px-8 py-5">Subjek / Isu</th>
                        <th class="px-8 py-5">Waktu Lapor</th>
                        <th class="px-8 py-5 text-center">Tingkat Urgensi</th>
                        <th class="px-8 py-5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pengaduanTerbaru as $p)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="text-sm font-black text-slate-800">{{ $p->nama_pelapor }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase">{{ $p->email_pelapor ?? '-' }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-bold text-slate-600 px-2 py-1 bg-slate-100 rounded-lg">{{ $p->subjek }}</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-[10px] font-black text-slate-500 uppercase tracking-tighter">
                            {{ $p->created_at->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            @php
                                $urgencyColor = match($p->prioritas) {
                                    'Tinggi' => 'text-rose-600',
                                    'Sedang' => 'text-amber-600',
                                    'Rendah' => 'text-blue-600',
                                    default => 'text-slate-600'
                                };
                            @endphp
                            <span class="text-[10px] font-black uppercase tracking-widest {{ $urgencyColor }}">{{ $p->prioritas ?? 'Standar' }}</span>
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-center">
                            @php
                                $statusStyle = match($p->status) {
                                    'Selesai' => 'bg-emerald-100 text-emerald-700',
                                    'Diproses' => 'bg-blue-100 text-blue-700',
                                    'Pending' => 'bg-amber-100 text-amber-700',
                                    default => 'bg-slate-100 text-slate-700'
                                };
                            @endphp
                            <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $statusStyle }}">
                                {{ $p->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium italic">Belum ada laporan masuk dari masyarakat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        function chartMasyarakat() {
            return {
                init() {
                    const data = @json($grafikPengaduan);
                    const options = {
                        series: [{
                            name: 'Laporan Masuk',
                            data: data.data
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: { show: false },
                            fontFamily: 'Plus Jakarta Sans, sans-serif'
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                columnWidth: '45%',
                                dataLabels: { position: 'top' }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) { return val },
                            offsetY: -20,
                            style: { fontSize: '10px', colors: ["#334155"], fontWeight: 900 }
                        },
                        xaxis: {
                            categories: data.labels,
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: { style: { colors: '#94a3b8', fontWeight: 700 } }
                        },
                        yaxis: {
                            labels: { style: { colors: '#94a3b8', fontWeight: 700 } }
                        },
                        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                        colors: ['#f59e0b'],
                        tooltip: { theme: 'dark' }
                    };
                    new ApexCharts(document.querySelector("#chart-tren-publik"), options).render();
                }
            }
        }
    </script>
    @endpush
</div>
