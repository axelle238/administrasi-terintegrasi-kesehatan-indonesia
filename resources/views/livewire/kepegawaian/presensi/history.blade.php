<div class="space-y-8 pb-20">
    <!-- Filters -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <h2 class="text-xl font-black text-slate-800">Riwayat Kehadiran</h2>
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

    <!-- Timeline Grid -->
    <div class="space-y-4">
        @forelse($history as $absen)
            @php
                $tglKey = $absen->tanggal->format('Y-m-d');
                $laporan = $laporanList[$tglKey] ?? null;
            @endphp
            
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group relative overflow-hidden">
                <!-- Decoration -->
                <div class="absolute left-0 top-0 bottom-0 w-2 {{ $absen->status_masuk == 'Terlambat' ? 'bg-rose-500' : 'bg-emerald-500' }}"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center pl-4">
                    <!-- Date -->
                    <div class="lg:col-span-3 flex items-center gap-4">
                        <div class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl bg-slate-50 text-slate-600 border border-slate-200 shrink-0">
                            <span class="text-[10px] font-bold uppercase">{{ $absen->tanggal->translatedFormat('M') }}</span>
                            <span class="text-xl font-black">{{ $absen->tanggal->format('d') }}</span>
                        </div>
                        <div>
                            <p class="font-black text-slate-800 text-sm">{{ $absen->tanggal->translatedFormat('l') }}</p>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $absen->status_masuk == 'Terlambat' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $absen->status_masuk }}
                            </span>
                        </div>
                    </div>

                    <!-- Time Logs -->
                    <div class="lg:col-span-5 flex flex-col sm:flex-row gap-4 sm:gap-8 border-l border-slate-100 pl-0 sm:pl-8 lg:border-l-0 lg:pl-0">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jam Masuk</p>
                            <p class="text-xl font-black text-slate-800">{{ $absen->jam_masuk->format('H:i') }}</p>
                            @if($absen->terlambat_menit > 0)
                                <p class="text-[10px] text-rose-500 font-bold">Telat {{ $absen->terlambat_menit }}m</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jam Pulang</p>
                            @if($absen->jam_keluar)
                                <p class="text-xl font-black text-slate-800">{{ $absen->jam_keluar->format('H:i') }}</p>
                                <p class="text-[10px] text-emerald-500 font-bold">{{ $absen->total_jam_kerja_menit }} Menit Kerja</p>
                            @else
                                <p class="text-xl font-black text-slate-300">--:--</p>
                            @endif
                        </div>
                    </div>

                    <!-- Action Integration Hub -->
                    <div class="lg:col-span-4 flex flex-col gap-2">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Laporan Aktivitas</p>
                        
                        @if($laporan)
                            <div class="flex items-center justify-between bg-slate-50 p-3 rounded-xl border border-slate-200">
                                <div>
                                    <span class="text-xs font-bold text-slate-700">Status: {{ $laporan->status }}</span>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Dibuat otomatis dari presensi.</p>
                                </div>
                                <a href="{{ route('aktivitas.create', ['tanggal' => $tglKey]) }}" class="px-3 py-1.5 bg-white border border-slate-200 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-50 transition-colors">
                                    Edit Laporan
                                </a>
                            </div>
                        @else
                            <!-- Tombol ini harusnya jarang muncul jika auto-create jalan, tapi sebagai fallback -->
                            <a href="{{ route('aktivitas.create', ['tanggal' => $tglKey]) }}" class="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-400 text-xs font-bold hover:border-blue-400 hover:text-blue-500 transition-colors text-center">
                                + Buat Laporan Manual
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-slate-400 font-bold">Tidak ada data kehadiran bulan ini.</p>
            </div>
        @endforelse
    </div>
    
    {{ $history->links() }}
</div>