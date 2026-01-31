<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    
    <!-- Filter & Stats (Top Bar) -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-black text-slate-800 mb-1">Jurnal Kehadiran</h2>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Rekapitulasi Bulanan</p>
            </div>
            <div class="flex items-center justify-between bg-slate-50 p-2 rounded-2xl border border-slate-200 mt-6">
                <button wire:click="previousMonth" class="p-2 hover:bg-white hover:shadow-sm rounded-xl transition text-slate-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <span class="font-black text-slate-700 text-lg">{{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}</span>
                <button wire:click="nextMonth" class="p-2 hover:bg-white hover:shadow-sm rounded-xl transition text-slate-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>
        <div class="lg:col-span-3 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-emerald-50 p-6 rounded-[2.5rem] border border-emerald-100">
                <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">Hadir</p>
                <h3 class="text-4xl font-black text-emerald-800">{{ $stats['Hadir'] }}</h3>
            </div>
            <div class="bg-amber-50 p-6 rounded-[2.5rem] border border-amber-100">
                <p class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-2">Dinas</p>
                <h3 class="text-4xl font-black text-amber-800">{{ $stats['Dinas Luar'] }}</h3>
            </div>
            <div class="bg-rose-50 p-6 rounded-[2.5rem] border border-rose-100">
                <p class="text-xs font-bold text-rose-600 uppercase tracking-widest mb-2">Telat</p>
                <h3 class="text-4xl font-black text-rose-800">{{ $stats['Terlambat'] }}</h3>
            </div>
            <div class="bg-purple-50 p-6 rounded-[2.5rem] border border-purple-100">
                <p class="text-xs font-bold text-purple-600 uppercase tracking-widest mb-2">Cuti</p>
                <h3 class="text-4xl font-black text-purple-800">{{ $stats['Cuti'] }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Calendar Grid (Left) -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[3rem] shadow-xl border border-slate-100 h-fit">
            <div class="grid grid-cols-7 mb-4">
                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                    <div class="text-center"><span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ $day }}</span></div>
                @endforeach
            </div>
            <div class="grid grid-cols-7 gap-2">
                @foreach($daysInMonth as $day)
                    @if($day)
                        @php
                            $presensi = $attendanceData[$day] ?? null;
                            $cuti = $cutiData[$day] ?? null;
                            $lkhCount = isset($lkhData[$day]) ? $lkhData[$day]->count() : 0;
                            $isSelected = $selectedDate && \Carbon\Carbon::parse($selectedDate)->day == $day;
                            $isToday = $day == now()->day && $bulan == now()->month && $tahun == now()->year;
                            
                            $bgClass = 'bg-slate-50 border-slate-100 hover:border-blue-300';
                            $textClass = 'text-slate-700';
                            
                            if ($cuti) {
                                $bgClass = 'bg-purple-50 border-purple-200 hover:bg-purple-100';
                                $textClass = 'text-purple-800';
                            } elseif ($presensi) {
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
                            }
                            
                            if ($isSelected) {
                                $bgClass = 'bg-indigo-600 border-indigo-600 text-white shadow-lg ring-4 ring-indigo-100';
                                $textClass = 'text-white';
                            }
                        @endphp

                        <div wire:click="selectDate({{ $day }})" class="relative group h-28 p-2 rounded-2xl border-2 {{ $bgClass }} transition-all flex flex-col justify-between overflow-hidden cursor-pointer">
                            <div class="flex justify-between items-start">
                                <span class="font-black text-lg {{ $textClass }}">{{ $day }}</span>
                                @if($lkhCount > 0)
                                    <span class="{{ $isSelected ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-700' }} text-[9px] font-bold px-1.5 py-0.5 rounded-full">{{ $lkhCount }} Keg</span>
                                @endif
                            </div>
                            
                            @if($cuti)
                                <div class="mt-auto text-center"><span class="px-2 py-0.5 rounded bg-white/50 backdrop-blur-sm text-[10px] font-black uppercase tracking-wider text-purple-700">CUTI</span></div>
                            @elseif($presensi)
                                <div class="text-[9px] font-bold {{ $textClass }} mt-1 truncate">
                                    {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}
                                    @if($presensi->jam_keluar) - {{ \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i') }} @endif
                                </div>
                            @endif
                            @if($isToday && !$isSelected) <div class="absolute top-2 right-2 w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></div> @endif
                        </div>
                    @else
                        <div class="h-28"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Detail Panel (Right Side - Embedded) -->
        <div class="lg:col-span-1">
            @if($selectedDate)
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden sticky top-6 animate-fade-in-up">
                    <!-- Panel Header -->
                    <div class="bg-indigo-600 p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                        <h3 class="text-xl font-black relative z-10">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</h3>
                        <div class="flex items-center justify-between relative z-10 mt-2">
                            <p class="text-indigo-200 text-xs font-bold uppercase tracking-widest">Aktivitas Harian</p>
                            @if(!$isCuti)
                                <span class="bg-white/20 px-2 py-1 rounded-lg text-xs font-bold">{{ number_format($totalDurasiHariIni / 60, 1) }} Jam Kerja</span>
                            @endif
                        </div>
                        <button wire:click="$set('selectedDate', null)" class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-6 max-h-[80vh] overflow-y-auto custom-scrollbar">
                        <!-- 1. Presensi Info -->
                        @if($isCuti)
                            <div class="p-4 bg-purple-50 rounded-2xl border border-purple-100 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg></div>
                                <div><h4 class="font-bold text-purple-800 text-sm">Sedang Cuti</h4><p class="text-[10px] text-purple-600">Input dinonaktifkan.</p></div>
                            </div>
                        @elseif($selectedPresensi)
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">Masuk</p>
                                    <p class="text-lg font-black text-emerald-600">{{ \Carbon\Carbon::parse($selectedPresensi->jam_masuk)->format('H:i') }}</p>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">Pulang</p>
                                    <p class="text-lg font-black text-slate-700">{{ $selectedPresensi->jam_keluar ? \Carbon\Carbon::parse($selectedPresensi->jam_keluar)->format('H:i') : '--:--' }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- 2. Form Input LKH (Complex) -->
                        @if(!$isCuti)
                            <div class="pt-2">
                                <form wire:submit.prevent="saveLKH" class="space-y-4 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                                    <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2 mb-2">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg> 
                                        Input Kegiatan Baru
                                    </h4>
                                    
                                    <div>
                                        <input type="text" wire:model="aktivitas" class="w-full rounded-xl border-slate-200 text-sm font-bold placeholder-slate-400 focus:ring-indigo-500 bg-white" placeholder="Judul kegiatan...">
                                        @error('aktivitas') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-3">
                                        <select wire:model="kategori_kegiatan" class="w-full rounded-xl border-slate-200 text-xs font-bold bg-white">
                                            <option value="Tugas Utama">Utama</option>
                                            <option value="Tugas Tambahan">Tambahan</option>
                                            <option value="Rapat">Rapat</option>
                                            <option value="Dinas Luar">Dinas Luar</option>
                                        </select>
                                        <select wire:model="prioritas" class="w-full rounded-xl border-slate-200 text-xs font-bold bg-white">
                                            <option value="Normal">Normal</option>
                                            <option value="High">High</option>
                                            <option value="Urgent">Urgent</option>
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="relative">
                                            <span class="absolute left-2 top-2 text-[9px] font-bold text-slate-400">Mulai</span>
                                            <input type="time" wire:model.live="jam_mulai" class="w-full rounded-xl border-slate-200 text-xs font-bold pt-5 pb-1 px-2 bg-white">
                                        </div>
                                        <div class="relative">
                                            <span class="absolute left-2 top-2 text-[9px] font-bold text-slate-400">Selesai</span>
                                            <input type="time" wire:model.live="jam_selesai" class="w-full rounded-xl border-slate-200 text-xs font-bold pt-5 pb-1 px-2 bg-white">
                                        </div>
                                    </div>
                                    
                                    <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-200 text-xs font-medium focus:ring-indigo-500 bg-white" placeholder="Detail hasil kerja..."></textarea>

                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold text-slate-500">Progress</span>
                                        <input type="range" wire:model.live="persentase_selesai" class="flex-1 h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                        <span class="text-[10px] font-black text-indigo-600 w-6 text-right">{{ $persentase_selesai }}%</span>
                                    </div>

                                    <button type="submit" class="w-full py-2.5 bg-slate-800 text-white rounded-xl font-bold text-xs hover:bg-slate-900 transition shadow-lg flex justify-center items-center gap-2">
                                        <span wire:loading.remove>Tambahkan ke Daftar</span>
                                        <span wire:loading>Menyimpan...</span>
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- 3. Timeline Kegiatan Hari Ini -->
                        @if($selectedLkhList->count() > 0)
                            <div class="pt-4 border-t border-dashed border-slate-200 relative">
                                <div class="absolute left-4 top-4 bottom-0 w-0.5 bg-slate-200"></div>
                                <div class="space-y-6">
                                    @foreach($selectedLkhList as $l)
                                    <div class="relative pl-10 group">
                                        <div class="absolute left-[13px] top-1 w-2.5 h-2.5 rounded-full border-2 border-white bg-indigo-500 z-10"></div>
                                        
                                        <div class="bg-white p-3 rounded-xl border border-slate-100 shadow-sm group-hover:border-indigo-200 transition-all relative">
                                            <div class="flex justify-between items-start mb-1">
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-slate-100 text-slate-500">{{ $l->kategori_kegiatan }}</span>
                                                <button wire:click="deleteLKH({{ $l->id }})" class="text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                            </div>
                                            
                                            <h4 class="font-bold text-slate-800 text-sm">{{ $l->aktivitas }}</h4>
                                            <p class="text-[10px] text-slate-500 mt-1 line-clamp-2">{{ $l->deskripsi }}</p>
                                            
                                            <div class="mt-2 flex justify-between items-center pt-2 border-t border-slate-50">
                                                <span class="text-[10px] font-mono font-bold text-slate-400 bg-slate-50 px-1.5 py-0.5 rounded">
                                                    {{ \Carbon\Carbon::parse($l->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($l->jam_selesai)->format('H:i') }}
                                                </span>
                                                <span class="text-[10px] font-black text-indigo-600">{{ $l->persentase_selesai }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            @if(!$isCuti) 
                                <div class="text-center py-8">
                                    <p class="text-xs text-slate-400 italic">Belum ada kegiatan tercatat hari ini.</p> 
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @else
                <!-- Placeholder State -->
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] h-full min-h-[400px] flex flex-col items-center justify-center text-center p-8 sticky top-6">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm animate-bounce-slow">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-600">Pilih Tanggal</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-[200px]">Klik tanggal di kalender untuk mulai mencatat aktivitas harian Anda.</p>
                </div>
            @endif
        </div>
    </div>
</div>