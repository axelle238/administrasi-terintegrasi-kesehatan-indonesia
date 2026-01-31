<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <!-- Header & Filter -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Aktivitas Saya</h2>
            <p class="text-sm text-slate-500">Catat dan laporkan kinerja harian Anda.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm font-bold text-slate-600">Tanggal:</span>
            <input type="date" wire:model.live="tanggal_filter" class="rounded-xl border-slate-200 text-sm font-bold text-slate-700 focus:ring-indigo-500">
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Input (Kiri) -->
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 h-fit">
            <h3 class="font-black text-lg text-slate-800 mb-6 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </div>
                Input Kegiatan
            </h3>

            <form wire:submit.prevent="save" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Mulai</label>
                        <input type="time" wire:model="jam_mulai" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                        @error('jam_mulai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Selesai</label>
                        <input type="time" wire:model="jam_selesai" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                        @error('jam_selesai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Nama Aktivitas</label>
                    <input type="text" wire:model="aktivitas" class="w-full rounded-xl border-slate-200 text-sm font-medium" placeholder="Contoh: Pemeriksaan Pasien di Poli...">
                    @error('aktivitas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Output / Hasil</label>
                    <input type="text" wire:model="output" class="w-full rounded-xl border-slate-200 text-sm font-medium" placeholder="Contoh: 15 Pasien terlayani">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Deskripsi Detail</label>
                    <textarea wire:model="deskripsi" rows="2" class="w-full rounded-xl border-slate-200 text-sm font-medium"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Bukti Foto/Dokumen</label>
                    <input type="file" wire:model="file_bukti" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                        Simpan Aktivitas
                    </button>
                </div>
            </form>
        </div>

        <!-- Timeline List (Kanan) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Progress Card -->
            <div class="bg-indigo-900 p-6 rounded-3xl text-white shadow-xl relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-bl-full -mr-8 -mt-8"></div>
                <div class="flex justify-between items-end relative z-10">
                    <div>
                        <p class="text-indigo-200 text-xs font-bold uppercase tracking-widest mb-1">Total Jam Kerja</p>
                        <h3 class="text-3xl font-black">{{ $totalDurasi }}</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold mb-1">{{ number_format($progress, 0) }}% Target</p>
                        <div class="w-32 bg-white/20 h-2 rounded-full overflow-hidden">
                            <div class="bg-white h-full rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="font-bold text-lg text-slate-800 mb-6">Log Aktivitas ({{ \Carbon\Carbon::parse($tanggal_filter)->translatedFormat('d F Y') }})</h3>
                
                <div class="relative border-l-2 border-slate-100 ml-3 space-y-8">
                    @forelse($logs as $log)
                    <div class="relative pl-8 group">
                        <!-- Dot -->
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full border-2 border-white bg-indigo-500 shadow-sm group-hover:scale-125 transition-transform"></div>
                        
                        <div class="flex flex-col sm:flex-row justify-between items-start gap-2">
                            <div class="flex-1">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-black bg-slate-100 text-slate-500 mb-1">
                                    {{ \Carbon\Carbon::parse($log->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($log->jam_selesai)->format('H:i') }}
                                </span>
                                <h4 class="text-base font-bold text-slate-800">{{ $log->aktivitas }}</h4>
                                <p class="text-sm text-slate-500 mt-1">{{ $log->deskripsi }}</p>
                                @if($log->output)
                                    <p class="text-xs font-bold text-emerald-600 mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Output: {{ $log->output }}
                                    </p>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-2">
                                @if($log->file_bukti)
                                    <a href="{{ Storage::url($log->file_bukti) }}" target="_blank" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition" title="Lihat Bukti">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                    </a>
                                @endif
                                
                                @if($log->status == 'Draft')
                                    <button wire:click="delete({{ $log->id }})" wire:confirm="Hapus aktivitas ini?" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-slate-400 font-bold text-sm">Belum ada aktivitas tercatat hari ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
