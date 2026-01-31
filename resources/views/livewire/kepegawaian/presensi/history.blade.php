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
                        $cuti = $cutiData[$day] ?? null;
                        $lkhCount = isset($lkhData[$day]) ? $lkhData[$day]->count() : 0;
                        $isToday = $day == now()->day && $bulan == now()->month && $tahun == now()->year;
                        
                        $bgClass = 'bg-slate-50 border-slate-100 hover:border-blue-200'; // Default
                        $textClass = 'text-slate-700';
                        $statusText = '';
                        
                        if ($cuti) {
                            $bgClass = 'bg-purple-50 border-purple-200 hover:bg-purple-100';
                            $textClass = 'text-purple-800';
                            $statusText = 'CUTI';
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
                        } elseif ($isToday) {
                            $bgClass = 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-500/30';
                            $textClass = 'text-white';
                        }
                    @endphp

                    <div wire:click="selectDate({{ $day }})" class="relative group h-28 md:h-32 p-3 rounded-3xl border-2 {{ $bgClass }} transition-all flex flex-col justify-between overflow-hidden cursor-pointer">
                        <div class="flex justify-between items-start">
                            <span class="font-black text-lg {{ $textClass }}">{{ $day }}</span>
                            @if($lkhCount > 0)
                                <span class="bg-indigo-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">{{ $lkhCount }} LKH</span>
                            @endif
                        </div>
                        
                        @if($cuti)
                            <div class="mt-auto text-center">
                                <span class="px-2 py-1 rounded bg-white/50 backdrop-blur-sm text-[10px] font-black uppercase tracking-wider text-purple-700">CUTI</span>
                            </div>
                        @elseif($presensi)
                            <div class="text-[10px] md:text-xs font-bold {{ $textClass }} mt-1">
                                <div>IN: {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}</div>
                                @if($presensi->jam_keluar)
                                    <div>OUT: {{ \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i') }}</div>
                                @endif
                            </div>
                        @endif

                        @if($isToday)
                            <div class="absolute top-3 right-3 w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @endif
                    </div>
                @else
                    <!-- Empty Cell -->
                    <div class="h-28 md:h-32"></div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Detail Modal -->
    @if($isOpen && $selectedDate)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="$set('isOpen', false)"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative">
                
                <!-- Modal Header -->
                <div class="bg-indigo-600 p-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <h3 class="text-xl font-black relative z-10">
                        {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}
                    </h3>
                    <p class="text-indigo-200 text-sm relative z-10">Detail Aktivitas & Kehadiran</p>
                    <button wire:click="$set('isOpen', false)" class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-8 space-y-6">
                    <!-- Status Section -->
                    @if($isCuti)
                        <div class="p-4 bg-purple-50 rounded-2xl border border-purple-100 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-purple-800">Sedang Cuti</h4>
                                <p class="text-xs text-purple-600">Anda tidak perlu mengisi LKH pada hari cuti.</p>
                            </div>
                        </div>
                    @else
                        <!-- Form LKH Quick Add -->
                        <div>
                            <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <span class="w-1.5 h-5 bg-indigo-500 rounded-full"></span> Tambah Laporan Aktivitas
                            </h4>
                            
                            <form wire:submit.prevent="saveLKH" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Aktivitas</label>
                                    <input type="text" wire:model="aktivitas" class="w-full rounded-xl border-slate-200 font-bold bg-slate-50 focus:bg-white transition-all" placeholder="Judul kegiatan...">
                                    @error('aktivitas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1">Deskripsi Singkat</label>
                                    <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white transition-all" placeholder="Detail hasil kerja..."></textarea>
                                    @error('deskripsi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-transform hover:-translate-y-0.5">
                                    Simpan Laporan
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Existing LKH List -->
                    @php 
                        $day = \Carbon\Carbon::parse($selectedDate)->day;
                        $dailyLkh = $lkhData[$day] ?? collect();
                    @endphp
                    
                    @if($dailyLkh->count() > 0)
                        <div class="pt-6 border-t border-dashed border-slate-200">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Aktivitas Tercatat</h4>
                            <div class="space-y-3">
                                @foreach($dailyLkh as $l)
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                    <p class="font-bold text-slate-700 text-sm">{{ $l->aktivitas }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $l->jam_mulai }} - {{ $l->jam_selesai }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>