<div class="space-y-8 animate-fade-in">
    <!-- Header Dashboard -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-800 flex items-center gap-4">
                <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
                Pusat Kendali Aset & Inventaris
            </h2>
            <p class="text-slate-500 font-medium mt-2 ml-16 leading-relaxed">
                Monitoring status kondisi, nilai perolehan, jadwal pemeliharaan, dan siklus hidup seluruh aset fasilitas kesehatan.
            </p>
        </div>
        <div class="flex items-center gap-3 ml-16 lg:ml-0">
            <a href="{{ route('barang.create') }}" class="px-6 py-3 bg-slate-800 text-white rounded-2xl text-sm font-black hover:bg-slate-900 transition-all shadow-lg shadow-slate-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Registrasi Aset Baru
            </a>
        </div>
    </div>

    <!-- Global Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Aset -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-indigo-200 transition-all">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Populasi Aset</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($totalAset) }} <span class="text-sm font-medium text-slate-400">Unit</span></h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:rotate-6 transition-transform">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>

        <!-- Nilai Perolehan -->
        <div class="bg-indigo-600 p-6 rounded-3xl shadow-xl shadow-indigo-500/20 text-white relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-20 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-indigo-100 uppercase tracking-widest mb-1 relative z-10">Nilai Perolehan Aset</p>
            <h3 class="text-xl font-black relative z-10 truncate">Rp {{ number_format($nilaiAsetTotal, 0, ',', '.') }}</h3>
            <p class="mt-4 text-[10px] font-bold text-indigo-200 uppercase relative z-10 italic">Evaluasi Nilai Kapital</p>
        </div>

        <!-- Kondisi Baik -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-all">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Aset Kondisi Baik</p>
                <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ number_format($kondisiStats['Baik'] ?? 0) }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>

        <!-- Maintenance Alert -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-rose-200 transition-all">
            @php $jmlMaintenance = \App\Models\Maintenance::where('status', 'Terjadwal')->count(); @endphp
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Maintenance Terjadwal</p>
                <h3 class="text-3xl font-black text-rose-600 mt-1">{{ $jmlMaintenance }} <span class="text-sm font-medium text-slate-400">Unit</span></h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:animate-swing transition-transform">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
    </div>

    <!-- Detailed Analysis & Tabs -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 pt-6 border-b border-slate-50 flex gap-10">
            <button wire:click="setTab('ikhtisar')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative {{ $activeTab == 'ikhtisar' ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">
                Ikhtisar & Lokasi
                @if($activeTab == 'ikhtisar') <div class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('stok')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative {{ $activeTab == 'stok' ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">
                Alur Inventaris
                @if($activeTab == 'stok') <div class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('maintenance')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative {{ $activeTab == 'maintenance' ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">
                Jadwal Pemeliharaan
                @if($activeTab == 'maintenance') <div class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div> @endif
            </button>
        </div>

        <div class="p-8">
            @if($activeTab == 'ikhtisar')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 animate-fade-in-up">
                <!-- Visual Kondisi -->
                <div class="space-y-6" x-data="chartKondisi()">
                    <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs">Proporsi Kondisi Aset</h4>
                    <div id="chart-kondisi-aset" class="w-full flex justify-center"></div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="p-3 bg-emerald-50 rounded-2xl text-center">
                            <p class="text-[10px] font-black text-emerald-600 uppercase">Baik</p>
                            <p class="text-lg font-black text-emerald-700">{{ $kondisiStats['Baik'] }}</p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-2xl text-center">
                            <p class="text-[10px] font-black text-amber-600 uppercase">Minor</p>
                            <p class="text-lg font-black text-amber-700">{{ $kondisiStats['PerluPerbaikan'] }}</p>
                        </div>
                        <div class="p-3 bg-rose-50 rounded-2xl text-center">
                            <p class="text-[10px] font-black text-rose-600 uppercase">Rusak</p>
                            <p class="text-lg font-black text-rose-700">{{ $kondisiStats['Rusak'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Lokasi -->
                <div class="space-y-6">
                    <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs">Penempatan Aset Terbanyak</h4>
                    <div class="space-y-4">
                        @foreach($tabData['lokasiAset'] ?? [] as $lokasi)
                        <div class="group">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-bold text-slate-700">{{ $lokasi->nama_ruangan }}</span>
                                <span class="text-xs font-black text-slate-800">{{ $lokasi->barangs_count }} Unit</span>
                            </div>
                            <div class="w-full bg-slate-50 h-1.5 rounded-full overflow-hidden border border-slate-100">
                                <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000 group-hover:bg-indigo-600" style="width: {{ ($lokasi->barangs_count / ($tabData['lokasiAset']->max('barangs_count') ?: 1)) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Audit Trail -->
                <div class="space-y-6">
                    <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs">Log Aktivitas Terbaru</h4>
                    <div class="space-y-4 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($tabData['recentActivities'] ?? [] as $log)
                        <div class="flex gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 relative group hover:bg-white hover:shadow-md transition-all">
                            <div class="w-1 bg-indigo-500 rounded-full h-full absolute left-0 top-0"></div>
                            <div class="flex-1">
                                <p class="text-xs font-black text-slate-800">{{ $log->barang->nama_barang ?? 'Aset' }}</p>
                                <p class="text-[10px] text-slate-500 font-bold uppercase mt-0.5">{{ $log->jenis_transaksi }} • {{ $log->created_at->diffForHumans() }}</p>
                                <p class="text-[10px] text-indigo-600 font-black mt-1 italic">Oleh: {{ $log->user->name ?? 'System' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($activeTab == 'stok')
            <div class="space-y-10 animate-fade-in-up" x-data="chartStokFlow()">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-lg font-black text-slate-800">Analisis Pergerakan Barang</h4>
                        <p class="text-xs text-slate-400 font-bold uppercase mt-1">Data 7 Hari Terakhir</p>
                    </div>
                    <div class="flex gap-6 text-[10px] font-black uppercase tracking-widest">
                        <span class="flex items-center gap-2 text-emerald-600"><div class="w-3 h-3 bg-emerald-500 rounded-sm shadow-sm"></div> Barang Masuk</span>
                        <span class="flex items-center gap-2 text-rose-500"><div class="w-3 h-3 bg-rose-500 rounded-sm shadow-sm"></div> Barang Keluar</span>
                    </div>
                </div>
                <div id="chart-flow-stok" class="w-full h-[350px]"></div>
            </div>
            @endif

            @if($activeTab == 'maintenance')
            <div class="space-y-8 animate-fade-in-up">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- Upcoming Maintenance -->
                    <div class="space-y-6">
                        <h4 class="text-lg font-black text-slate-800">Pemeliharaan Mendatang (14 Hari)</h4>
                        <div class="space-y-4">
                            @forelse($tabData['maintenanceDue'] ?? [] as $m)
                            <div class="p-5 bg-white border border-slate-100 rounded-3xl shadow-sm flex items-center justify-between group hover:border-indigo-200 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs">
                                        {{ \Carbon\Carbon::parse($m->tanggal_berikutnya)->format('d') }}<br>
                                        {{ \Carbon\Carbon::parse($m->tanggal_berikutnya)->format('M') }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">{{ $m->barang->nama_barang ?? 'Alat Medis' }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase">No. Seri: {{ $m->barang->nomor_seri ?? '-' }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[10px] font-black uppercase">Segera</span>
                            </div>
                            @empty
                            <p class="text-center text-slate-400 py-10">Tidak ada jadwal pemeliharaan mendesak.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Cost Summary -->
                    <div class="space-y-6">
                        <h4 class="text-lg font-black text-slate-800">Ringkasan Biaya Pemeliharaan</h4>
                        <div class="p-8 bg-indigo-50 rounded-[2rem] border border-indigo-100 relative overflow-hidden">
                            <p class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-2">Total Biaya Bulan Ini</p>
                            <h3 class="text-4xl font-black text-indigo-700">Rp {{ number_format($tabData['biayaMaintenanceBulanIni'] ?? 0, 0, ',', '.') }}</h3>
                            <div class="mt-6 flex items-center gap-3">
                                <div class="p-2 bg-white rounded-xl text-indigo-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                </div>
                                <p class="text-[10px] text-indigo-500 font-bold uppercase leading-tight">Optimalkan performa alat kesehatan dengan perawatan rutin berbiaya efisien.</p>
                            </div>
                            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-indigo-200/30 rounded-full blur-2xl"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function chartKondisi() {
            return {
                init() {
                    const stats = @json($kondisiStats);
                    const options = {
                        series: [stats.Baik, stats.PerluPerbaikan, stats.Rusak],
                        labels: ['Baik', 'Minor Repair', 'Rusak Berat'],
                        chart: { type: 'donut', height: 280, fontFamily: 'Plus Jakarta Sans' },
                        colors: ['#10b981', '#f59e0b', '#f43f5e'],
                        legend: { position: 'bottom', markers: { radius: 12 } },
                        dataLabels: { enabled: false },
                        stroke: { width: 0 },
                        plotOptions: { pie: { donut: { size: '75%' } } }
                    };
                    new ApexCharts(document.querySelector("#chart-kondisi-aset"), options).render();
                }
            }
        }

        function chartStokFlow() {
            return {
                init() {
                    const data = @json($tabData['flowStok'] ?? ['labels' => [], 'in' => [], 'out' => []]);
                    const options = {
                        series: [
                            { name: 'Barang Masuk', data: data.in },
                            { name: 'Barang Keluar', data: data.out }
                        ],
                        chart: { type: 'bar', height: 350, stacked: true, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans' },
                        plotOptions: { bar: { borderRadius: 8, columnWidth: '35%' } },
                        xaxis: { categories: data.labels, axisBorder: { show: false }, labels: { style: { colors: '#94a3b8', fontWeight: 700 } } },
                        yaxis: { labels: { style: { colors: '#94a3b8', fontWeight: 700 } } },
                        colors: ['#10b981', '#f43f5e'],
                        legend: { show: false },
                        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                        dataLabels: { enabled: false }
                    };
                    new ApexCharts(document.querySelector("#chart-flow-stok"), options).render();
                }
            }
        }
    </script>
    @endpush
</div>