<div class="max-w-xl mx-auto py-8">
    <!-- Header Card -->
    <div class="bg-white rounded-[3rem] shadow-xl overflow-hidden relative border border-slate-100">
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-blue-600 to-indigo-700"></div>
        
        <div class="relative pt-10 px-8 pb-8 text-center">
            <!-- Clock Circle -->
            <div class="w-36 h-36 bg-white rounded-full flex items-center justify-center mx-auto shadow-2xl mb-6 relative z-10 border-4 border-blue-50">
                <div class="text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu Server</p>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tighter" wire:poll.1s>{{ \Carbon\Carbon::now()->format('H:i:s') }}</h2>
                    <p class="text-[10px] font-bold text-blue-500">{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</p>
                </div>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-1">Presensi Digital</h3>
            <p class="text-slate-500 text-sm mb-6">Pilih mode kerja dan lakukan presensi.</p>

            @if(!$todayPresensi)
                <!-- Selector Mode Kerja Utama -->
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <button wire:click="setKategori('WFO')" class="p-3 rounded-2xl border-2 {{ $kategoriInduk === 'WFO' ? 'border-blue-500 bg-blue-50 text-blue-700 ring-2 ring-blue-200' : 'border-slate-100 bg-white text-slate-500 hover:border-blue-200' }} transition-all flex flex-col items-center gap-2">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        <span class="text-[10px] font-bold uppercase">Kantor (WFO)</span>
                    </button>
                    <button wire:click="setKategori('Dinas Luar')" class="p-3 rounded-2xl border-2 {{ $kategoriInduk === 'Dinas Luar' ? 'border-emerald-500 bg-emerald-50 text-emerald-700 ring-2 ring-emerald-200' : 'border-slate-100 bg-white text-slate-500 hover:border-emerald-200' }} transition-all flex flex-col items-center gap-2">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-[10px] font-bold uppercase">Dinas Luar</span>
                    </button>
                    <button wire:click="setKategori('WFH')" class="p-3 rounded-2xl border-2 {{ $kategoriInduk === 'WFH' ? 'border-purple-500 bg-purple-50 text-purple-700 ring-2 ring-purple-200' : 'border-slate-100 bg-white text-slate-500 hover:border-purple-200' }} transition-all flex flex-col items-center gap-2">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        <span class="text-[10px] font-bold uppercase">Rumah (WFH)</span>
                    </button>
                </div>

                <!-- Sub-Selector Dinas Luar (Conditional) -->
                @if($kategoriInduk === 'Dinas Luar')
                <div class="bg-emerald-50 rounded-2xl p-4 mb-6 border border-emerald-100 animate-fade-in-up">
                    <p class="text-xs font-bold text-emerald-700 uppercase mb-3 text-left">Pilih Durasi Dinas Luar:</p>
                    <div class="grid grid-cols-1 gap-2">
                        <button wire:click="setSubKategori('Dinas Luar Awal')" class="flex justify-between items-center px-4 py-3 rounded-xl border-2 {{ $subKategori === 'Dinas Luar Awal' ? 'bg-white border-emerald-500 shadow-md' : 'bg-white/50 border-emerald-200 hover:bg-white' }} transition-all text-left">
                            <div>
                                <span class="block text-xs font-black text-slate-700 uppercase">DL Awal</span>
                                <span class="block text-[10px] text-slate-500 font-medium">Kompensasi: 07:30 - 11:59</span>
                            </div>
                            @if($subKategori === 'Dinas Luar Awal') <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> @endif
                        </button>
                        
                        <button wire:click="setSubKategori('Dinas Luar Akhir')" class="flex justify-between items-center px-4 py-3 rounded-xl border-2 {{ $subKategori === 'Dinas Luar Akhir' ? 'bg-white border-emerald-500 shadow-md' : 'bg-white/50 border-emerald-200 hover:bg-white' }} transition-all text-left">
                            <div>
                                <span class="block text-xs font-black text-slate-700 uppercase">DL Akhir</span>
                                <span class="block text-[10px] text-slate-500 font-medium">Kompensasi: 12:00 - 16:00</span>
                            </div>
                            @if($subKategori === 'Dinas Luar Akhir') <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> @endif
                        </button>

                        <button wire:click="setSubKategori('Dinas Luar Penuh')" class="flex justify-between items-center px-4 py-3 rounded-xl border-2 {{ $subKategori === 'Dinas Luar Penuh' ? 'bg-white border-emerald-500 shadow-md' : 'bg-white/50 border-emerald-200 hover:bg-white' }} transition-all text-left">
                            <div>
                                <span class="block text-xs font-black text-slate-700 uppercase">DL Penuh</span>
                                <span class="block text-[10px] text-slate-500 font-medium">Kompensasi: 07:30 - 16:00</span>
                            </div>
                            @if($subKategori === 'Dinas Luar Penuh') <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> @endif
                        </button>
                    </div>
                </div>
                @endif

                <!-- Keterangan Otomatis -->
                <div class="mb-6 p-4 rounded-xl bg-slate-50 border border-slate-100 text-left">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Keterangan Aktivitas Otomatis</p>
                    <p class="text-xs text-slate-700 italic">
                        @if($kategoriInduk === 'WFO')
                            "Melakukan presensi masuk di Kantor Pusat. Siap bekerja rutin."
                        @elseif($kategoriInduk === 'Dinas Luar')
                            @if($subKategori)
                                "Melakukan Dinas Luar ({{ str_replace('Dinas Luar ', '', $subKategori) }}) sesuai surat tugas."
                            @else
                                "Silakan pilih jenis Dinas Luar di atas."
                            @endif
                        @else
                            "Bekerja dari rumah (WFH) dan siap dihubungi."
                        @endif
                    </p>
                </div>

                <!-- Tombol Aksi -->
                @if($kategoriInduk === 'Dinas Luar' && !$subKategori)
                    <button disabled class="w-full py-4 bg-slate-200 text-slate-400 rounded-2xl font-black text-lg cursor-not-allowed flex items-center justify-center gap-3">
                        PILIH JENIS DL
                    </button>
                @else
                    <button wire:click="absenMasuk" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-black text-lg shadow-lg shadow-blue-500/30 hover:scale-[1.02] transition-transform flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                        KONFIRMASI KEHADIRAN
                    </button>
                @endif

            @elseif(!$todayPresensi->jam_keluar)
                <div class="bg-blue-50 rounded-2xl p-6 mb-6 border border-blue-100 text-left relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-1">Status Kehadiran</p>
                        <p class="text-2xl font-black text-slate-800 mb-1">{{ $todayPresensi->kategori }}</p>
                        <p class="text-xs text-slate-500 font-mono">Check-in: {{ $todayPresensi->jam_masuk->format('H:i') }} WIB</p>
                    </div>
                </div>
                <button wire:click="absenKeluar" class="w-full py-4 bg-gradient-to-r from-rose-500 to-rose-600 text-white rounded-2xl font-black text-lg shadow-lg shadow-rose-500/30 hover:scale-[1.02] transition-transform flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    ABSEN PULANG
                </button>
            @else
                <div class="bg-slate-100 rounded-2xl p-8 border border-slate-200">
                    <svg class="w-16 h-16 text-emerald-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <h4 class="text-xl font-black text-slate-800">Selesai Bertugas</h4>
                    <p class="text-sm text-slate-500 mt-2">Terima kasih atas dedikasi Anda hari ini.</p>
                    <div class="mt-6 flex justify-center gap-4 text-xs font-bold text-slate-600">
                        <div class="bg-white px-4 py-2 rounded-lg border border-slate-200">
                            Masuk: {{ $todayPresensi->jam_masuk->format('H:i') }}
                        </div>
                        <div class="bg-white px-4 py-2 rounded-lg border border-slate-200">
                            Keluar: {{ $todayPresensi->jam_keluar->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>