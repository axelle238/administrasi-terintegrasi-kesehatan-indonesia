<div class="min-h-screen bg-slate-100 flex flex-col p-6" wire:poll.5s>
    <!-- Header Monitor -->
    <div class="bg-white rounded-[2rem] p-6 shadow-xl border border-slate-200 flex items-center justify-between mb-8">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">MONITOR ANTREAN</h1>
                <p class="text-sm font-bold text-blue-600 uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }} | <span id="clock" class="text-slate-900">{{ now()->format('H:i:s') }}</span></p>
            </div>
        </div>
        <div class="text-right">
            <div class="px-6 py-3 bg-slate-900 rounded-2xl">
                <span class="text-blue-400 font-black text-xl tracking-tighter">SATRIA</span>
                <span class="text-white font-black text-xl tracking-tighter ml-1 italic">Health</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 flex-1">
        
        <!-- Panggilan Utama (Kiri) -->
        <div class="lg:col-span-8 flex flex-col gap-8">
            <div class="bg-white rounded-[3rem] p-10 shadow-2xl border-4 border-blue-600 flex-1 flex flex-col items-center justify-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-blue-600"></div>
                <div class="text-center">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-[0.5em] mb-6 block">Sedang Dilayani</span>
                    
                    @if($sedangDipanggil)
                        <h2 class="text-[12rem] font-black text-slate-900 leading-none tracking-tighter mb-4 animate-pulse">{{ $sedangDipanggil->nomor_antrean }}</h2>
                        <div class="px-12 py-4 bg-blue-600 rounded-full inline-block shadow-2xl shadow-blue-600/30">
                            <span class="text-3xl font-black text-white uppercase tracking-widest">{{ $sedangDipanggil->poli->nama_poli ?? 'POLI UMUM' }}</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-500 mt-10">Atas Nama: <span class="text-slate-900">{{ $sedangDipanggil->pasien->nama_pasien ?? 'Pasien Umum' }}</span></p>
                    @else
                        <div class="py-20">
                            <h2 class="text-4xl font-black text-slate-300 uppercase tracking-widest">Belum Ada Panggilan</h2>
                            <p class="text-slate-400 mt-4 font-bold">Silakan menunggu nomor antrean Anda dipanggil</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Video atau Informasi Running Text -->
            <div class="h-32 bg-slate-900 rounded-[2rem] p-6 flex items-center overflow-hidden shadow-2xl relative">
                <div class="absolute left-0 top-0 h-full w-24 bg-gradient-to-r from-slate-900 to-transparent z-10"></div>
                <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-slate-900 to-transparent z-10"></div>
                <div class="whitespace-nowrap flex items-center gap-20">
                    <p class="text-white text-2xl font-bold italic tracking-wide animate-marquee">
                        Selamat Datang di Sistem Layanan Terpadu • Harap tertib menunggu antrean • Jaga protokol kesehatan • Pendaftaran ditutup pukul 14:00 WIB • Gunakan fasilitas Kiosk Mandiri untuk pendaftaran cepat • Kami melayani dengan hati
                    </p>
                </div>
            </div>
        </div>

        <!-- Daftar Tunggu (Kanan) -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            <!-- Farmasi (Jika Ada) -->
            @if($sedangDipanggilFarmasi)
            <div class="bg-emerald-50 rounded-[2.5rem] shadow-xl border border-emerald-200 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-500 rounded-bl-full opacity-20"></div>
                <p class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-2">Antrean Obat</p>
                <div class="flex justify-between items-end">
                    <span class="text-4xl font-black text-slate-900">{{ $sedangDipanggilFarmasi->nomor_antrean }}</span>
                    <span class="text-sm font-bold text-emerald-600">Silakan ke Apotek</span>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 overflow-hidden flex flex-col flex-1">
                <div class="bg-slate-50 p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest">Antrean Berikutnya</h3>
                </div>
                
                <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar">
                    @forelse($antreanBerikutnya as $antrean)
                        <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-slate-100 shadow-sm">
                            <div>
                                <span class="text-3xl font-black text-slate-900 tracking-tighter">{{ $antrean->nomor_antrean }}</span>
                                <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mt-1">{{ $antrean->poli->nama_poli ?? 'UMUM' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold text-slate-400">STATUS</span>
                                <p class="text-xs font-black text-emerald-600 uppercase tracking-widest mt-1">SIAP</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-20 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <p class="text-slate-400 font-bold text-sm">Tidak ada antrean tunggu</p>
                        </div>
                    @endforelse
                </div>

                <!-- Next Info -->
                <div class="p-6 bg-slate-900 text-center">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2">Didukung Oleh</p>
                    <span class="text-white font-black text-lg tracking-tighter italic">SATRIA HEALTHCARE</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            display: inline-block;
            animation: marquee 30s linear infinite;
        }
    </style>

    <script>
        setInterval(() => {
            const clock = document.getElementById('clock');
            if(clock) clock.innerText = new Date().toLocaleTimeString('en-GB');
        }, 1000);
    </script>
</div>