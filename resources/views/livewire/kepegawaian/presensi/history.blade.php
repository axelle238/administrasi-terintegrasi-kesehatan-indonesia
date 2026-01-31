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

                        <div wire:click="selectDate({{ $day }})" class="relative group h-24 p-2 rounded-2xl border-2 {{ $bgClass }} transition-all flex flex-col justify-between overflow-hidden cursor-pointer">
                            <div class="flex justify-between items-start">
                                <span class="font-black text-lg {{ $textClass }}">{{ $day }}</span>
                                @if($lkhCount > 0)
                                    <span class="{{ $isSelected ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-700' }} text-[9px] font-bold px-1.5 py-0.5 rounded-full">{{ $lkhCount }}</span>
                                @endif
                            </div>
                            @if($cuti)
                                <div class="mt-auto text-center"><span class="px-2 py-0.5 rounded bg-white/50 backdrop-blur-sm text-[9px] font-black uppercase tracking-wider text-purple-700">CUTI</span></div>
                            @elseif($presensi)
                                <div class="text-[9px] font-bold {{ $textClass }} mt-1 truncate">
                                    {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}
                                </div>
                            @endif
                            @if($isToday && !$isSelected) <div class="absolute top-2 right-2 w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></div> @endif
                        </div>
                    @else
                        <div class="h-24"></div>
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
                        <p class="text-indigo-200 text-xs relative z-10 font-bold uppercase tracking-widest mt-1">Detail Harian</p>
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
                        @else
                            <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 text-center text-xs text-amber-700 font-bold">Belum ada data presensi.</div>
                        @endif

                        <!-- 2. Form Input LKH (Complex) -->
                        @if(!$isCuti)
                            <div class="pt-6 border-t border-dashed border-slate-200">
                                <h4 class="font-bold text-slate-800 mb-4 text-sm flex items-center gap-2"><span class="w-1.5 h-4 bg-indigo-500 rounded-full"></span> Input Aktivitas</h4>
                                <form wire:submit.prevent="saveLKH" class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Judul Kegiatan</label>
                                        <input type="text" wire:model="aktivitas" class="w-full rounded-xl border-slate-200 text-sm font-bold placeholder-slate-300 focus:ring-indigo-500" placeholder="Apa yang dikerjakan?">
                                        @error('aktivitas') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Kategori</label>
                                            <select wire:model="kategori_kegiatan" class="w-full rounded-xl border-slate-200 text-xs font-bold bg-slate-50">
                                                <option value="Tugas Utama">Utama</option>
                                                <option value="Tugas Tambahan">Tambahan</option>
                                                <option value="Rapat">Rapat</option>
                                                <option value="Dinas Luar">Dinas Luar</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Prioritas</label>
                                            <select wire:model="prioritas" class="w-full rounded-xl border-slate-200 text-xs font-bold bg-slate-50">
                                                <option value="Normal">Normal</option>
                                                <option value="High">High</option>
                                                <option value="Urgent">Urgent</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Mulai</label>
                                            <input type="time" wire:model.live="jam_mulai" class="w-full rounded-xl border-slate-200 text-xs font-bold">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Selesai</label>
                                            <input type="time" wire:model.live="jam_selesai" class="w-full rounded-xl border-slate-200 text-xs font-bold">
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Deskripsi Hasil</label>
                                        <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-200 text-sm font-medium focus:ring-indigo-500" placeholder="Detail output..."></textarea>
                                        @error('deskripsi') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Progress & Bukti</label>
                                        <div class="flex items-center gap-3 mb-2">
                                            <input type="range" wire:model.live="persentase_selesai" class="flex-1 h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                            <span class="text-xs font-black text-indigo-600 w-8">{{ $persentase_selesai }}%</span>
                                        </div>
                                        <input type="file" wire:model="file_bukti_kerja" class="block w-full text-[10px] text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    </div>

                                    <button type="submit" class="w-full py-3 bg-slate-800 text-white rounded-xl font-bold text-sm hover:bg-slate-900 transition shadow-lg flex justify-center items-center gap-2">
                                        <span wire:loading.remove>Simpan Aktivitas</span>
                                        <span wire:loading><svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></span>
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- 3. List Aktivitas Hari Ini -->
                        <div class="pt-2 space-y-3">
                            @forelse($selectedLkhList as $l)
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 group hover:bg-white hover:shadow-sm transition-all relative">
                                <div class="flex justify-between items-start mb-1">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-white border border-slate-200 text-slate-500">{{ $l->kategori_kegiatan }}</span>
                                    <button wire:click="deleteLKH({{ $l->id }})" class="text-slate-300 hover:text-red-500"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                </div>
                                <h4 class="font-bold text-slate-800 text-xs">{{ $l->aktivitas }}</h4>
                                <p class="text-[10px] text-slate-500 mt-0.5 line-clamp-2">{{ $l->deskripsi }}</p>
                                <div class="mt-2 flex justify-between items-center border-t border-slate-100 pt-2">
                                    <span class="text-[10px] font-mono font-bold text-slate-400">{{ \Carbon\Carbon::parse($l->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($l->jam_selesai)->format('H:i') }}</span>
                                    @if($l->file_bukti_kerja)
                                    <a href="{{ Storage::url($l->file_bukti_kerja) }}" target="_blank" class="text-[10px] font-bold text-blue-500 hover:underline">Bukti</a>
                                    @endif
                                </div>
                            </div>
                            @empty
                                @if(!$isCuti) <p class="text-center text-xs text-slate-400 italic">Belum ada aktivitas hari ini.</p> @endif
                            @endforelse
                        </div>
                    </div>
                </div>
            @else
                <!-- Placeholder State -->
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] h-full min-h-[400px] flex flex-col items-center justify-center text-center p-8">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-600">Pilih Tanggal</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-[200px]">Klik salah satu tanggal di kalender untuk melihat detail atau input aktivitas.</p>
                </div>
            @endif
        </div>
    </div>
</div>
