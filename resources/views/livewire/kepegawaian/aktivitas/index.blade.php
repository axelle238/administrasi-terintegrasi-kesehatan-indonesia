<div class="space-y-6">
    <!-- Header Controls -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-black text-slate-800">Riwayat LKH</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Rekapitulasi kinerja harian Anda.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <select wire:model.live="bulanFilter" class="rounded-xl border-slate-200 text-sm font-bold text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <select wire:model.live="tahunFilter" class="rounded-xl border-slate-200 text-sm font-bold text-slate-600 focus:ring-blue-500 focus:border-blue-500">
                @foreach(range(\Carbon\Carbon::now()->year, \Carbon\Carbon::now()->year - 2) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
            <a href="{{ route('kepegawaian.aktivitas.create') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-600/20 transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Laporan Baru
            </a>
        </div>
    </div>

    <!-- Timeline List -->
    <div class="space-y-4">
        @forelse($laporan as $item)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex flex-col md:flex-row justify-between gap-6">
                <!-- Date & Status -->
                <div class="flex items-start gap-4">
                    <div class="flex flex-col items-center justify-center w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 shrink-0">
                        <span class="text-xs font-bold uppercase">{{ $item->tanggal->translatedFormat('M') }}</span>
                        <span class="text-2xl font-black">{{ $item->tanggal->format('d') }}</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800">{{ $item->tanggal->translatedFormat('l, d F Y') }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            @php
                                $statusColor = match($item->status) {
                                    'Draft' => 'bg-slate-100 text-slate-600',
                                    'Diajukan' => 'bg-amber-100 text-amber-700',
                                    'Disetujui' => 'bg-emerald-100 text-emerald-700',
                                    'Ditolak' => 'bg-rose-100 text-rose-700',
                                    default => 'bg-slate-100 text-slate-600'
                                };
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $statusColor }}">
                                {{ $item->status }}
                            </span>
                            <span class="text-xs text-slate-400 font-bold">• {{ $item->details_count }} Kegiatan</span>
                        </div>
                    </div>
                </div>

                <!-- Summary & Action -->
                <div class="flex flex-col md:items-end gap-3 flex-1">
                    @if($item->catatan_verifikator)
                        <div class="bg-rose-50 border border-rose-100 rounded-xl p-3 max-w-md w-full">
                            <p class="text-[10px] font-bold text-rose-500 uppercase mb-1">Catatan Atasan:</p>
                            <p class="text-xs text-rose-800 italic">"{{ $item->catatan_verifikator }}"</p>
                        </div>
                    @endif
                    
                    <div class="flex gap-2 mt-auto">
                        @if($item->status === 'Draft' || $item->status === 'Ditolak')
                            <a href="{{ route('kepegawaian.aktivitas.create', ['tanggal' => $item->tanggal->format('Y-m-d')]) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition-colors">
                                Edit
                            </a>
                        @endif
                        <button wire:click="toggleDetail({{ $item->id }})" class="px-4 py-2 {{ $selectedLaporanId === $item->id ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-white text-slate-600 border-slate-200' }} border rounded-xl text-xs font-bold hover:bg-slate-50 transition-colors flex items-center gap-2">
                            {{ $selectedLaporanId === $item->id ? 'Tutup Detail' : 'Lihat Detail' }}
                            <svg class="w-4 h-4 {{ $selectedLaporanId === $item->id ? 'rotate-180' : '' }} transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Detail Panel (Expandable) -->
            @if($selectedLaporanId === $item->id)
            <div class="mt-6 pt-6 border-t border-dashed border-slate-200 animate-fade-in-down">
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-wider mb-4">Rincian Kegiatan</h4>
                
                <div class="relative pl-6 border-l-2 border-slate-100 space-y-6">
                    @foreach($item->details as $detail)
                    <div class="relative group">
                        <!-- Dot -->
                        <div class="absolute -left-[31px] top-1.5 w-4 h-4 rounded-full border-2 border-white bg-blue-500 shadow-sm group-hover:scale-110 transition-transform"></div>
                        
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 hover:border-blue-200 transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-bold text-slate-800 text-sm">{{ $detail->kegiatan }}</span>
                                <span class="text-xs font-mono font-bold text-slate-500 bg-white px-2 py-1 rounded border border-slate-200">
                                    {{ \Carbon\Carbon::parse($detail->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($detail->jam_selesai)->format('H:i') }}
                                </span>
                            </div>
                            <div class="text-xs text-slate-600">
                                <span class="font-bold text-slate-400 uppercase text-[10px]">Output:</span> {{ $detail->output }}
                            </div>
                            @if($detail->durasi)
                            <div class="mt-2 flex items-center gap-1 text-[10px] font-bold text-slate-400">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $detail->durasi }} Menit
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
                <!-- Preview Items (Collapsed State) -->
                <div class="mt-6 pt-4 border-t border-dashed border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-4 opacity-70 hover:opacity-100 transition-opacity cursor-pointer" wire:click="toggleDetail({{ $item->id }})">
                    @foreach($item->details->take(2) as $detail)
                    <div class="flex items-start gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-300 mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-xs font-bold text-slate-600 line-clamp-1">{{ $detail->kegiatan }}</p>
                        </div>
                    </div>
                    @endforeach
                    @if($item->details_count > 2)
                        <p class="text-[10px] text-blue-500 font-bold italic pt-0.5">... dan {{ $item->details_count - 2 }} kegiatan lainnya</p>
                    @endif
                </div>
            @endif
        </div>
        @empty
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Laporan</h3>
            <p class="text-slate-400 text-sm mt-1">Anda belum mengisi Laporan Kinerja Harian pada periode ini.</p>
        </div>
        @endforelse
    </div>
    
    {{ $laporan->links() }}
</div>