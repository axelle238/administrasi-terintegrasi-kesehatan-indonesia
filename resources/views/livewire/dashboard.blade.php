<div class="space-y-6">
    <!-- Welcome & Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Welcome Card -->
        <div class="lg:col-span-2 rounded-2xl bg-gradient-to-r from-teal-600 to-emerald-600 p-6 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white opacity-10 rounded-full transform translate-x-1/2 -translate-y-1/2 blur-2xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="mt-2 text-teal-100 max-w-lg">
                        Selamat datang di Dashboard Utama Sistem SATRIA. Berikut adalah ringkasan performa dan statistik operasional fasilitas kesehatan hari ini.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('antrean.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg text-sm font-semibold transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Monitor Antrean
                        </a>
                        <a href="{{ route('pasien.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-teal-700 hover:bg-teal-50 rounded-lg text-sm font-bold shadow-md transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Pasien Baru
                        </a>
                        <button wire:click="clockIn" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg text-sm font-bold shadow-md transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Absen Masuk/Pulang
                        </button>
                    </div>
                </div>
                <div class="hidden md:block">
                     <!-- Abstract Graphic or SVG -->
                     <svg class="w-32 h-32 text-teal-200 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M19.428 15.428a2 2 0 0 0-1.022-.547l-2.384-.477a6 6 0 0 0-3.86.517l-.318.158a6 6 0 0 1-3.86.517L6.05 15.21a2 2 0 0 0-1.806.547M8 4h8l-1 1v5.172a2 2 0 0 0 .586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 0 0 9 10.172V5L8 4Z"/></svg>
                </div>
            </div>
        </div>

        <!-- Clock & Location -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase text-gray-400 dark:text-gray-500 tracking-wider">Waktu Operasional</span>
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                </div>
                <h3 class="text-4xl font-black text-gray-800 dark:text-white" x-data="{ time: new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}), 1000)">
                    <span x-text="time"></span>
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            
            <div class="mt-6 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600 flex items-center gap-3">
                 <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-900 dark:text-gray-200">Puskesmas Jagakarsa</p>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400">Jakarta Selatan, DKI Jakarta</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics (Grid 4) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        <!-- Pasien -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Pasien</p>
                    <h4 class="text-2xl font-black text-gray-800 dark:text-white mt-1 group-hover:text-teal-600 transition-colors">{{ number_format($totalPasien) }}</h4>
                </div>
                <div class="p-2 bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-green-600 dark:text-green-400 font-medium">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                <span>+12% dr bulan lalu</span>
            </div>
        </div>

        <!-- Antrean -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Antrean Hari Ini</p>
                    <h4 class="text-2xl font-black text-gray-800 dark:text-white mt-1 group-hover:text-blue-600 transition-colors">{{ number_format($antreanHariIni) }}</h4>
                </div>
                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <div class="mt-4 w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5">
                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 65%"></div>
            </div>
        </div>

        <!-- Surat -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Surat Masuk</p>
                    <h4 class="text-2xl font-black text-gray-800 dark:text-white mt-1 group-hover:text-purple-600 transition-colors">{{ number_format($suratMasuk) }}</h4>
                </div>
                <div class="p-2 bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
            </div>
             <div class="mt-4 flex items-center text-xs text-gray-500 dark:text-gray-400">
                <span>Perlu disposisi: <strong>3</strong></span>
            </div>
        </div>

        <!-- Kamar -->
        <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Kamar Tersedia</p>
                    <h4 class="text-2xl font-black text-gray-800 dark:text-white mt-1 group-hover:text-orange-600 transition-colors">{{ number_format($kamarTersedia) }}</h4>
                </div>
                <div class="p-2 bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
            </div>
            <div class="mt-4 flex gap-1">
                @for($i=0; $i<5; $i++)
                    <div class="h-1.5 flex-1 rounded-full {{ $i < 3 ? 'bg-orange-500' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Main Analytics Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Charts -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Patient Visits Chart -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Statistik Kunjungan Pasien</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tren kunjungan 6 bulan terakhir</p>
                    </div>
                    <select class="text-xs border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                        <option>6 Bulan Terakhir</option>
                        <option>Tahun Ini</option>
                    </select>
                </div>
                
                <div class="relative h-72">
                    <canvas id="kunjunganChart"></canvas>
                </div>
            </div>

            <!-- Operational Alerts (Warning) -->
            @if($obatMenipis > 0 || $obatExpired > 0)
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-r-xl flex items-start justify-between">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <div>
                        <h4 class="text-sm font-bold text-red-800 dark:text-red-200">Perhatian: Stok Kritis!</h4>
                        <p class="text-xs text-red-700 dark:text-red-300 mt-1">
                            Terdeteksi {{ $obatMenipis }} jenis obat menipis dan {{ $obatExpired }} jenis obat mendekati kedaluwarsa.
                        </p>
                    </div>
                </div>
                <a href="{{ route('obat.index') }}" class="text-xs font-bold bg-white dark:bg-gray-800 text-red-600 px-3 py-1.5 rounded border border-red-100 dark:border-gray-600 shadow-sm hover:bg-red-50">Cek Inventaris</a>
            </div>
            @endif
        </div>

        <!-- Right Column: EWS & Activity -->
        <div class="space-y-6">
            
            <!-- EWS Card -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-4">
                    <div class="p-1.5 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">EWS System</h3>
                </div>
                
                <div class="space-y-4">
                    <!-- STR Expiring -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full {{ $strExpired > 0 ? 'bg-red-500 animate-pulse' : 'bg-green-500' }}"></span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">STR Pegawai Expired</span>
                        </div>
                        <span class="text-sm font-bold {{ $strExpired > 0 ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">{{ $strExpired }}</span>
                    </div>

                    <!-- SIP Expiring -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full {{ $sipExpired > 0 ? 'bg-red-500 animate-pulse' : 'bg-green-500' }}"></span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">SIP Pegawai Expired</span>
                        </div>
                        <span class="text-sm font-bold {{ $sipExpired > 0 ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">{{ $sipExpired }}</span>
                    </div>

                    <!-- Obat ED -->
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full {{ $obatExpired > 0 ? 'bg-orange-500 animate-pulse' : 'bg-green-500' }}"></span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Obat Near ED</span>
                        </div>
                        <span class="text-sm font-bold {{ $obatExpired > 0 ? 'text-orange-600' : 'text-gray-900 dark:text-white' }}">{{ $obatExpired }}</span>
                    </div>
                </div>
            </div>

            <!-- Revenue Trend (Mini) -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-6 rounded-2xl text-white shadow-lg">
                <p class="text-xs text-indigo-200 uppercase font-bold tracking-wider">Pendapatan Minggu Ini</p>
                <h3 class="text-2xl font-black mt-2">Rp {{ number_format(array_sum($revenueData['data']), 0, ',', '.') }}</h3>
                <div class="mt-4 flex items-end gap-1 h-16">
                    @foreach($revenueData['data'] as $val)
                        <div class="flex-1 bg-white/20 rounded-t-sm hover:bg-white/40 transition-colors" style="height: {{ ($val / (max($revenueData['data']) ?: 1)) * 100 }}%"></div>
                    @endforeach
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">System Info</h4>
                <div class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                    <div class="flex justify-between">
                        <span>Version</span>
                        <span class="font-mono">v2.0.0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Framework</span>
                        <span class="font-mono">Laravel 12</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Server Time</span>
                        <span class="font-mono">{{ now()->format('H:i') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        // Safe check for Chart
        if (typeof Chart === 'undefined') return;

        // Kunjungan Chart
        const ctxKunjungan = document.getElementById('kunjunganChart');
        if (ctxKunjungan) {
            new Chart(ctxKunjungan, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Kunjungan Pasien',
                        data: @json($chartData['data']),
                        borderColor: '#0d9488', // teal-600
                        backgroundColor: 'rgba(13, 148, 136, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#0f766e',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            grid: {
                                color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });
        }
    });
</script>