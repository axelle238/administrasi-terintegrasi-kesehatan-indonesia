<div class="space-y-6 animate-fade-in">
    <!-- Header Controls -->
    <div class="flex justify-between items-center bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <h2 class="text-lg font-black text-slate-800">Jadwal {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</h2>
        <div class="flex gap-2">
            <select wire:model.live="bulan" class="rounded-xl border-slate-200 text-sm font-bold">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <select wire:model.live="tahun" class="rounded-xl border-slate-200 text-sm font-bold">
                @foreach(range(now()->year, now()->year+1) as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Selection Panel (Inline - No Modal) -->
    @if($isOpen)
    <div class="bg-white rounded-[2rem] p-8 border border-blue-100 shadow-xl shadow-blue-500/5 animate-fade-in-up mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="font-black text-slate-800 text-lg">Plotting Jadwal Kerja</h3>
                <p class="text-sm text-slate-500">Menentukan shift untuk <span class="font-bold text-blue-600">{{ $pegawais->find($selectedPegawaiId)->user->name ?? 'Pegawai' }}</span> pada tanggal <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</span></p>
            </div>
            <button wire:click="$set('isOpen', false)" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <button wire:click="$set('inputShiftId', null)" class="p-4 rounded-2xl border-2 {{ is_null($inputShiftId) ? 'border-slate-800 bg-slate-50 text-slate-800' : 'border-slate-100 text-slate-400 hover:border-slate-200' }} font-black text-xs uppercase tracking-widest transition-all flex flex-col items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                Libur / OFF
            </button>
            @foreach($shifts as $s)
                <button wire:click="$set('inputShiftId', {{ $s->id }})" class="p-4 rounded-2xl border-2 font-black text-xs uppercase tracking-widest transition-all flex flex-col items-center gap-2"
                    style="{{ $inputShiftId == $s->id ? 'border-color:'.$s->color.'; background-color:'.$s->color.'10; color:'.$s->color : 'border-color:#f1f5f9; color:#64748b' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white" style="background-color: {{ $s->color }}">
                        {{ substr($s->nama_shift, 0, 1) }}
                    </div>
                    {{ $s->nama_shift }}
                    <span class="block text-[9px] font-mono opacity-70">{{ \Carbon\Carbon::parse($s->jam_masuk)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->jam_keluar)->format('H:i') }}</span>
                </button>
            @endforeach
        </div>

        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-50">
            <button wire:click="$set('isOpen', false)" class="px-6 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl uppercase tracking-widest">Batal</button>
            <button wire:click="saveJadwal" class="px-8 py-2.5 bg-blue-600 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition-all uppercase tracking-widest">Simpan Jadwal</button>
        </div>
    </div>
    @endif

    <!-- Spreadsheet Matrix -->
</div>