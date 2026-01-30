<div class="space-y-8 animate-fade-in">
    <!-- HERO SECTION -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-emerald-900 p-10 shadow-2xl">
        <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-emerald-500/20 to-transparent opacity-50"></div>
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-emerald-500/10 blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em]">UKM Center</span>
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span class="text-emerald-200 text-[10px] font-bold uppercase tracking-widest">Community Health</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight font-display mb-2">Kesehatan Masyarakat</h2>
                <p class="text-emerald-200 max-w-xl font-medium">Monitoring program kesehatan berbasis komunitas, penyuluhan, dan pemberdayaan masyarakat.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Kegiatan Bulan Ini</p>
                    <p class="text-3xl font-bold text-white font-mono">{{ $totalKegiatan }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Partisipan -->
        <div class="group glass p-8 rounded-[2rem] hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
            </div>
            <p class="text-sm font-bold text-slate-500 mb-1">Total Partisipan</p>
            <h3 class="text-4xl font-black text-slate-900 font-display tracking-tight">{{ number_format($totalPeserta) }}</h3>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-emerald-600 bg-emerald-50 w-max px-2 py-1 rounded-lg">
                Orang Bulan Ini
            </div>
        </div>

        <!-- Kegiatan Upcoming -->
        <div class="group glass p-8 rounded-[2rem] hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-blue-50 rounded-2xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            </div>
            <p class="text-sm font-bold text-slate-500 mb-1">Kegiatan Mendatang</p>
            <h3 class="text-4xl font-black text-slate-900 font-display tracking-tight">{{ $kegiatanAkanDatang }}</h3>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-blue-600 bg-blue-50 w-max px-2 py-1 rounded-lg">
                Terjadwal
            </div>
        </div>

        <!-- Pengaduan -->
        <div class="group glass p-8 rounded-[2rem] hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-orange-50 rounded-2xl text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                </div>
            </div>
            <p class="text-sm font-bold text-slate-500 mb-1">Aspirasi Masyarakat</p>
            <h3 class="text-4xl font-black text-slate-900 font-display tracking-tight">{{ $pengaduanBaru }}</h3>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-orange-600 bg-orange-50 w-max px-2 py-1 rounded-lg">
                Perlu Tindak Lanjut
            </div>
        </div>

        <!-- Quick Action -->
        <div class="group bg-indigo-600 p-8 rounded-[2rem] hover:shadow-2xl hover:shadow-indigo-500/20 transition-all duration-500 relative overflow-hidden">
            <div class="absolute right-0 bottom-0 opacity-10">
                <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            </div>
            <h3 class="text-xl font-black text-white font-display mb-4 relative z-10">Buat Laporan Baru</h3>
            <p class="text-indigo-200 text-sm mb-6 relative z-10">Catat kegiatan UKM atau tindak lanjut pengaduan.</p>
            <a href="{{ route('ukm.create') }}" class="relative z-10 inline-flex items-center gap-2 px-4 py-2 bg-white text-indigo-600 rounded-xl font-bold text-sm hover:bg-indigo-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Input Kegiatan
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chart -->
        <div class="lg:col-span-2 glass p-8 rounded-[2.5rem]">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800 font-display">Partisipasi Masyarakat</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Tren Peserta Kegiatan UKM</p>
                </div>
            </div>
            <div id="chart-peserta" class="h-80"></div>
        </div>

        <!-- Upcoming Schedule -->
        <div class="glass p-8 rounded-[2.5rem]">
            <h3 class="text-xl font-black text-slate-800 font-display mb-6">Agenda Terdekat</h3>
            <div class="space-y-6">
                @forelse($upcomingEvents as $event)
                <div class="flex items-start gap-4">
                    <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 shrink-0">
                        <span class="text-xs font-bold uppercase">{{ $event->tanggal_kegiatan ? \Carbon\Carbon::parse($event->tanggal_kegiatan)->format('M') : '-' }}</span>
                        <span class="text-lg font-black">{{ $event->tanggal_kegiatan ? \Carbon\Carbon::parse($event->tanggal_kegiatan)->format('d') : '-' }}</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 line-clamp-1">{{ $event->nama_kegiatan }}</h4>
                        <p class="text-xs text-slate-500 font-medium mt-1">{{ $event->lokasi }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">PJ: {{ $event->penanggung_jawab }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-slate-400 font-medium text-sm">Belum ada agenda mendatang.</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-8 pt-6 border-t border-dashed border-slate-200">
                <a href="{{ route('ukm.index') }}" class="flex items-center justify-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                    Lihat Semua Agenda
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new ApexCharts(document.querySelector("#chart-peserta"), {
                series: [{
                    name: 'Peserta',
                    data: @json($chartData)
                }],
                chart: { height: 320, type: 'bar', toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans' },
                colors: ['#10b981'],
                plotOptions: {
                    bar: { borderRadius: 8, columnWidth: '40%' }
                },
                dataLabels: { enabled: false },
                xaxis: { categories: @json($chartLabels) },
                grid: { borderColor: '#f1f5f9' }
            }).render();
        });
    </script>
</div>
