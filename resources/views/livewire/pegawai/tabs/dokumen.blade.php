<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-up">
    
    <!-- KOLOM KIRI: KREDENSIAL (STR/SIP) -->
    <div class="space-y-8">
        <!-- Form Kredensial -->
        <div class="bg-blue-50 p-6 rounded-[2rem] border border-blue-100">
            <h3 class="font-black text-blue-800 text-lg mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Input Kredensial Medis
            </h3>
            
            @if (session()->has('message_kredensial'))
                <div class="bg-white text-blue-600 p-3 rounded-xl text-xs font-bold mb-4 shadow-sm">
                    {{ session('message_kredensial') }}
                </div>
            @endif

            <form wire:submit.prevent="saveKredensial" class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <input type="text" wire:model="nama_dokumen" placeholder="Nama (Contoh: STR)" class="w-full rounded-xl border-blue-200 text-sm font-bold focus:ring-blue-500 py-2.5">
                    <input type="text" wire:model="nomor_dokumen" placeholder="Nomor Dokumen" class="w-full rounded-xl border-blue-200 text-sm font-bold focus:ring-blue-500 py-2.5">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[9px] font-bold text-blue-400 uppercase ml-1">Tgl Terbit</label>
                        <input type="date" wire:model="tanggal_terbit" class="w-full rounded-xl border-blue-200 text-sm font-bold focus:ring-blue-500 py-2.5">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-blue-400 uppercase ml-1">Tgl Berakhir</label>
                        <input type="date" wire:model="tanggal_berakhir" class="w-full rounded-xl border-blue-200 text-sm font-bold focus:ring-blue-500 py-2.5">
                    </div>
                </div>
                <input type="file" wire:model="file_kredensial" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all"/>
                @error('file_kredensial') <span class="text-[10px] text-red-500 font-bold block">{{ $message }}</span> @enderror

                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-blue-500/20">
                    Simpan Data
                </button>
            </form>
        </div>

        <!-- List Kredensial -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <h4 class="font-black text-slate-800 mb-4">Dokumen Aktif</h4>
            <div class="space-y-3">
                @forelse($kredensials as $item)
                    @php
                        $daysLeft = \Carbon\Carbon::now()->diffInDays($item->tanggal_berakhir, false);
                        $statusClass = $daysLeft < 0 ? 'bg-red-50 border-red-100' : ($daysLeft < 30 ? 'bg-amber-50 border-amber-100' : 'bg-slate-50 border-slate-100');
                        $textClass = $daysLeft < 0 ? 'text-red-600' : ($daysLeft < 30 ? 'text-amber-600' : 'text-slate-600');
                    @endphp
                    <div class="p-4 rounded-2xl border {{ $statusClass }} relative group">
                        <button wire:click="deleteKredensial({{ $item->id }})" class="absolute top-2 right-2 text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                        
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h5 class="font-bold {{ $textClass }}">{{ $item->nama_dokumen }}</h5>
                                <p class="text-xs font-mono text-slate-500">{{ $item->nomor_dokumen }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase {{ $daysLeft < 0 ? 'bg-red-200 text-red-800' : ($daysLeft < 30 ? 'bg-amber-200 text-amber-800' : 'bg-emerald-100 text-emerald-700') }}">
                                {{ $daysLeft < 0 ? 'Expired' : ($daysLeft < 30 ? 'Warning' : 'Aktif') }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between text-xs mt-2">
                            <span class="text-slate-400">Exp: {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y') }}</span>
                            <a href="{{ Storage::url($item->file_dokumen) }}" target="_blank" class="font-bold text-blue-500 hover:underline">Lihat File</a>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-xs italic py-4">Belum ada data kredensial.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: ARSIP DOKUMEN -->
    <div class="space-y-8">
        <!-- Form Dokumen -->
        <div class="bg-slate-50 p-6 rounded-[2rem] border border-slate-100">
            <h3 class="font-black text-slate-800 text-lg mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                Arsip Digital Pegawai
            </h3>

            @if (session()->has('message_dokumen'))
                <div class="bg-white text-slate-600 p-3 rounded-xl text-xs font-bold mb-4 shadow-sm">
                    {{ session('message_dokumen') }}
                </div>
            @endif

            <form wire:submit.prevent="saveDokumen" class="space-y-3">
                <select wire:model="kategori_dokumen" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-700 py-2.5">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="KTP">KTP / Identitas</option>
                    <option value="KK">Kartu Keluarga</option>
                    <option value="Ijazah">Ijazah Terakhir</option>
                    <option value="Transkrip">Transkrip Nilai</option>
                    <option value="SK">SK Pengangkatan</option>
                    <option value="Lainnya">Dokumen Lainnya</option>
                </select>
                
                <input type="text" wire:model="keterangan_dokumen" placeholder="Keterangan (Opsional)" class="w-full rounded-xl border-slate-200 text-sm font-medium py-2.5">
                
                <input type="file" wire:model="file_dokumen_umum" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 transition-all"/>
                @error('file_dokumen_umum') <span class="text-[10px] text-red-500 font-bold block">{{ $message }}</span> @enderror

                <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-lg shadow-slate-800/20">
                    Arsipkan Dokumen
                </button>
            </form>
        </div>

        <!-- List Dokumen -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <h4 class="font-black text-slate-800 mb-4">Berkas Tersimpan</h4>
            <div class="grid grid-cols-2 gap-3">
                @forelse($dokumens as $doc)
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex flex-col justify-between group relative">
                    <button wire:click="deleteDokumen({{ $doc->id }})" class="absolute top-1 right-1 text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $doc->kategori }}</span>
                        <p class="text-xs font-bold text-slate-700 line-clamp-1 mt-1">{{ $doc->keterangan ?? $doc->kategori }}</p>
                    </div>
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="mt-3 text-[10px] font-bold text-blue-500 hover:underline flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Unduh
                    </a>
                </div>
                @empty
                <div class="col-span-2 text-center py-8">
                    <p class="text-slate-400 text-xs italic">Arsip kosong.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>