<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate-fade-in-up">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight font-[Outfit]">
                Selamat Datang, <span class="text-blue-600">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-slate-500 text-sm mt-1">Berikut adalah ringkasan aktivitas dan status fasilitas kesehatan hari ini.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('antrean.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Antrean Baru
            </a>
            <a href="{{ route('pasien.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white text-slate-700 border border-slate-200 text-sm font-bold rounded-xl hover:bg-slate-50 transition gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                Pasien Baru
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Antrean -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Antrean Hari Ini</p>
                        <h3 class="text-2xl font-extrabold text-slate-800">{{ $antreanHariIni }}</h3>
                    </div>
                </div>
                <div class="flex items-center text-xs text-blue-600 font-bold bg-blue-50 w-fit px-2 py-1 rounded-lg">
                    <span>Realtime Update</span>
                </div>
            </div>
        </div>

        <!-- Pasien -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 w-24 h-24 bg-cyan-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-cyan-100 text-cyan-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pasien</p>
                        <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($totalPasien) }}</h3>
                    </div>
                </div>
                <div class="flex items-center text-xs text-cyan-600 font-bold bg-cyan-50 w-fit px-2 py-1 rounded-lg">
                    <span>Database Terdaftar</span>
                </div>
            </div>
        </div>

        <!-- Stok Obat (Warning if low) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 w-24 h-24 {{ $obatMenipis > 0 ? 'bg-red-50' : 'bg-emerald-50' }} rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 {{ $obatMenipis > 0 ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }} rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Obat Menipis</p>
                        <h3 class="text-2xl font-extrabold text-slate-800 {{ $obatMenipis > 0 ? 'text-red-600' : '' }}">{{ $obatMenipis }}</h3>
                    </div>
                </div>
                @if($obatMenipis > 0)
                    <a href="{{ route('obat.index') }}" class="flex items-center text-xs text-red-600 font-bold bg-red-50 w-fit px-2 py-1 rounded-lg hover:bg-red-100 transition">
                        <span>Periksa Inventaris &rarr;</span>
                    </a>
                @else
                    <div class="flex items-center text-xs text-emerald-600 font-bold bg-emerald-50 w-fit px-2 py-1 rounded-lg">
                        <span>Stok Aman</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Surat Masuk -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 w-24 h-24 bg-orange-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Surat Masuk</p>
                        <h3 class="text-2xl font-extrabold text-slate-800">{{ $suratMasuk }}</h3>
                    </div>
                </div>
                <a href="{{ route('surat.index') }}" class="flex items-center text-xs text-orange-600 font-bold bg-orange-50 w-fit px-2 py-1 rounded-lg hover:bg-orange-100 transition">
                    <span>Lihat Surat &rarr;</span>
                </a>
            </div>
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
                     <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                     <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Sistem Peringatan Dini</h3>
                </div>
                
                <div class="space-y-3">
                    <!-- STR/SIP Expired -->
                    <div class="flex justify-between items-center p-3 rounded-xl {{ ($strExpired + $sipExpired) > 0 ? 'bg-red-50 border border-red-100' : 'bg-slate-50' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ ($strExpired + $sipExpired) > 0 ? 'bg-white text-red-500' : 'bg-white text-slate-400' }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 2.5-1 2.5s-1-1.617-1-2.5V5a2 2 0 012-2h2a2 2 0 012 2v1c0 .883-.393 2.5-1 2.5s-1-1.617-1-2.5z" /></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Izin Pegawai (STR/SIP)</span>
                        </div>
                        <span class="font-bold {{ ($strExpired + $sipExpired) > 0 ? 'text-red-600' : 'text-slate-500' }}">{{ $strExpired + $sipExpired }}</span>
                    </div>

                    <!-- Obat Expired -->
                    <div class="flex justify-between items-center p-3 rounded-xl {{ $obatExpired > 0 ? 'bg-red-50 border border-red-100' : 'bg-slate-50' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $obatExpired > 0 ? 'bg-white text-red-500' : 'bg-white text-slate-400' }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Obat Kedaluwarsa</span>
                        </div>
                        <span class="font-bold {{ $obatExpired > 0 ? 'text-red-600' : 'text-slate-500' }}">{{ $obatExpired }}</span>
                    </div>

                    <!-- Kamar Penuh -->
                    <div class="flex justify-between items-center p-3 rounded-xl bg-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-white text-blue-500">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-700">Kamar Terisi</span>
                        </div>
                        <span class="font-bold text-slate-700">{{ $pasienRawatInap }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>