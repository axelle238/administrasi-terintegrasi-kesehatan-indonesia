<div class="max-w-xl mx-auto py-12">
    <div class="bg-white rounded-[3rem] shadow-xl overflow-hidden relative">
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-blue-600 to-indigo-700"></div>
        
        <div class="relative pt-12 px-8 pb-8 text-center">
            <!-- Clock Circle -->
            <div class="w-40 h-40 bg-white rounded-full flex items-center justify-center mx-auto shadow-2xl mb-6 relative z-10 border-4 border-blue-50">
                <div class="text-center">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu Sekarang</p>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tighter" wire:poll.1s>{{ \Carbon\Carbon::now()->format('H:i:s') }}</h2>
                    <p class="text-[10px] font-bold text-blue-500">{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</p>
                </div>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-2">Presensi Digital</h3>
            <p class="text-slate-500 text-sm mb-8">Sistem akan mencatat lokasi dan waktu Anda secara akurat.</p>

            @if(!$todayPresensi)
                <button wire:click="absenMasuk" class="w-full py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-2xl font-black text-lg shadow-lg shadow-emerald-500/30 hover:scale-[1.02] transition-transform flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    ABSEN MASUK
                </button>
                <p class="text-[10px] text-slate-400 mt-4 font-medium italic">* Otomatis membuat draft Laporan Aktivitas.</p>
            @elseif(!$todayPresensi->jam_keluar)
                <div class="bg-blue-50 rounded-2xl p-4 mb-6 border border-blue-100">
                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-1">Status Anda</p>
                    <p class="text-lg font-black text-slate-800">Sedang Bekerja</p>
                    <p class="text-xs text-slate-500 mt-1">Masuk: {{ $todayPresensi->jam_masuk->format('H:i') }}</p>
                </div>
                <button wire:click="absenKeluar" class="w-full py-4 bg-gradient-to-r from-rose-500 to-rose-600 text-white rounded-2xl font-black text-lg shadow-lg shadow-rose-500/30 hover:scale-[1.02] transition-transform flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    ABSEN PULANG
                </button>
            @else
                <div class="bg-slate-100 rounded-2xl p-6 border border-slate-200">
                    <svg class="w-12 h-12 text-emerald-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <h4 class="font-bold text-slate-800">Presensi Selesai</h4>
                    <p class="text-xs text-slate-500 mt-1">Anda sudah menyelesaikan jam kerja hari ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>