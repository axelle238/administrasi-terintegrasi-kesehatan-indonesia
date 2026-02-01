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

            <!-- Cetak Button -->
            <button onclick="window.print()" class="p-3 bg-slate-800 text-white rounded-2xl hover:bg-slate-700 transition-all shadow-lg shadow-slate-200 ml-2" title="Cetak Laporan">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
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
            @elseif($selectedItem && $selectedItem['status'] == 'Future')
                <div class="text-center py-8 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <p class="text-slate-400 font-bold">Hari Masa Depan</p>
                    <p class="text-xs text-slate-400 mt-1">Anda belum dapat mengisi laporan untuk tanggal ini.</p>
                </div>
            @else
                <!-- Tampilan Normal (Hadir / Alpha / Libur / Weekend) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
                    <!-- Kolom Kiri: Presensi -->
                    <div class="lg:col-span-5 space-y-6">
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest border-b border-slate-100 pb-2">Data Kehadiran</h4>
                        
                        @if($detailPresensi)
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-xs text-slate-400 font-bold uppercase mb-1">Masuk</p>
                                    <p class="text-2xl font-black text-slate-800">{{ $detailPresensi->jam_masuk->format('H:i') }}</p>
                                    @if($detailPresensi->foto_masuk)
                                        <a href="#" class="text-[10px] text-blue-500 font-bold underline mt-1 block">Lihat Foto</a>
                                    @endif
                                </div>
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-xs text-slate-400 font-bold uppercase mb-1">Pulang</p>
                                    <p class="text-2xl font-black text-slate-800">{{ $detailPresensi->jam_keluar ? $detailPresensi->jam_keluar->format('H:i') : '--:--' }}</p>
                                </div>
                            </div>

                            <!-- Shift Info -->
                            <div class="p-4 bg-white rounded-2xl border border-dashed border-slate-200">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-bold text-slate-500 uppercase">Jadwal Shift</span>
                                    <span class="font-mono font-black text-slate-700">{{ \Carbon\Carbon::parse($detailPresensi->shift_jam_masuk)->format('H:i') }} - {{ \Carbon\Carbon::parse($detailPresensi->shift_jam_keluar)->format('H:i') }}</span>
                                </div>
                            </div>

                            <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 flex items-center gap-3">
                                <div class="p-2 bg-blue-500 rounded-lg text-white">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-blue-600 uppercase">Lokasi Check-in</p>
                                    <p class="text-sm font-bold text-slate-700 truncate w-64">{{ $detailPresensi->alamat_masuk ?? 'Koordinat GPS' }}</p>
                                </div>
                            </div>
                        @else
                            <!-- No Presensi State -->
                            <div class="p-6 bg-slate-50 border border-slate-100 rounded-2xl text-center flex flex-col items-center justify-center h-full">
                                @if($selectedItem['status'] == 'Libur')
                                    <div class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <p class="text-red-500 font-bold">Hari Libur Nasional</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ $selectedItem['libur']->keterangan ?? '' }}</p>
                                @elseif($selectedItem['status'] == 'Akhir Pekan')
                                    <div class="w-12 h-12 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold">Akhir Pekan</p>
                                    <p class="text-xs text-slate-400 mt-1">Tidak ada jadwal kerja reguler.</p>
                                @else
                                    <div class="w-12 h-12 bg-slate-200 text-slate-500 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold">Tidak Hadir (Alpha)</p>
                                    <p class="text-xs text-slate-400 mt-1">Tidak ada data presensi tercatat.</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Kolom Kanan: Input & Timeline Laporan -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- FORM INPUT AKTIVITAS (Inline) -->
                        @if($selectedItem && !in_array($selectedItem['status'], ['Libur', 'Cuti', 'Future', 'Akhir Pekan']))
                            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                                <h4 class="font-black text-slate-800 text-sm uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Input Aktivitas Baru</h4>
                                
                                <form wire:submit.prevent="saveActivity" class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Mulai</label>
                                            <input type="time" wire:model="inputForm.jam_mulai" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:border-blue-500 focus:ring-blue-500">
                                            @error('inputForm.jam_mulai') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Selesai</label>
                                            <input type="time" wire:model="inputForm.jam_selesai" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:border-blue-500 focus:ring-blue-500">
                                            @error('inputForm.jam_selesai') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kegiatan</label>
                                        <textarea wire:model="inputForm.kegiatan" rows="2" placeholder="Deskripsikan aktivitas..." class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                        @error('inputForm.kegiatan') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Output / Hasil</label>
                                        <input type="text" wire:model="inputForm.output" placeholder="Contoh: Dokumen selesai, Rapat dihadiri" class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        @error('inputForm.output') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="flex justify-end pt-2">
                                        <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-700 transition-all flex items-center gap-2">
                                            <span wire:loading.remove wire:target="saveActivity">Simpan Aktivitas</span>
                                            <span wire:loading wire:target="saveActivity">Menyimpan...</span>
                                            <svg wire:loading.remove wire:target="saveActivity" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <!-- TIMELINE LIST -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-black text-slate-800 text-sm uppercase tracking-wider">Riwayat Aktivitas</h4>
                                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded">{{ $detailLaporan ? $detailLaporan->details->count() : 0 }} Item</span>
                            </div>

                            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 max-h-[400px] overflow-y-auto custom-scrollbar">
                                @if($detailLaporan && $detailLaporan->details->count() > 0)
                                    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                                        @foreach($detailLaporan->details->sortByDesc('jam_mulai') as $item)
                                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                            <!-- Icon -->
                                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-white text-emerald-500 shadow-sm shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </div>
                                            <!-- Content -->
                                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition-shadow relative group/item">
                                                
                                                <!-- Delete Button (Hover) -->
                                                <button wire:click="deleteActivity({{ $item->id }})" wire:confirm="Hapus aktivitas ini?" class="absolute top-2 right-2 text-slate-300 hover:text-red-500 transition-colors opacity-0 group-hover/item:opacity-100 p-1">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>

                                                <div class="flex items-center justify-between space-x-2 mb-1 pr-6">
                                                    <div class="font-bold text-slate-900 text-sm line-clamp-1">{{ $item->kegiatan }}</div>
                                                </div>
                                                <div class="flex items-center gap-2 text-xs font-mono text-slate-500 mb-2">
                                                    <span class="bg-slate-100 px-1.5 py-0.5 rounded">{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}</span>
                                                    <span>-</span>
                                                    <span class="bg-slate-100 px-1.5 py-0.5 rounded">{{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</span>
                                                    <span class="text-slate-300">|</span>
                                                    <span class="text-emerald-600 font-bold">{{ $item->durasi }} mnt</span>
                                                </div>
                                                <div class="text-slate-600 text-xs border-t border-slate-50 pt-2 mt-2">
                                                    <span class="font-bold text-slate-400 uppercase text-[10px] mr-1">Output:</span> {{ $item->output }}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-12 flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-3 text-slate-400">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                        </div>
                                        <p class="text-slate-500 font-bold text-sm">Belum ada aktivitas.</p>
                                        <p class="text-slate-400 text-xs mt-1">Silakan input aktivitas harian Anda pada form di atas.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

    <style>
        @keyframes slide-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide-up { animation: slide-up 0.4s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</div>