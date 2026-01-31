<div class="space-y-8 pb-20">
    
    <!-- Top Bar Info -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Tanggal Laporan</label>
            <input type="date" wire:model.live="tanggal" class="bg-slate-50 border-slate-200 text-slate-800 text-lg font-black rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full md:w-auto">
        </div>
        
        <div class="flex items-center gap-4 bg-blue-50 px-5 py-3 rounded-2xl border border-blue-100">
            <div class="p-2 bg-blue-500 rounded-lg text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Jadwal Shift</p>
                <p class="text-sm font-black text-blue-800">{{ $shiftInfo }}</p>
            </div>
        </div>
    </div>

    <!-- Form Repeater Area -->
    <div class="space-y-4">
        @foreach($kegiatanList as $index => $kegiatan)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative group hover:border-blue-200 transition-all animate-fade-in-up">
            <div class="absolute -left-3 top-6 bg-slate-800 text-white w-8 h-8 flex items-center justify-center rounded-full text-sm font-black shadow-lg z-10">
                {{ $index + 1 }}
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pl-4">
                <!-- Waktu -->
                <div class="lg:col-span-2 space-y-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Mulai</label>
                        <input type="time" wire:model="kegiatanList.{{ $index }}.jam_mulai" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Selesai</label>
                        <input type="time" wire:model="kegiatanList.{{ $index }}.jam_selesai" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Detail Kegiatan -->
                <div class="lg:col-span-7 space-y-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Uraian Kegiatan <span class="text-red-500">*</span></label>
                        <textarea wire:model="kegiatanList.{{ $index }}.kegiatan" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500 placeholder-slate-300" placeholder="Contoh: Melakukan pemeriksaan tanda vital pasien rawat inap..."></textarea>
                        @error("kegiatanList.$index.kegiatan") <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Hasil / Output</label>
                        <input type="text" wire:model="kegiatanList.{{ $index }}.output" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500 placeholder-slate-300" placeholder="Contoh: 10 Pasien Terlayani">
                    </div>
                </div>

                <!-- Status & Action -->
                <div class="lg:col-span-3 flex flex-col justify-between gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Progress</label>
                        <div class="flex items-center gap-2">
                            <input type="range" wire:model.live="kegiatanList.{{ $index }}.progress" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                            <span class="text-xs font-black w-10 text-right">{{ $kegiatanList[$index]['progress'] }}%</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-2">
                        @if(count($kegiatanList) > 1)
                            <button wire:click="removeKegiatan({{ $index }})" class="flex items-center gap-2 text-xs font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                Hapus
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Add Button -->
    <button wire:click="addKegiatan" class="w-full py-4 border-2 border-dashed border-slate-300 rounded-[2rem] text-slate-400 font-bold hover:border-blue-400 hover:text-blue-500 hover:bg-blue-50/50 transition-all flex flex-col items-center justify-center gap-2 group">
        <div class="p-2 bg-slate-100 rounded-full group-hover:bg-blue-100 transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        </div>
        <span>Tambah Kegiatan Lain</span>
    </button>

    <!-- Catatan Umum -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <label class="block text-sm font-black text-slate-800 mb-2">Catatan Tambahan / Kendala (Opsional)</label>
        <textarea wire:model="catatanHarian" rows="3" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500"></textarea>
    </div>

    <!-- Action Bar Sticky Bottom -->
    <div class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-md border-t border-slate-200 p-4 md:pl-[300px] z-30">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4">
            <p class="text-xs font-bold text-slate-400 hidden md:block">Pastikan data yang diinput benar sebelum dikirim.</p>
            <div class="flex gap-3 ml-auto">
                <a href="{{ route('aktivitas.index') }}" class="px-6 py-3 rounded-xl border border-slate-300 text-slate-600 font-bold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button wire:click="save('Draft')" class="px-6 py-3 rounded-xl bg-slate-800 text-white font-bold hover:bg-slate-900 transition-colors shadow-lg shadow-slate-200">
                    Simpan Draft
                </button>
                <button wire:click="save('Diajukan')" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Kirim Laporan
                </button>
            </div>
        </div>
    </div>
</div>