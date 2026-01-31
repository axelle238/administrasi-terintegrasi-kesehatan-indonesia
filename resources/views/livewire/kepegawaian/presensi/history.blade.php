<div class="space-y-8 pb-20 animate-fade-in">
    
    <!-- DASHBOARD SUMMARY (Real-time Stats) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" wire:poll.10s>
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-5 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden">
            <div class="absolute right-0 top-0 opacity-10 -mr-4 -mt-4">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <p class="text-xs font-bold text-emerald-100 uppercase tracking-widest relative z-10">Total Hadir</p>
            <h3 class="text-3xl font-black mt-1 relative z-10">{{ $stats['hadir'] }} <span class="text-sm font-medium opacity-80">Hari</span></h3>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Terlambat</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats['terlambat'] }}</h3>
                </div>
                <div class="p-2 bg-amber-50 rounded-xl text-amber-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Cuti / Izin</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats['cuti'] }}</h3>
                </div>
                <div class="p-2 bg-purple-50 rounded-xl text-purple-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Alpha</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats['alpha'] }}</h3>
                </div>
                <div class="p-2 bg-rose-50 rounded-xl text-rose-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- CALENDAR CONTAINER -->
    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50">
        
        <!-- Modern Month Navigation -->
        <div class="flex items-center justify-between mb-8">
            <button wire:click="prevMonth" class="p-3 hover:bg-slate-50 rounded-2xl text-slate-400 hover:text-slate-800 transition-all border border-transparent hover:border-slate-200 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </button>
            
            <div class="text-center">
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ $namaBulan }}</h2>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-blue-500 uppercase tracking-widest">Live Calendar</span>
                </div>
            </div>

            <button wire:click="nextMonth" class="p-3 hover:bg-slate-50 rounded-2xl text-slate-400 hover:text-slate-800 transition-all border border-transparent hover:border-slate-200 group">
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </button>
        </div>

        <!-- Grid Header -->
        <div class="grid grid-cols-7 mb-4 text-center">
            @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $d)
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest py-2">{{ $d }}</div>
            @endforeach
        </div>

        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-2 lg:gap-3 relative">
            
            <!-- Loading Overlay -->
            <div wire:loading.flex wire:target="prevMonth,nextMonth" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center rounded-3xl">
                <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>

            @foreach($calendar as $date)
                @if($date)
                    @php
                        $baseClass = "relative h-20 lg:h-24 rounded-2xl border flex flex-col items-center justify-start pt-2 transition-all duration-200 group";
                        $statusClass = "bg-white border-slate-50 hover:border-blue-200 hover:shadow-md"; 
                        $textClass = "text-slate-700";
                        $dotClass = "hidden";

                        if ($selectedDate == $date['date']) {
                            $statusClass = "bg-blue-50 border-blue-500 ring-2 ring-blue-200 z-10";
                        } elseif ($date['status'] == 'Libur') {
                            $statusClass = "bg-red-50/50 border-red-100 text-red-500";
                            $textClass = "text-red-600";
                        } elseif ($date['status'] == 'Cuti') {
                            $statusClass = "bg-purple-50/50 border-purple-100 text-purple-500";
                            $textClass = "text-purple-600";
                        } elseif ($date['status'] == 'Hadir') {
                            $statusClass = "bg-emerald-50/30 border-emerald-100";
                            $dotClass = "bg-emerald-500 block";
                        } elseif (in_array($date['status'], ['Terlambat', 'Pulang Cepat'])) {
                            $statusClass = "bg-amber-50/30 border-amber-100";
                            $dotClass = "bg-amber-500 block";
                        } elseif (in_array($date['status'], ['Dinas Luar', 'WFH'])) {
                            $statusClass = "bg-blue-50/30 border-blue-100";
                            $dotClass = "bg-blue-500 block";
                        } elseif ($date['status'] == 'Alpha' && !$date['is_today']) {
                            $statusClass = "bg-slate-50 border-slate-100 opacity-60";
                        } elseif ($date['status'] == 'Future') {
                            $statusClass = "bg-white border-transparent opacity-30 cursor-default";
                        }
                    @endphp

                    <button wire:click="selectDate('{{ $date['date'] }}')" 
                            class="{{ $baseClass }} {{ $statusClass }}"
                            @if($date['status'] == 'Future') disabled @endif>
                        
                        <span class="text-sm font-black {{ $date['is_today'] ? 'bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full shadow-lg shadow-blue-500/30' : $textClass }}">
                            {{ $date['day'] }}
                        </span>

                        @if($date['presensi'])
                            <div class="mt-2 flex flex-col items-center">
                                <div class="w-1.5 h-1.5 rounded-full {{ $dotClass }} mb-1"></div>
                                <span class="text-[9px] font-bold uppercase {{ $textClass }}">
                                    {{ $date['presensi']->jam_masuk->format('H:i') }}
                                </span>
                            </div>
                        @elseif($date['status'] == 'Libur')
                            <span class="mt-2 text-[8px] leading-tight font-bold text-red-400 px-1 truncate w-full text-center">
                                {{ Str::limit($date['libur']->keterangan ?? 'Libur', 10) }}
                            </span>
                        @elseif($date['status'] == 'Cuti')
                            <span class="mt-2 text-[8px] leading-tight font-bold text-purple-400 px-1 truncate w-full text-center">
                                Cuti
                            </span>
                        @endif
                    </button>
                @else
                    <div class="h-20 lg:h-24"></div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- DETAIL PANEL SLIDE-UP -->
    @if($selectedDate)
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-[0_-10px_40px_-15px_rgba(0,0,0,0.1)] overflow-hidden animate-slide-up relative z-20" id="detail-panel">
        <div class="bg-slate-900 p-8 flex justify-between items-center relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-blue-600/20 rounded-full blur-[80px] -mr-16 -mt-16"></div>
            <div class="relative z-10">
                <p class="text-slate-400 font-mono text-xs uppercase tracking-widest mb-1">Detail Aktivitas</p>
                <h3 class="text-2xl font-black text-white">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</h3>
            </div>
            
            <!-- Status Badge Big -->
            @php
                $selectedItem = collect($calendar)->firstWhere('date', $selectedDate);
                $statusBadge = 'bg-slate-800 text-slate-400';
                $statusText = 'Tidak Ada Data';
                
                if($selectedItem) {
                    if($selectedItem['status'] == 'Hadir') { $statusBadge = 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30'; $statusText = 'Hadir Tepat Waktu'; }
                    elseif($selectedItem['status'] == 'Terlambat') { $statusBadge = 'bg-amber-500 text-white shadow-lg shadow-amber-500/30'; $statusText = 'Terlambat'; }
                    elseif($selectedItem['status'] == 'Cuti') { $statusBadge = 'bg-purple-500 text-white shadow-lg shadow-purple-500/30'; $statusText = 'Sedang Cuti'; }
                    elseif($selectedItem['status'] == 'Libur') { $statusBadge = 'bg-red-500 text-white shadow-lg shadow-red-500/30'; $statusText = 'Hari Libur'; }
                    elseif($selectedItem['status'] == 'Dinas Luar') { $statusBadge = 'bg-blue-500 text-white shadow-lg shadow-blue-500/30'; $statusText = 'Dinas Luar'; }
                }
            @endphp
            <div class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider relative z-10 {{ $statusBadge }}">
                {{ $statusText }}
            </div>
        </div>

        <div class="p-8">
            @if($selectedItem && $selectedItem['status'] == 'Cuti')
                <div class="text-center py-8">
                    <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4 text-purple-500">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-lg font-black text-purple-900">Mode Cuti Aktif</h3>
                    <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">Laporan aktivitas dinonaktifkan untuk tanggal ini.</p>
                </div>
            @elseif($selectedItem && $selectedItem['status'] == 'Libur')
                <div class="text-center py-8">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="text-lg font-black text-red-900">{{ $selectedItem['libur']->keterangan ?? 'Hari Libur' }}</h3>
                </div>
            @elseif($detailPresensi)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Kolom Kiri: Presensi -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="flex-1 text-center border-r border-slate-200">
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Masuk</p>
                                <p class="text-2xl font-black text-slate-800">{{ $detailPresensi->jam_masuk->format('H:i') }}</p>
                            </div>
                            <div class="flex-1 text-center">
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Pulang</p>
                                <p class="text-2xl font-black text-slate-800">{{ $detailPresensi->jam_keluar ? $detailPresensi->jam_keluar->format('H:i') : '--:--' }}</p>
                            </div>
                        </div>

                        <!-- Map/Location Placeholder -->
                        <div class="rounded-2xl overflow-hidden bg-slate-100 h-32 relative flex items-center justify-center border border-slate-200 group">
                            <div class="absolute inset-0 bg-slate-200 opacity-50 pattern-grid"></div>
                            <div class="text-center relative z-10">
                                <svg class="w-8 h-8 text-slate-400 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <p class="text-xs font-bold text-slate-500">{{ Str::limit($detailPresensi->alamat_masuk ?? 'Lokasi GPS', 30) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Timeline Laporan -->
                    <div class="lg:col-span-7">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-black text-slate-800 text-sm uppercase tracking-wider">Laporan Aktivitas</h4>
                            <a href="{{ route('kepegawaian.aktivitas.create', ['tanggal' => $selectedDate]) }}" class="text-xs font-bold text-blue-600 hover:bg-blue-50 px-3 py-1 rounded-lg transition-colors">
                                {{ $detailLaporan ? 'Edit Laporan' : '+ Buat Laporan' }}
                            </a>
                        </div>

                        <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 max-h-64 overflow-y-auto custom-scrollbar">
                            @if($detailLaporan && $detailLaporan->details->count() > 0)
                                <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                                    @foreach($detailLaporan->details as $item)
                                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                        <!-- Icon -->
                                        <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-300 group-[.is-active]:bg-emerald-500 text-slate-500 group-[.is-active]:text-emerald-50 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        </div>
                                        <!-- Content -->
                                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 bg-white shadow-sm">
                                            <div class="flex items-center justify-between space-x-2 mb-1">
                                                <div class="font-bold text-slate-900 text-sm">{{ $item->kegiatan }}</div>
                                                <time class="font-mono text-xs font-medium text-slate-500">{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}</time>
                                            </div>
                                            <div class="text-slate-500 text-xs">{{ $item->output }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <p class="text-slate-400 text-sm">Belum ada aktivitas yang direkam.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-400 font-bold">Tidak ada data kehadiran (Alpha).</p>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
    @keyframes slide-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slide-up { animation: slide-up 0.4s ease-out forwards; }
    .animate-fade-in { animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>