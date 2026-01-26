<div class="space-y-8">
    <!-- Welcome Header & Financial Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in-up">
        <div class="lg:col-span-2 flex flex-col justify-center">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight font-[Outfit]">
                Selamat Pagi, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-slate-500 mt-2 text-lg">Sistem operasional fasilitas kesehatan siap digunakan.</p>
            
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('antrean.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 gap-2 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Antrean Baru
                </a>
                <a href="{{ route('pasien.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-white text-slate-700 border border-slate-200 font-bold rounded-xl hover:bg-slate-50 transition gap-2 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Registrasi Pasien
                </a>
            </div>
        </div>

        <!-- Financial Widget -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:bg-white/20 transition-all"></div>
            <div class="relative z-10">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Pendapatan Hari Ini</p>
                <h3 class="text-3xl font-extrabold tracking-tight">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                
                <div class="mt-4 pt-4 border-t border-white/10 flex justify-between items-end">
                    <div>
                        <p class="text-slate-400 text-[10px] uppercase">Bulan Ini</p>
                        <p class="font-bold text-sm">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-[10px] uppercase text-right">Beban Gaji</p>
                        <p class="font-bold text-sm text-right text-red-300">- Rp {{ number_format($pengeluaranGaji, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Operational Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
        <!-- Antrean -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                </div>
                <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-1 rounded-full">LIVE</span>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-800">{{ $antreanHariIni }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">Antrean Hari Ini</p>
        </div>

        <!-- Pasien Rawat Inap -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <span class="bg-indigo-100 text-indigo-700 text-[10px] font-bold px-2 py-1 rounded-full">{{ $kamarTersedia }} Kosong</span>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-800">{{ $pasienRawatInap }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">Pasien Rawat Inap</p>
        </div>

        <!-- Aset Maintenance -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                @if($asetMaintenance > 0)
                    <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-1 rounded-full animate-pulse">Action Needed</span>
                @endif
            </div>
            <h3 class="text-2xl font-extrabold text-slate-800 {{ $asetMaintenance > 0 ? 'text-red-600' : '' }}">{{ $asetMaintenance }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">Maintenance Aset (7 Hari)</p>
        </div>

        <!-- Stok Obat -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
                @if($obatMenipis > 0)
                    <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-1 rounded-full">Stok Menipis</span>
                @endif
            </div>
            <h3 class="text-2xl font-extrabold text-slate-800 {{ $obatMenipis > 0 ? 'text-amber-600' : '' }}">{{ $obatMenipis }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">Item Perlu Restock</p>
        </div>

        <!-- Pengaduan Masyarakat -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                @if($pengaduanPending > 0)
                    <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-1 rounded-full animate-pulse">{{ $pengaduanPending }} Baru</span>
                @endif
            </div>
            <h3 class="text-2xl font-extrabold text-slate-800">{{ $pengaduanPending + $pengaduanProses }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">Pengaduan Aktif</p>
        </div>
    </div>

    <!-- Charts & EWS Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Chart: Kunjungan -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Statistik Kunjungan</h3>
                    <p class="text-sm text-slate-500">Tren pasien dalam 6 bulan terakhir</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Pasien</span>
                </div>
            </div>
            <div class="relative h-72 w-full" 
                 x-data="{
                    init() {
                        const ctx = this.$refs.canvas.getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: @js($dataGrafik['labels']),
                                datasets: [{
                                    label: 'Jumlah Kunjungan',
                                    data: @js($dataGrafik['data']),
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    fill: true,
                                    pointBackgroundColor: '#ffffff',
                                    pointBorderColor: '#3b82f6',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: '#1e293b',
                                        padding: 12,
                                        cornerRadius: 8,
                                        displayColors: false,
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: { borderDash: [2, 4], color: '#e2e8f0' },
                                        ticks: { font: { family: 'Plus Jakarta Sans' } }
                                    },
                                    x: {
                                        grid: { display: false },
                                        ticks: { font: { family: 'Plus Jakarta Sans' } }
                                    }
                                }
                            }
                        });
                    }
                 }">
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>

        <!-- Side Panel: Pendapatan & EWS -->
        <div class="space-y-6">
            <!-- Mini Chart: Pendapatan -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-slate-800">Pendapatan Minggu Ini</h3>
                    <p class="text-xs text-slate-500">Grafik pemasukan harian</p>
                </div>
                <div class="relative h-40 w-full"
                     x-data="{
                        init() {
                            const ctx = this.$refs.canvas.getContext('2d');
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: @js($dataPendapatan['labels']),
                                    datasets: [{
                                        label: 'Pendapatan (Rp)',
                                        data: @js($dataPendapatan['data']),
                                        backgroundColor: '#10b981',
                                        borderRadius: 4,
                                        barThickness: 12
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: { legend: { display: false } },
                                    scales: {
                                        y: { display: false },
                                        x: { 
                                            grid: { display: false },
                                            ticks: { font: { size: 10 } }
                                        }
                                    }
                                }
                            });
                        }
                     }">
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>

            <!-- EWS (Early Warning System) -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-2 mb-4">
                     <div class="p-1.5 bg-amber-50 rounded-lg text-amber-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                     </div>
                     <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Peringatan Dini (EWS)</h3>
                </div>
                
                <div class="space-y-3">
                    <!-- STR/SIP Expired -->
                    <a href="{{ route('pegawai.index', ['filterStatus' => 'ews_str']) }}" class="flex justify-between items-center p-3 rounded-xl transition hover:bg-slate-50 {{ ($strExpired + $sipExpired) > 0 ? 'bg-red-50 border border-red-100' : 'bg-white border border-slate-100' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ ($strExpired + $sipExpired) > 0 ? 'bg-white text-red-500' : 'bg-slate-100 text-slate-400' }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 2.5-1 2.5s-1-1.617-1-2.5V5a2 2 0 012-2h2a2 2 0 012 2v1c0 .883-.393 2.5-1 2.5s-1-1.617-1-2.5z" /></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Izin Pegawai (STR/SIP)</span>
                        </div>
                        <span class="font-bold {{ ($strExpired + $sipExpired) > 0 ? 'text-red-600' : 'text-slate-500' }}">{{ $strExpired + $sipExpired }}</span>
                    </a>

                    <!-- Obat Expired -->
                    <a href="{{ route('obat.index') }}" class="flex justify-between items-center p-3 rounded-xl transition hover:bg-slate-50 {{ $obatExpired > 0 ? 'bg-red-50 border border-red-100' : 'bg-white border border-slate-100' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $obatExpired > 0 ? 'bg-white text-red-500' : 'bg-slate-100 text-slate-400' }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Obat Kedaluwarsa</span>
                        </div>
                        <span class="font-bold {{ $obatExpired > 0 ? 'text-red-600' : 'text-slate-500' }}">{{ $obatExpired }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>