<div class="space-y-8 pb-20">
    <!-- Header & Filter -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-800">{{ $namaBulan }}</h2>
            <p class="text-sm text-slate-500 font-medium">Klik tanggal untuk melihat detail aktivitas.</p>
        </div>
        <div class="flex gap-3">
            <select wire:model.live="bulan" class="rounded-xl border-slate-200 text-sm font-bold text-slate-600 focus:ring-blue-500">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <select wire:model.live="tahun" class="rounded-xl border-slate-200 text-sm font-bold text-slate-600 focus:ring-blue-500">
                @foreach(range(\Carbon\Carbon::now()->year, \Carbon\Carbon::now()->year - 2) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- CALENDAR GRID -->
    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <!-- Days Header -->
        <div class="grid grid-cols-7 mb-4 text-center">
            @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $d)
                <div class="text-xs font-black text-slate-400 uppercase tracking-widest py-2">{{ $d }}</div>
            @endforeach
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-7 gap-2 lg:gap-4">
            @foreach($calendar as $date)
                @if($date)
                    @php
                        // Color Logic
                        $bgClass = 'bg-slate-50 border-slate-100 text-slate-400 hover:bg-slate-100'; // Default Empty/Weekend
                        $dotClass = 'bg-slate-300';
                        
                        if ($date['status'] == 'Libur') {
                            $bgClass = 'bg-red-50 border-red-100 text-red-600 hover:bg-red-100';
                            $dotClass = 'bg-red-500';
                        } elseif ($date['status'] == 'Cuti') {
                            $bgClass = 'bg-purple-50 border-purple-100 text-purple-600 hover:bg-purple-100';
                            $dotClass = 'bg-purple-500';
                        } elseif ($date['status'] == 'Hadir') {
                            $bgClass = 'bg-emerald-50 border-emerald-100 text-emerald-700 hover:bg-emerald-100';
                            $dotClass = 'bg-emerald-500';
                        } elseif (in_array($date['status'], ['Terlambat', 'Pulang Cepat'])) {
                            $bgClass = 'bg-amber-50 border-amber-100 text-amber-700 hover:bg-amber-100';
                            $dotClass = 'bg-amber-500';
                        } elseif (in_array($date['status'], ['Dinas Luar', 'WFH'])) {
                            $bgClass = 'bg-blue-50 border-blue-100 text-blue-700 hover:bg-blue-100';
                            $dotClass = 'bg-blue-500';
                        } elseif ($date['status'] == 'Future') {
                            $bgClass = 'bg-white border-slate-50 text-slate-300 cursor-default';
                            $dotClass = 'hidden';
                        }

                        // Selected State
                        if ($selectedDate == $date['date']) {
                            $bgClass .= ' ring-2 ring-blue-500 ring-offset-2';
                        }
                    @endphp

                    <button wire:click="selectDate('{{ $date['date'] }}')" 
                            class="relative h-20 lg:h-28 rounded-2xl border flex flex-col items-start justify-between p-2 lg:p-3 transition-all {{ $bgClass }}"
                            @if($date['status'] == 'Future') disabled @endif>
                        
                        <span class="text-sm lg:text-lg font-black {{ $date['is_today'] ? 'text-blue-600' : '' }}">
                            {{ $date['day'] }}
                        </span>

                        <!-- Indicators -->
                        <div class="w-full">
                            @if($date['libur'])
                                <span class="block text-[8px] lg:text-[10px] leading-tight font-bold text-red-500 truncate w-full text-left mb-1">
                                    {{ Str::limit($date['libur']->keterangan, 15) }}
                                </span>
                            @endif

                            @if($date['cuti'])
                                <span class="block text-[8px] lg:text-[10px] leading-tight font-bold text-purple-500 truncate w-full text-left mb-1">
                                    {{ Str::limit($date['cuti']->jenis_cuti, 15) }}
                                </span>
                            @endif

                            @if($date['presensi'])
                                <div class="flex items-center gap-1">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></div>
                                    <span class="text-[8px] lg:text-[10px] font-bold uppercase truncate hidden lg:block">
                                        {{ $date['presensi']->jam_masuk->format('H:i') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </button>
                @else
                    <div class="h-20 lg:h-28"></div> <!-- Spacer -->
                @endif
            @endforeach
        </div>
    </div>

    <!-- DETAIL PANEL (Muncul saat tanggal diklik) -->
    @if($selectedDate)
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden animate-fade-in-up" id="detail-panel">
        <div class="bg-slate-900 p-8 text-white relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-blue-600/20 rounded-full blur-3xl -mr-16 -mt-16"></div>
            <h3 class="text-2xl font-black relative z-10">Detail Aktivitas</h3>
            <p class="text-slate-400 relative z-10 font-mono">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</p>
        </div>

        <div class="p-8">
            @php
                $selectedItem = collect($calendar)->firstWhere('date', $selectedDate);
            @endphp

            @if($selectedItem && $selectedItem['status'] == 'Libur')
                <div class="text-center py-8">
                    <p class="text-red-500 font-bold text-lg mb-2">Hari Libur Nasional</p>
                    <p class="text-slate-500">{{ $selectedItem['libur']->keterangan ?? '' }}</p>
                </div>
            @elseif($selectedItem && $selectedItem['status'] == 'Cuti')
                <!-- Tampilan Mode Cuti -->
                <div class="bg-purple-50 border border-purple-100 rounded-3xl p-8 text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-purple-500">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-purple-800 mb-2">Sedang Dalam Masa Cuti</h3>
                    <p class="text-purple-600 font-bold uppercase tracking-widest text-xs mb-6">{{ $detailCuti->jenis_cuti ?? 'Cuti Tahunan' }}</p>
                    <p class="text-slate-500 text-sm max-w-md mx-auto mb-8">
                        Fitur Laporan Aktivitas dinonaktifkan untuk tanggal ini sesuai dengan kebijakan kepegawaian.
                    </p>
                    <button disabled class="px-6 py-3 bg-slate-200 text-slate-400 rounded-xl font-bold text-xs cursor-not-allowed uppercase tracking-wider">
                        Laporan Aktivitas Dikunci
                    </button>
                </div>
            @else
                <!-- Tampilan Normal (Hadir / Alpha) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Data Kehadiran -->
                    <div class="space-y-6">
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
                            <div class="p-6 bg-slate-50 border border-slate-100 rounded-2xl text-center">
                                <p class="text-slate-400 text-sm">Tidak ada data presensi (Alpha).</p>
                            </div>
                        @endif
                    </div>

                    <!-- Laporan Aktivitas -->
                    <div class="space-y-6">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                            <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Laporan Kinerja</h4>
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-bold uppercase">{{ $detailLaporan->status ?? 'Belum Ada' }}</span>
                        </div>

                        @if($detailLaporan && $detailLaporan->details->count() > 0)
                            <div class="space-y-3 max-h-64 overflow-y-auto custom-scrollbar pr-2">
                                @foreach($detailLaporan->details as $item)
                                <div class="flex gap-3">
                                    <div class="flex flex-col items-center">
                                        <div class="w-2 h-2 bg-slate-300 rounded-full"></div>
                                        <div class="w-0.5 h-full bg-slate-100 my-1"></div>
                                    </div>
                                    <div class="pb-4">
                                        <p class="text-xs font-mono font-bold text-slate-400">{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</p>
                                        <p class="text-sm font-bold text-slate-700">{{ $item->kegiatan }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">Output: {{ $item->output }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <a href="{{ route('aktivitas.create', ['tanggal' => $selectedDate]) }}" class="block w-full py-3 bg-slate-800 text-white rounded-xl text-center text-xs font-bold hover:bg-slate-900 transition-colors">
                                Edit Laporan
                            </a>
                        @else
                            <div class="text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                <p class="text-slate-400 text-xs font-medium mb-3">Belum ada laporan aktivitas.</p>
                                <a href="{{ route('aktivitas.create', ['tanggal' => $selectedDate]) }}" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                                    + Buat Laporan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>