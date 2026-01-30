<div class="space-y-8 animate-fade-in">
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800 flex items-center gap-3">
                <div class="p-2 bg-teal-50 rounded-xl text-teal-600">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                Manajemen Perbekalan Farmasi
            </h2>
            <p class="text-slate-500 font-medium ml-12">Monitoring ketersediaan obat, masa kedaluwarsa, dan alur penggunaan secara real-time.</p>
        </div>
        <div class="flex items-center gap-3 ml-12 md:ml-0">
            <a href="{{ route('obat.index') }}" class="px-5 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 transition-all shadow-lg shadow-slate-200">Kelola Katalog Obat</a>
            <button wire:click="$refresh" class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-600 hover:bg-teal-50 hover:text-teal-600 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Valuasi Card -->
        <div class="bg-gradient-to-br from-teal-600 to-emerald-700 p-6 rounded-3xl text-white shadow-xl shadow-teal-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-teal-100 uppercase tracking-widest mb-1">Nilai Inventaris</p>
            <h3 class="text-2xl font-black">Rp {{ number_format($valuasiStok, 0, ',', '.') }}</h3>
            <p class="mt-4 text-[10px] font-bold text-teal-100/80 uppercase">Total: {{ number_format($totalStokUnit) }} Unit Obat</p>
        </div>

        <!-- Stok Kritis Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:border-amber-200 transition-colors">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Stok Menipis</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $stokKritis }} Item</h3>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-amber-500 h-full rounded-full" style="width: 45%"></div>
            </div>
        </div>

        <!-- Kedaluwarsa Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:border-rose-200 transition-colors">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Hampir Expired</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $obatHampirKedaluwarsa }} Item</h3>
                </div>
            </div>
            <p class="text-[10px] font-bold text-rose-500 uppercase tracking-wider">Masa berlaku < 3 Bulan</p>
        </div>

        <!-- Pelayanan Card -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:border-blue-200 transition-colors">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Resep Hari Ini</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $jumlahResepSelesai }} / {{ $jumlahResepMasuk }}</h3>
                </div>
            </div>
            <div class="flex justify-between items-center text-[10px] font-black text-blue-600 uppercase tracking-widest">
                <span>Efisiensi Layanan</span>
                <span>{{ $jumlahResepMasuk > 0 ? round(($jumlahResepSelesai / $jumlahResepMasuk) * 100) : 0 }}%</span>
            </div>
        </div>
    </div>

    <!-- Grafik & Analitik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100" x-data="chartTrenFarmasi()">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800">Tren Penggunaan Obat</h3>
                    <p class="text-sm text-slate-400 font-medium">Volume distribusi obat harian selama 7 hari terakhir.</p>
                </div>
                <span class="px-3 py-1.5 bg-teal-50 text-teal-600 rounded-lg text-xs font-bold uppercase tracking-wider border border-teal-100">Live Data</span>
            </div>
            <div id="chart-tren-farmasi" class="w-full h-[350px]"></div>
        </div>

        <!-- Side List: Monitoring Stok -->
        <div class="space-y-6">
            <!-- Top Obat -->
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    Paling Banyak Keluar
                </h3>
                <div class="space-y-5">
                    @forelse($obatPopuler as $item)
                    <div class="group">
                        <div class="flex justify-between items-end mb-2">
                            <div>
                                <p class="text-sm font-bold text-slate-700">{{ $item->nama_obat }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $item->satuan }}</p>
                            </div>
                            <span class="text-sm font-black text-slate-800 bg-slate-50 px-2 py-1 rounded shadow-sm border border-slate-100">{{ number_format($item->total_keluar) }}</span>
                        </div>
                        <div class="w-full bg-slate-50 h-1.5 rounded-full overflow-hidden border border-slate-100">
                            <div class="bg-teal-500 h-full rounded-full transition-all duration-1000 group-hover:bg-teal-600" style="width: {{ ($item->total_keluar / ($obatPopuler->max('total_keluar') ?: 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 py-10 font-medium">Belum ada data distribusi obat.</p>
                    @endforelse
                </div>
            </div>

            <!-- Monitoring Expired -->
            <div class="bg-rose-50 p-6 rounded-[2rem] border border-rose-100 relative overflow-hidden group">
                <h3 class="text-lg font-black text-rose-800 mb-6 flex items-center gap-2 relative z-10">
                    <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Awas! Segera Expired
                </h3>
                <div class="space-y-4 relative z-10">
                    @forelse($obatKedaluwarsaSegera as $obat)
                    <div class="flex items-center justify-between p-3 bg-white/60 backdrop-blur-sm rounded-2xl border border-rose-100 hover:bg-white transition-all group/item">
                        <div>
                            <p class="text-xs font-bold text-slate-800">{{ $obat->nama_obat }}</p>
                            <p class="text-[10px] font-black text-rose-600 uppercase mt-0.5">{{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->translatedFormat('d M Y') }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 font-black text-[10px]">
                            {{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->diffInMonths(now()) }} bln
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-rose-400 py-10 font-medium">Semua stok obat aman (Jangka Panjang).</p>
                    @endforelse
                </div>
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-rose-200/30 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            </div>
        </div>
    </div>

    <!-- Rincian Kategori & Daftar Obat Kritis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kategori Distribution -->
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
            <h3 class="text-xl font-black text-slate-800 mb-8">Distribusi Kategori Obat</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($statistikKategori as $kat)
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:bg-teal-50 hover:border-teal-100 transition-all group">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-teal-600 transition-colors">{{ $kat->kategori }}</p>
                    <div class="flex items-end justify-between">
                        <span class="text-2xl font-black text-slate-800">{{ $kat->total }}</span>
                        <span class="text-[10px] font-bold text-slate-400">Items</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Stok Kritis Table -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden flex flex-col">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-xl font-black text-slate-800">Alert: Stok Kritis & Kosong</h3>
                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-wider">Perlu Re-Stock Segera</span>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left">
                    <thead class="text-[10px] text-slate-400 uppercase font-black tracking-widest bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-4">Nama Obat</th>
                            <th class="px-8 py-4">Sisa Stok</th>
                            <th class="px-8 py-4">Min. Stok</th>
                            <th class="px-8 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @php 
                            $obatKritis = \App\Models\Obat::whereColumn('stok', '<=', 'min_stok')->orderBy('stok', 'asc')->take(5)->get();
                        @endphp
                        @forelse($obatKritis as $o)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-8 py-4 whitespace-nowrap">
                                <div class="text-sm font-black text-slate-800">{{ $o->nama_obat }}</div>
                                <div class="text-[10px] text-slate-400 uppercase font-bold">{{ $o->kategori }}</div>
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap">
                                <span class="text-sm font-black {{ $o->stok <= 0 ? 'text-rose-600' : 'text-amber-600' }}">{{ $o->stok }} {{ $o->satuan }}</span>
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-sm text-slate-500 font-bold">
                                {{ $o->min_stok }}
                            </td>
                            <td class="px-8 py-4 whitespace-nowrap text-center">
                                @if($o->stok <= 0)
                                    <span class="px-3 py-1.5 rounded-xl bg-rose-100 text-rose-700 text-[10px] font-black uppercase tracking-wider">KOSONG</span>
                                @else
                                    <span class="px-3 py-1.5 rounded-xl bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-wider">KRITIS</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-8 py-12 text-center text-slate-400 font-medium">Data stok aman sepenuhnya.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function chartTrenFarmasi() {
            return {
                init() {
                    const data = @json($dataTren);
                    const options = {
                        series: [{
                            name: 'Item Keluar',
                            data: data.values
                        }],
                        chart: {
                            type: 'area',
                            height: 350,
                            toolbar: { show: false },
                            fontFamily: 'Plus Jakarta Sans, sans-serif'
                        },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        colors: ['#0d9488'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.45,
                                opacityTo: 0.05,
                                stops: [20, 100]
                            }
                        },
                        xaxis: {
                            categories: data.labels,
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: { style: { colors: '#94a3b8', fontWeight: 700 } }
                        },
                        yaxis: {
                            labels: { 
                                style: { colors: '#94a3b8', fontWeight: 700 },
                                formatter: function (val) { return val.toFixed(0) + " Unit" }
                            }
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            strokeDashArray: 4,
                            xaxis: { lines: { show: true } }
                        },
                        tooltip: {
                            theme: 'dark',
                            x: { show: false },
                            y: { formatter: function (val) { return val + " Unit Terpakai" } }
                        }
                    };
                    new ApexCharts(document.querySelector("#chart-tren-farmasi"), options).render();
                }
            }
        }
    </script>
    @endpush
</div>
