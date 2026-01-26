<div class="space-y-8">
    
    <!-- Welcome Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-teal-600 to-emerald-600 p-8 shadow-xl dark:shadow-teal-900/20">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-64 w-64 rounded-full bg-black/10 blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-white tracking-tight">
                    Selamat Datang, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="mt-2 text-teal-50 text-lg max-w-2xl">
                    Sistem Informasi Pusat Jaga (SIPUJAGA) siap membantu operasional pelayanan kesehatan Anda hari ini.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-white/20 backdrop-blur-sm text-white text-sm font-medium border border-white/10">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        {{ \Carbon\Carbon::now()->format('d M Y') }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-white/20 backdrop-blur-sm text-white text-sm font-medium border border-white/10">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Shift Pagi
                    </span>
                </div>
            </div>
            
            <!-- Weather / Quick Status Widget -->
            <div class="hidden lg:block">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 flex items-center gap-4 min-w-[200px]">
                    <div class="p-3 bg-yellow-400/20 rounded-xl text-yellow-300">
                         <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">28°C</div>
                        <div class="text-teal-100 text-xs uppercase tracking-wider">Cerah Berawan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Card 1: Pasien -->
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
            <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-blue-50 dark:bg-blue-900/20 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pasien</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalPasien) }}</h3>
                    <span class="text-sm font-medium text-green-500 flex items-center">
                        <svg class="w-3 h-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        +2.5%
                    </span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Terdaftar dalam database</p>
            </div>
        </div>

        <!-- Card 2: Antrean -->
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
            <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-teal-50 dark:bg-teal-900/20 group-hover:bg-teal-100 dark:group-hover:bg-teal-900/40 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Antrean Hari Ini</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($antreanHariIni) }}</h3>
                    <span class="text-sm font-medium text-gray-400">org</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Pasien menunggu layanan</p>
            </div>
        </div>

        <!-- Card 3: Rawat Inap -->
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
            <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-purple-50 dark:bg-purple-900/20 group-hover:bg-purple-100 dark:group-hover:bg-purple-900/40 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">BOR Rawat Inap</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pasienRawatInap }}</h3>
                    <span class="text-xs text-gray-500">/ {{ $pasienRawatInap + $kamarTersedia }} Bed</span>
                </div>
                
                <!-- Simple Progress Bar -->
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-3">
                    @php
                        $totalBed = $pasienRawatInap + $kamarTersedia;
                        $borPercentage = $totalBed > 0 ? ($pasienRawatInap / $totalBed) * 100 : 0;
                    @endphp
                    <div class="bg-purple-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $borPercentage }}%"></div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $kamarTersedia }} Bed Tersedia</p>
            </div>
        </div>

        <!-- Card 4: Farmasi Warning -->
        <div class="group relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700">
            <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-red-50 dark:bg-red-900/20 group-hover:bg-red-100 dark:group-hover:bg-red-900/40 transition-colors"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Peringatan Stok</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $obatMenipis }}</h3>
                    <span class="text-sm font-medium text-red-500">Item</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Obat Stok Menipis</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Visitor Chart (Line) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Trend Kunjungan Pasien</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">6 Bulan Terakhir</p>
                </div>
                <div class="p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                </div>
            </div>

            <div class="relative h-64 w-full" x-data="{ tooltip: null, tooltipX: 0, tooltipY: 0 }">
                <!-- CSS/SVG Chart Implementation -->
                @php
                    $maxVisits = max($chartData['data']) > 0 ? max($chartData['data']) : 10;
                    $points = [];
                    foreach($chartData['data'] as $index => $value) {
                        $x = ($index / (count($chartData['data']) - 1)) * 100; // Percentage width
                        $y = 100 - (($value / $maxVisits) * 80); // Inverted height percentage (leave 20% buffer)
                        $points[] = "$x,$y";
                    }
                    $polylinePoints = implode(' ', $points);
                @endphp
                
                <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full overflow-visible">
                    <!-- Grid Lines -->
                    <line x1="0" y1="20" x2="100" y2="20" stroke="currentColor" class="text-gray-100 dark:text-gray-700" stroke-width="0.5" stroke-dasharray="2 2" />
                    <line x1="0" y1="40" x2="100" y2="40" stroke="currentColor" class="text-gray-100 dark:text-gray-700" stroke-width="0.5" stroke-dasharray="2 2" />
                    <line x1="0" y1="60" x2="100" y2="60" stroke="currentColor" class="text-gray-100 dark:text-gray-700" stroke-width="0.5" stroke-dasharray="2 2" />
                    <line x1="0" y1="80" x2="100" y2="80" stroke="currentColor" class="text-gray-100 dark:text-gray-700" stroke-width="0.5" stroke-dasharray="2 2" />
                    
                    <!-- Line -->
                    <polyline fill="none" stroke="currentColor" class="text-teal-500" stroke-width="2" points="{{ $polylinePoints }}" vector-effect="non-scaling-stroke" />
                    
                    <!-- Area (Optional, tricky with simple polyline, skipping for cleanliness) -->

                    <!-- Data Points -->
                    @foreach($chartData['data'] as $index => $value)
                        @php
                            $x = ($index / (count($chartData['data']) - 1)) * 100;
                            $y = 100 - (($value / $maxVisits) * 80);
                        @endphp
                        <circle cx="{{ $x }}" cy="{{ $y }}" r="1.5" class="text-white fill-current stroke-teal-500" stroke-width="0.5" />
                        
                        <!-- Tooltip Trigger Area -->
                        <rect x="{{ $x - 5 }}" y="0" width="10" height="100" fill="transparent" 
                              @mouseenter="tooltip = '{{ $value }}'; tooltipX = $event.clientX; tooltipY = $event.clientY" 
                              @mouseleave="tooltip = null" class="cursor-pointer" />
                    @endforeach
                </svg>

                <!-- X Axis Labels -->
                <div class="flex justify-between mt-2 text-[10px] text-gray-400 dark:text-gray-500 font-mono uppercase">
                    @foreach($chartData['labels'] as $label)
                        <span>{{ $label }}</span>
                    @endforeach
                </div>

                <!-- Simple Tooltip -->
                <div x-show="tooltip" 
                     x-transition 
                     class="fixed z-50 px-2 py-1 text-xs font-bold text-white bg-gray-900 rounded shadow-lg pointer-events-none"
                     :style="`top: ${tooltipY - 40}px; left: ${tooltipX - 20}px`">
                    <span x-text="tooltip"></span> Kunjungan
                </div>
            </div>
        </div>

        <!-- Revenue Chart (Bar) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Pendapatan Minggu Ini</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">7 Hari Terakhir</p>
                </div>
                <div class="p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>

            <div class="h-64 flex items-end justify-between gap-2">
                @php
                    $maxRev = max($revenueData['data']) > 0 ? max($revenueData['data']) : 100000;
                @endphp
                
                @foreach($revenueData['data'] as $index => $value)
                    @php
                        $height = ($value / $maxRev) * 100;
                        $height = $height < 5 ? 5 : $height; // Min height
                    @endphp
                    <div class="w-full flex flex-col items-center gap-2 group">
                        <div class="w-full bg-emerald-100 dark:bg-emerald-900/30 rounded-t-lg relative overflow-hidden group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/50 transition-colors" style="height: {{ $height }}%">
                             <div class="absolute bottom-0 left-0 w-full bg-emerald-500 dark:bg-emerald-600 rounded-t-lg transition-all duration-500 ease-out" style="height: 0%" x-init="setTimeout(() => $el.style.height = '100%', 100 + {{ $index * 100 }})"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-mono truncate w-full text-center">{{ Str::limit($revenueData['labels'][$index], 3) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- EWS & Alerts Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 rounded-2xl p-5 flex items-center gap-4">
            <div class="p-3 bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 rounded-full">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 dark:text-red-100">Obat Expired</h4>
                <p class="text-sm text-gray-500 dark:text-red-200/60">{{ $obatExpired }} batch mendekati kedaluwarsa</p>
            </div>
        </div>

        <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30 rounded-2xl p-5 flex items-center gap-4">
            <div class="p-3 bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 rounded-full">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 1.627-1.017 2.192C8.327 8.82 7.7 9 7 9s-1.327-.18-1.983-.808A2.992 2.992 0 014 6h16c0 .883-.393 1.627-1.017 2.192C18.327 8.82 17.7 9 17 9c-.7 0-1.327-.18-1.983-.808A2.992 2.992 0 0114 6" /></svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 dark:text-amber-100">SIP Pegawai</h4>
                <p class="text-sm text-gray-500 dark:text-amber-200/60">{{ $sipExpired }} pegawai SIP akan habis</p>
            </div>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/30 rounded-2xl p-5 flex items-center gap-4">
            <div class="p-3 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-full">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 dark:text-blue-100">Surat Masuk</h4>
                <p class="text-sm text-gray-500 dark:text-blue-200/60">{{ $suratMasuk }} surat baru belum disposisi</p>
            </div>
        </div>
    </div>
</div>
