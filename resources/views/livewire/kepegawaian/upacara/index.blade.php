<div class="space-y-8 animate-fade-in">
    
    <!-- Header Info -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-xl">
        <div class="absolute right-0 top-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="px-3 py-1 rounded-full bg-white/10 border border-white/20 text-[10px] font-bold uppercase tracking-widest text-blue-200">Kedisiplinan</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                </div>
                <h2 class="text-3xl font-black tracking-tight">Presensi Upacara</h2>
                <p class="text-slate-400 text-sm mt-1 max-w-lg">
                    Pencatatan kehadiran upacara rutin dan hari besar nasional. Data yang Anda input akan <span class="text-white font-bold underline decoration-blue-400">otomatis tercatat</span> ke dalam Laporan Aktivitas Harian (LKH).
                </p>
            </div>
            
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/10">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" /></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- FORM SECTION -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm sticky top-24">
                <h3 class="font-black text-slate-800 text-lg mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    Input Kehadiran
                </h3>

                @if (session()->has('message'))
                    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-xs font-bold mb-6 flex items-center gap-2 border border-emerald-100">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="save" class="space-y-5">
                    
                    <!-- Jenis Upacara -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis Upacara</label>
                        <div class="relative">
                            <select wire:model="jenis_upacara_id" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-700 focus:border-blue-500 focus:ring-blue-500 py-3 pl-4 pr-10 appearance-none bg-slate-50 hover:bg-white transition-colors cursor-pointer">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($jenisUpacaraList as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_upacara }} ({{ $jenis->kategori }})</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        @error('jenis_upacara_id') <span class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Pelaksanaan</label>
                        <input type="date" wire:model="tanggal" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-700 focus:border-blue-500 focus:ring-blue-500 py-3 bg-slate-50 hover:bg-white transition-colors">
                        @error('tanggal') <span class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Foto Bukti -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Foto Bukti (Selfie di Lokasi)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-blue-300 transition-all group overflow-hidden relative">
                                
                                @if ($bukti_foto)
                                    <img src="{{ $bukti_foto->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-white text-xs font-bold">Ganti Foto</span>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        <p class="text-xs text-slate-500 font-medium">Klik untuk upload foto</p>
                                    </div>
                                @endif
                                
                                <input id="dropzone-file" type="file" wire:model="bukti_foto" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        @error('bukti_foto') <span class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Keterangan Tambahan</label>
                        <textarea wire:model="keterangan" rows="2" placeholder="Lokasi atau catatan khusus..." class="w-full rounded-xl border-slate-200 text-sm font-medium text-slate-700 focus:border-blue-500 focus:ring-blue-500 bg-slate-50 hover:bg-white transition-colors"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold uppercase tracking-wider shadow-lg shadow-blue-600/20 hover:shadow-blue-600/40 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="save">Simpan Kehadiran</span>
                        <span wire:loading wire:target="save">Memproses...</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- HISTORY SECTION -->
        <div class="lg:col-span-2">
            <h3 class="font-black text-slate-800 text-lg mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Riwayat Upacara
            </h3>

            <div class="space-y-4">
                @forelse($riwayat as $item)
                <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 hover:border-blue-200 hover:shadow-md transition-all group relative">
                    <div class="flex items-start gap-5">
                        <!-- Date Badge -->
                        <div class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 shrink-0">
                            <span class="text-[10px] font-bold uppercase">{{ $item->tanggal->translatedFormat('M') }}</span>
                            <span class="text-xl font-black">{{ $item->tanggal->format('d') }}</span>
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-lg">{{ $item->jenisUpacara->nama_upacara }}</h4>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-0.5">{{ $item->jenisUpacara->kategori }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-wide">
                                        {{ $item->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                                @if($item->is_integrated_lkh)
                                    <span class="flex items-center gap-1 text-blue-600 font-bold bg-blue-50 px-2 py-0.5 rounded-md" title="Terintegrasi ke LKH">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        LKH Sync
                                    </span>
                                @endif
                                
                                @if($item->keterangan)
                                    <span class="flex items-center gap-1 truncate max-w-[200px]">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                                        {{ $item->keterangan }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Delete Action -->
                    <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus data presensi upacara ini?" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all p-2 rounded-full hover:bg-red-50">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </div>
                @empty
                <div class="text-center py-12 bg-slate-50 rounded-[2rem] border border-dashed border-slate-200">
                    <p class="text-slate-400 font-medium">Belum ada riwayat upacara.</p>
                </div>
                @endforelse

                {{ $riwayat->links() }}
            </div>
        </div>
    </div>
</div>