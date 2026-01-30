<div class="space-y-8 animate-fade-in">
    <!-- EXECUTIVE SUMMARY BANNER -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-slate-900 p-10 shadow-2xl">
        <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-indigo-500/20 to-transparent opacity-50"></div>
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-400 text-[10px] font-black uppercase tracking-[0.2em]">Sistem Enterprise v2.0</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-emerald-400 text-[10px] font-bold uppercase tracking-widest">Sistem Online</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight font-display mb-2">Executive Command Center</h2>
                <p class="text-slate-400 max-w-xl font-medium">Selamat datang kembali, <span class="text-white">{{ Auth::user()->name }}</span>. Monitoring real-time seluruh klaster layanan kesehatan terintegrasi hari ini.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Waktu Sistem</p>
                    <p class="text-xl font-bold text-white font-mono">{{ now()->translatedFormat('H:i') }} <span class="text-slate-500 text-xs">WIB</span></p>
                </div>
                <div class="h-12 w-px bg-slate-800"></div>
                <div class="p-4 bg-white/5 rounded-2xl border border-white/5 backdrop-blur-sm">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- KLASTER ILP OVERVIEW -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Antrean Hari Ini -->
        <div class="group glass p-8 rounded-[2rem] hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-indigo-600 transition-colors">Live Update</span>
            </div>
            <p class="text-sm font-bold text-slate-500 mb-1">Total Kunjungan</p>
            <h3 class="text-4xl font-black text-slate-900 font-display tracking-tight">{{ $stats['antrean_total'] ?? 0 }} <span class="text-xs font-bold text-slate-400">Pasien</span></h3>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-emerald-600 bg-emerald-50 w-max px-2 py-1 rounded-lg">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                12% vs Kemarin
            </div>
        </div>

        <!-- Rekam Medis -->
        <div class="group glass p-8 rounded-[2rem] hover:shadow-2xl hover:shadow-cyan-500/10 transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-cyan-50 rounded-2xl text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Diagnosis</span>
            </div>
            <p class="text-sm font-bold text-slate-500 mb-1">RME Selesai</p>
            <h3 class="text-4xl font-black text-slate-900 font-display tracking-tight">{{ $stats['rekam_medis_total'] ?? 0 }} <span class="text-xs font-bold text-slate-400">Berkas</span></h3>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-blue-600 bg-blue-50 w-max px-2 py-1 rounded-lg">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4" /></svg>
                Sinkron SatuSehat
            </div>
        </div>

        <!-- Farmasi -->
        <div class="group glass p-8 rounded-[2rem] hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Inventory</span>
            </div>
            <p class="text-sm font-bold text-slate-500 mb-1">Stok Kritis</p>
            <h3 class="text-4xl font-black text-slate-900 font-display tracking-tight">{{ $stats['obat_kritis_total'] ?? 0 }} <span class="text-xs font-bold text-slate-400">Item</span></h3>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-rose-600 bg-rose-50 w-max px-2 py-1 rounded-lg">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                Segera Reorder
            </div>
        </div>

        <!-- Keuangan -->
        <div class="group glass p-8 rounded-[2rem] hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-500">
            <div class="flex justify-between items-start mb-6">
                <div class="p-3 bg-amber-50 rounded-2xl text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Revenue</span>
            </div>
            <p class="text-sm font-bold text-slate-500 mb-1">Pendapatan Hari Ini</p>
            <h3 class="text-3xl font-black text-slate-900 font-display tracking-tight">Rp{{ number_format(($stats['pendapatan_hari_ini'] ?? 0)/1000, 0) }}k</h3>
            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-amber-600 bg-amber-50 w-max px-2 py-1 rounded-lg">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                Stabil
            </div>
        </div>
    </div>

    <!-- MAIN ANALYTICS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Tren Kunjungan Pasien (ILP Perspective) -->
        <div class="lg:col-span-2 glass p-8 rounded-[2.5rem]">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800 font-display">Analisis Kunjungan Klaster</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Trend Layanan Integrasi Primer</p>
                </div>
                <select class="text-xs font-bold border-none bg-slate-100 rounded-xl px-4 py-2 focus:ring-0">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                </select>
            </div>
            
            <div id="chart-kunjungan" class="h-80"></div>
        </div>

        <!-- Sebaran Klaster ILP (Pie Chart) -->
        <div class="glass p-8 rounded-[2.5rem]">
            <h3 class="text-xl font-black text-slate-800 font-display mb-8">Proporsi Klaster</h3>
            <div id="chart-klaster" class="h-64 flex items-center justify-center"></div>
            
            <div class="mt-8 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-indigo-500"></div>
                        <span class="text-sm font-bold text-slate-600">Ibu & Anak</span>
                    </div>
                    <span class="text-sm font-black text-slate-800">45%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-cyan-500"></div>
                        <span class="text-sm font-bold text-slate-600">Usia Dewasa</span>
                    </div>
                    <span class="text-sm font-black text-slate-800">35%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                        <span class="text-sm font-bold text-slate-600">P2P / Infeksi</span>
                    </div>
                    <span class="text-sm font-black text-slate-800">20%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- REAL-TIME LOG & SECURITY STATUS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="glass p-8 rounded-[2.5rem] overflow-hidden">
            <h3 class="text-xl font-black text-slate-800 font-display mb-6 flex items-center gap-3">
                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Log Aktivitas Sistem
            </h3>
            <div class="space-y-6">
                @foreach($riwayatLog as $log)
                <div class="flex items-start gap-4 relative">
                    <div class="mt-1.5 w-2 h-2 rounded-full bg-indigo-500 shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $log->description }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $log->causer->name ?? 'System' }} • {{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white relative overflow-hidden">
            <div class="absolute right-0 bottom-0 opacity-10">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
            </div>
            <h3 class="text-xl font-black text-white font-display mb-6">Status Keamanan (SOC)</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Ancaman Diblokir</p>
                    <p class="text-2xl font-black text-emerald-400">0</p>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Sesi Aktif</p>
                    <p class="text-2xl font-black text-indigo-400">{{ $stats['user_online_total'] ?? 1 }}</p>
                </div>
            </div>
            <div class="mt-6 p-4 rounded-2xl bg-indigo-500/10 border border-indigo-500/20">
                <p class="text-xs font-bold text-indigo-300 leading-relaxed">Seluruh sistem terproteksi dengan enkripsi AES-256 dan monitoring audit log real-time.</p>
            </div>
        </div>
    </div>

    <!-- CHARTS INITIALIZATION -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart Kunjungan
            new ApexCharts(document.querySelector("#chart-kunjungan"), {
                series: [{
                    name: 'Pasien',
                    data: [31, 40, 28, 51, 42, 109, 100]
                }],
                chart: { height: 320, type: 'area', toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans' },
                colors: ['#6366f1'],
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: { categories: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"] },
                grid: { borderColor: '#f1f5f9' }
            }).render();

            // Chart Klaster
            new ApexCharts(document.querySelector("#chart-klaster"), {
                series: [45, 35, 20],
                chart: { type: 'donut', height: 280, fontFamily: 'Plus Jakarta Sans' },
                labels: ['Ibu & Anak', 'Usia Dewasa', 'P2P'],
                colors: ['#6366f1', '#06b6d4', '#f59e0b'],
                legend: { show: false },
                plotOptions: { pie: { donut: { size: '75%', labels: { show: true, total: { show: true, label: 'Klaster', fontSize: '12px', fontWeight: 'bold' } } } } },
                stroke: { show: false }
            }).render();
        });
    </script>
</div>
