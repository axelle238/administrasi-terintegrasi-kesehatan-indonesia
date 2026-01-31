<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Manajemen Lembur</h2>
            <p class="text-sm text-slate-500">Ajukan surat perintah lembur untuk pekerjaan di luar jam dinas.</p>
        </div>
        @if(!$isOpen)
        <button wire:click="create" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Ajukan Lembur
        </button>
        @endif
    </div>

    @if($isOpen)
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-indigo-100 animate-fade-in relative">
        <button wire:click="$set('isOpen', false)" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        
        <h3 class="text-lg font-bold text-slate-800 mb-6">Formulir Pengajuan Lembur</h3>
        
        <form wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Tanggal Lembur</label>
                    <input type="date" wire:model="tanggal" class="w-full rounded-xl border-slate-200 font-bold">
                    @error('tanggal') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Jam Mulai</label>
                    <input type="time" wire:model="jam_mulai" class="w-full rounded-xl border-slate-200 font-bold">
                    @error('jam_mulai') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">Jam Selesai</label>
                    <input type="time" wire:model="jam_selesai" class="w-full rounded-xl border-slate-200 font-bold">
                    @error('jam_selesai') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Alasan Lembur</label>
                <textarea wire:model="alasan_lembur" rows="2" class="w-full rounded-xl border-slate-200 font-medium" placeholder="Contoh: Menyelesaikan laporan akhir bulan..."></textarea>
                @error('alasan_lembur') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 mb-1">Target Output</label>
                <textarea wire:model="output_kerja" rows="2" class="w-full rounded-xl border-slate-200 font-medium" placeholder="Contoh: Laporan terkirim ke Dinkes..."></textarea>
                @error('output_kerja') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
    @endif

    <!-- List -->
    <div class="space-y-4">
        @forelse($lemburs as $l)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-sm font-black text-slate-800">{{ \Carbon\Carbon::parse($l->tanggal)->translatedFormat('l, d F Y') }}</span>
                    <span class="text-xs bg-slate-100 px-2 py-1 rounded font-mono font-bold text-slate-600">
                        {{ \Carbon\Carbon::parse($l->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($l->jam_selesai)->format('H:i') }}
                    </span>
                </div>
                <p class="text-sm text-slate-600">{{ $l->alasan_lembur }}</p>
                <p class="text-xs text-slate-400 mt-1">Output: {{ $l->output_kerja }}</p>
            </div>
            
            <div class="flex items-center gap-4">
                <span class="px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest 
                    {{ $l->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : ($l->status == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                    {{ $l->status }}
                </span>
                
                @if($l->status == 'Menunggu')
                <button wire:click="cancel({{ $l->id }})" class="text-red-400 hover:text-red-600 font-bold text-xs uppercase tracking-wider">Batal</button>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-slate-400 font-bold bg-white rounded-[2.5rem] border border-slate-100">
            Belum ada riwayat lembur.
        </div>
        @endforelse
    </div>
</div>
