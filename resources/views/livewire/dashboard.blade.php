<div class="space-y-8">
    
    <!-- 
      BAGIAN: Header Selamat Datang 
      Menggunakan gaya Glassmorphism dengan latar belakang mesh gradient dinamis.
      Menampilkan status sistem dan akses cepat (Quick Actions).
    -->
    <div class="relative overflow-hidden rounded-3xl bg-white shadow-xl shadow-blue-900/5 border border-white">
        <!-- Elemen Latar Belakang -->
        <div class="absolute top-0 right-0 -mt-32 -mr-32 h-96 w-96 rounded-full bg-blue-400/20 blur-[80px]"></div>
        <div class="absolute bottom-0 left-0 -mb-32 -ml-32 h-96 w-96 rounded-full bg-cyan-400/20 blur-[80px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-full w-full bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-40 mix-blend-overlay"></div>

        <div class="relative z-10 px-8 py-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <!-- Indikator Status Sistem -->
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-extrabold uppercase tracking-wider flex items-center gap-2 shadow-sm">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        Sistem Beroperasi Optimal
                    </span>
                </div>
                
                <h2 class="text-4xl font-extrabold text-slate-800 tracking-tight mb-2 font-[Outfit]">
                    Selamat Datang Kembali, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">{{ Auth::user()->name }}</span>
                </h2>
                <p class="text-slate-500 text-lg max-w-2xl font-medium">
                    Berikut adalah ringkasan kinerja operasional fasilitas kesehatan hari ini. Seluruh modul berfungsi dengan baik.
                </p>
                
                <!-- Tombol Aksi Cepat (Quick Actions) -->
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('pasien.index') }}" class="flex items-center gap-3 px-5 py-2.5 rounded-xl bg-white shadow-md shadow-slate-200/50 hover:shadow-lg hover:shadow-blue-500/10 transition-all border border-slate-100 group">
                        <div class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700">Registrasi Pasien Baru</span>
                    </a>
                    <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-5 py-2.5 rounded-xl bg-white shadow-md shadow-slate-200/50 hover:shadow-lg hover:shadow-cyan-500/10 transition-all border border-slate-100 group">
                        <div class="p-2 bg-cyan-50 rounded-lg text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700">Susun Laporan Operasional</span>
                    </a>
                </div>
            </div>
            
            <!-- Widget Waktu & Lokasi -->
            <div class="hidden lg:block relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-400 rounded-3xl blur opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-white/60 backdrop-blur-xl border border-white/50 rounded-3xl p-6 min-w-[260px] shadow-lg shadow-blue-500/5">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500 uppercase font-bold tracking-wider">Zona Waktu</span>
                            <span class="text-xs text-blue-600 font-bold">WIB (Jakarta)</span>
                        </div>
                        <div class="p-2 bg-amber-100 text-amber-500 rounded-full">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                    </div>
                    <div class="text-5xl font-[Outfit] font-extrabold text-slate-800 tracking-tighter">
                        {{ \Carbon\Carbon::now()->format('H:i') }}
                    </div>
                    <div class="mt-2 text-sm font-medium text-slate-500">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 
      BAGIAN: Kartu Statistik Utama (Key Metrics)
      Menampilkan data real-time: Total Pasien, Antrean, Okupansi Bed, dan Peringatan Stok.
    -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Kartu 1: Total Pasien -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity group-hover:scale-110 duration-500">
                <svg class="w-24 h-24 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pasien</span>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ number_format($totalPasien) }}</h3>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">+2.5%</span>
                    <span class="text-xs text-slate-400 font-medium">pertumbuhan bulan ini</span>
                </div>
            </div>
        </div>

        <!-- Kartu 2: Antrean -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity group-hover:scale-110 duration-500">
                <svg class="w-24 h-24 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 rounded-2xl bg-gradient-to-br from-cyan-400 to-cyan-600 text-white shadow-lg shadow-cyan-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Antrean Hari Ini</span>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ number_format($antreanHariIni) }}</h3>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-full">Langsung</span>
                    <span class="text-xs text-slate-400 font-medium">pasien dalam antrean</span>
                </div>
            </div>
        </div>

        <!-- Kartu 3: Rawat Inap (BOR) -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity group-hover:scale-110 duration-500">
                <svg class="w-24 h-24 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-600 text-white shadow-lg shadow-purple-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Okupansi Bed</span>
                </div>
                <div class="flex justify-between items-end mb-2">
                    <h3 class="text-3xl font-extrabold text-slate-800">{{ $pasienRawatInap }}</h3>
                    <span class="text-xs font-bold text-slate-500 mb-1">/ {{ $pasienRawatInap + $kamarTersedia }} Total</span>
                </div>
                <!-- Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-2">
                    @php
                        $totalBed = $pasienRawatInap + $kamarTersedia;
                        $bor = $totalBed > 0 ? ($pasienRawatInap / $totalBed) * 100 : 0;
                    @endphp
                    <div class="bg-purple-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $bor }}%"></div>
                </div>
                <p class="text-xs text-slate-400 font-medium mt-2">{{ $kamarTersedia }} bed tersedia saat ini</p>
            </div>
        </div>

        <!-- Kartu 4: Stok Menipis -->
        <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity group-hover:scale-110 duration-500">
                <svg class="w-24 h-24 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 text-white shadow-lg shadow-rose-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Stok Kritis</span>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800 mb-1">{{ $obatMenipis }}</h3>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">Perhatian</span>
                    <span class="text-xs text-slate-400 font-medium">item perlu pengadaan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 
      BAGIAN: Grafik & Tabel Data 
      Menampilkan visualisasi data kunjungan dan pendapatan mingguan.
    -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Grafik Kunjungan -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col justify-between">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Statistik Kunjungan Pasien</h3>
                    <p class="text-sm text-slate-400 font-medium mt-1">Tren data selama 6 bulan terakhir</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 text-xs font-bold rounded-xl bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100 transition-colors">Visualisasi Grafik</button>
                    <button class="px-4 py-2 text-xs font-bold rounded-xl bg-white text-slate-400 hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all">Data Tabel</button>
                </div>
            </div>

            <!-- Area Grafik -->
            <div class="relative h-72 w-full" x-data="{ tooltip: null, tooltipX: 0, tooltipY: 0 }">
                @php
                    $maxVisits = max($dataGrafik['data']) > 0 ? max($dataGrafik['data']) : 10;
                    $points = [];
                    foreach($dataGrafik['data'] as $index => $value) {
                        $x = ($index / (count($dataGrafik['data']) - 1)) * 100;
                        $y = 100 - (($value / $maxVisits) * 80);
                        $points[] = "$x,$y";
                    }
                    $polylinePoints = implode(' ', $points);
                    $fillPoints = "0,100 " . $polylinePoints . " 100,100";
                @endphp
                
                <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full overflow-visible group">
                    <!-- Garis Grid Putus-putus -->
                    <line x1="0" y1="20" x2="100" y2="20" stroke="#f1f5f9" stroke-width="0.5" stroke-dasharray="2 2" />
                    <line x1="0" y1="40" x2="100" y2="40" stroke="#f1f5f9" stroke-width="0.5" stroke-dasharray="2 2" />
                    <line x1="0" y1="60" x2="100" y2="60" stroke="#f1f5f9" stroke-width="0.5" stroke-dasharray="2 2" />
                    <line x1="0" y1="80" x2="100" y2="80" stroke="#f1f5f9" stroke-width="0.5" stroke-dasharray="2 2" />
                    
                    <defs>
                        <linearGradient id="blueGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:0.2" />
                            <stop offset="100%" style="stop-color:#3b82f6;stop-opacity:0" />
                        </linearGradient>
                    </defs>

                    <!-- Isi Gradien -->
                    <polygon points="{{ $fillPoints }}" fill="url(#blueGradient)" />

                    <!-- Garis Utama -->
                    <polyline fill="none" stroke="#3b82f6" stroke-width="1.5" points="{{ $polylinePoints }}" vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" class="drop-shadow-sm" />

                    <!-- Titik Interaktif -->
                    @foreach($dataGrafik['data'] as $index => $value)
                        @php
                            $x = ($index / (count($dataGrafik['data']) - 1)) * 100;
                            $y = 100 - (($value / $maxVisits) * 80);
                        @endphp
                        <g class="group/point cursor-pointer">
                            <circle cx="{{ $x }}" cy="{{ $y }}" r="0" class="fill-white stroke-blue-500 stroke-[3] transition-all duration-300 group-hover/point:r-2 shadow-sm" />
                            <!-- Area hit tidak terlihat untuk UX lebih baik -->
                            <rect x="{{ $x - 5 }}" y="0" width="10" height="100" fill="transparent" 
                                  @mouseenter="tooltip = '{{ $value }} Pasien'; tooltipX = $event.clientX; tooltipY = $event.clientY" 
                                  @mouseleave="tooltip = null" />
                        </g>
                    @endforeach
                </svg>

                <!-- Label Sumbu X -->
                <div class="flex justify-between mt-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    @foreach($dataGrafik['labels'] as $label)
                        <span>{{ $label }}</span>
                    @endforeach
                </div>

                <!-- Tooltip -->
                <div x-show="tooltip" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="fixed z-50 px-4 py-2 text-xs font-bold text-white bg-slate-800 rounded-lg shadow-xl pointer-events-none transform -translate-x-1/2 -translate-y-full"
                     :style="`top: ${tooltipY - 10}px; left: ${tooltipX}px`">
                    <span x-text="tooltip"></span>
                </div>
            </div>
        </div>

        <!-- Kartu Pendapatan -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-8 shadow-[0_10px_40px_-10px_rgba(16,185,129,0.3)] text-white flex flex-col relative overflow-hidden">
            <!-- Dekorasi Latar Belakang -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-64 w-64 bg-black/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-1">Pendapatan Mingguan</h3>
                    <p class="text-emerald-100 text-sm">Ringkasan finansial 7 hari terakhir</p>
                </div>

                <!-- Visualisasi Bar Chart Sederhana -->
                <div class="flex items-end gap-2 h-40 my-6">
                    @php
                        $maxRev = max($dataPendapatan['data']) > 0 ? max($dataPendapatan['data']) : 100000;
                    @endphp
                    @foreach($dataPendapatan['data'] as $index => $value)
                        @php $h = max(10, ($value / $maxRev) * 100); @endphp
                        <div class="flex-1 bg-white/20 rounded-t-lg relative group overflow-hidden hover:bg-white/30 transition-colors cursor-pointer" title="Rp {{ number_format($value) }}">
                            <div class="absolute bottom-0 w-full bg-white transition-all duration-1000 ease-out" style="height: {{ $h }}%"></div>
                        </div>
                    @endforeach
                </div>

                <div>
                    <div class="flex justify-between items-center border-b border-white/20 pb-4 mb-4">
                        <span class="text-emerald-100 font-medium">Total Minggu Ini</span>
                        <span class="text-2xl font-bold">Rp {{ number_format(array_sum($dataPendapatan['data'])) }}</span>
                    </div>
                    <button class="w-full py-3 bg-white text-emerald-600 font-bold rounded-xl shadow-lg hover:bg-emerald-50 transition-colors">
                        Lihat Laporan Keuangan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 
      BAGIAN: Sistem Peringatan Dini (Early Warning System)
      Menampilkan peringatan kritis untuk manajemen inventaris dan kepatuhan.
    -->
    <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100">
        <div class="flex items-center gap-3 mb-6">
            <div class="h-3 w-3 rounded-full bg-red-500 animate-pulse ring-4 ring-red-100"></div>
            <h3 class="text-xl font-bold text-slate-800">Sistem Peringatan Dini (EWS)</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Peringatan 1: Obat -->
            <div class="flex p-4 rounded-2xl bg-red-50 border border-red-100 hover:shadow-md hover:shadow-red-500/5 transition-all cursor-pointer group">
                <div class="mr-4">
                    <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center text-red-500 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Obat Kedaluwarsa</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed"><strong class="text-red-600">{{ $obatExpired }} batch</strong> obat mendekati tanggal kedaluwarsa. Segera lakukan retur atau promosi.</p>
                </div>
            </div>

            <!-- Peringatan 2: SIP Pegawai -->
            <div class="flex p-4 rounded-2xl bg-amber-50 border border-amber-100 hover:shadow-md hover:shadow-amber-500/5 transition-all cursor-pointer group">
                <div class="mr-4">
                    <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center text-amber-500 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 1.627-1.017 2.192C8.327 8.82 7.7 9 7 9s-1.327-.18-1.983-.808A2.992 2.992 0 014 6h16c0 .883-.393 1.627-1.017 2.192C18.327 8.82 17.7 9 17 9c-.7 0-1.327-.18-1.983-.808A2.992 2.992 0 0114 6" /></svg>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Masa Berlaku SIP</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed"><strong class="text-amber-600">{{ $sipExpired }} pegawai</strong> memerlukan perpanjangan Surat Izin Praktik (SIP) dalam waktu dekat.</p>
                </div>
            </div>

            <!-- Peringatan 3: Surat Masuk -->
            <div class="flex p-4 rounded-2xl bg-blue-50 border border-blue-100 hover:shadow-md hover:shadow-blue-500/5 transition-all cursor-pointer group">
                <div class="mr-4">
                    <div class="h-10 w-10 rounded-full bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Surat Masuk</h4>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed"><strong class="text-blue-600">{{ $suratMasuk }} surat baru</strong> belum didisposisikan. Cek kotak masuk administrasi.</p>
                </div>
            </div>
        </div>
    </div>

</div>
