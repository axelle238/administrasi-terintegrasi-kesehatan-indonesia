<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    
    <!-- Filter & Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Control Card -->
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-black text-slate-800 mb-1">Jurnal Kehadiran</h2>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Rekapitulasi Bulanan</p>
            </div>
            
            <div class="flex items-center justify-between bg-slate-50 p-2 rounded-2xl border border-slate-200 mt-6">
                <button wire:click="previousMonth" class="p-2 hover:bg-white hover:shadow-sm rounded-xl transition text-slate-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <span class="font-black text-slate-700 text-lg">
                    {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
                </span>
                <button wire:click="nextMonth" class="p-2 hover:bg-white hover:shadow-sm rounded-xl transition text-slate-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="lg:col-span-3 grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-emerald-50 p-6 rounded-[2.5rem] border border-emerald-100">
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">Hadir Tepat Waktu</p>
                <h3 class="text-4xl font-black text-emerald-800">{{ $stats['Hadir'] }} <span class="text-sm font-medium text-emerald-600">Hari</span></h3>
            </div>
            <div class="bg-amber-50 p-6 rounded-[2.5rem] border border-amber-100">
                <p class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-2">Dinas Luar</p>
                <h3 class="text-4xl font-black text-amber-800">{{ $stats['Dinas Luar'] }} <span class="text-sm font-medium text-amber-600">Hari</span></h3>
            </div>
            <div class="bg-rose-50 p-6 rounded-[2.5rem] border border-rose-100">
                <p class="text-xs font-bold text-rose-600 uppercase tracking-widest mb-2">Terlambat</p>
                <h3 class="text-4xl font-black text-rose-800">{{ $stats['Terlambat'] }} <span class="text-sm font-medium text-rose-600">Hari</span></h3>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-white p-8 rounded-[3rem] shadow-xl border border-slate-100">
        <!-- Days Header -->
        <div class="grid grid-cols-7 mb-4">
            @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                <div class="text-center">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ $day }}</span>
                </div>
            @endforeach
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-7 gap-2">
            @foreach($daysInMonth as $day)
                @if($day)
                    @php
                        $presensi = $attendanceData[$day] ?? null;
                        $isToday = $day == now()->day && $bulan == now()->month && $tahun == now()->year;
                        
                        $bgClass = 'bg-slate-50 border-slate-100'; // Default Empty
                        $textClass = 'text-slate-700';
                        
                        if ($presensi) {
                            if ($presensi->status_kehadiran == 'Hadir') {
                                $bgClass = 'bg-emerald-50 border-emerald-200 hover:bg-emerald-100';
                                $textClass = 'text-emerald-800';
                            } elseif ($presensi->status_kehadiran == 'Terlambat') {
                                $bgClass = 'bg-rose-50 border-rose-200 hover:bg-rose-100';
                                $textClass = 'text-rose-800';
                            } elseif (str_contains($presensi->status_kehadiran, 'Dinas') || str_contains($presensi->jenis_presensi, 'DL')) {
                                $bgClass = 'bg-amber-50 border-amber-200 hover:bg-amber-100';
                                $textClass = 'text-amber-800';
                            }
                        } elseif ($isToday) {
                            $bgClass = 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-500/30';
                            $textClass = 'text-white';
                        }
                    @endphp

                    <div class="relative group h-24 md:h-32 p-3 rounded-3xl border-2 {{ $bgClass }} transition-all flex flex-col justify-between overflow-hidden cursor-pointer">
                        <span class="font-black text-lg {{ $textClass }}">{{ $day }}</span>
                        
                        @if($presensi)
                            <div class="text-[10px] md:text-xs font-bold {{ $textClass }} mt-1">
                                <div>IN: {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}</div>
                                @if($presensi->jam_keluar)
                                    <div>OUT: {{ \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i') }}</div>
                                @endif
                            </div>
                            
                            <!-- Status Badge (Desktop Only) -->
                            <div class="hidden md:block mt-auto">
                                <span class="px-2 py-0.5 rounded-md bg-white/50 backdrop-blur-sm text-[9px] font-black uppercase tracking-wider {{ $textClass }}">
                                    {{ $presensi->jenis_presensi }}
                                </span>
                            </div>
                        @endif

                        @if($isToday)
                            <div class="absolute top-3 right-3 w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @endif
                    </div>
                @else
                    <!-- Empty Cell -->
                    <div class="h-24 md:h-32"></div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Legend -->
    <div class="flex flex-wrap gap-4 justify-center text-xs font-bold text-slate-500">
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Hadir Tepat Waktu
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-rose-500"></span> Terlambat
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-amber-500"></span> Dinas Luar
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-blue-600"></span> Hari Ini
        </div>
    </div>
</div>
