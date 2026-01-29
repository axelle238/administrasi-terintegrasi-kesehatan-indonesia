<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-lg flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-indigo-200 uppercase tracking-widest mb-1">Total Dinas</p>
                <h3 class="text-3xl font-black">{{ $totalJadwalHariIni }}</h3>
                <p class="text-[10px] mt-1 opacity-80">Pegawai terjadwal pada {{ \Carbon\Carbon::parse($dateFilter)->format('d M Y') }}</p>
            </div>
            <div class="p-3 bg-white/10 rounded-xl">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
        </div>

        <div class="md:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-4">
            @foreach($statsShift as $stat)
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-center items-center text-center">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $stat->shift->nama_shift ?? 'Shift' }}</span>
                    <span class="text-xl font-black text-slate-800">{{ $stat->total }}</span>
                    <span class="text-[10px] text-slate-500 font-mono">{{ $stat->shift->jam_masuk ?? '-' }} - {{ $stat->shift->jam_keluar ?? '-' }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Controls -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4 w-full md:w-auto">
            <input type="date" wire:model.live="dateFilter" class="rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            
            <select wire:model.live="pegawaiFilter" class="rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Pegawai</option>
                @foreach($pegawais as $p)
                    <option value="{{ $p->id }}">{{ $p->user->name }}</option>
                @endforeach
            </select>
        </div>

        <a href="{{ route('jadwal-jaga.create') }}" wire:navigate class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Buat Jadwal
        </a>
    </div>

    <!-- Timeline List -->
    <div class="space-y-4">
        @forelse($jadwals as $jadwal)
            <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row items-center gap-4">
                <!-- Time Column -->
                <div class="flex flex-col items-center justify-center w-full md:w-32 border-b md:border-b-0 md:border-r border-slate-100 pb-4 md:pb-0 pr-0 md:pr-4">
                    <span class="text-lg font-black text-slate-800">{{ \Carbon\Carbon::parse($jadwal->shift->jam_masuk)->format('H:i') }}</span>
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">s/d</span>
                    <span class="text-lg font-black text-slate-400">{{ \Carbon\Carbon::parse($jadwal->shift->jam_keluar)->format('H:i') }}</span>
                </div>

                <!-- Info Column -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-1">
                        <h4 class="text-lg font-bold text-slate-900">{{ $jadwal->pegawai->user->name }}</h4>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">{{ $jadwal->shift->nama_shift }}</span>
                    </div>
                    <p class="text-sm text-slate-500 flex items-center justify-center md:justify-start gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        {{ $jadwal->ruangan->nama_ruangan ?? 'Unit Umum' }}
                    </p>
                </div>

                <!-- Action Column -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('jadwal-jaga.edit', $jadwal->id) }}" wire:navigate class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </a>
                    <button wire:click="delete({{ $jadwal->id }})" wire:confirm="Hapus jadwal ini?" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-slate-400">
                Tidak ada jadwal jaga pada tanggal ini.
            </div>
        @endforelse
    </div>

    {{ $jadwals->links() }}
</div>
