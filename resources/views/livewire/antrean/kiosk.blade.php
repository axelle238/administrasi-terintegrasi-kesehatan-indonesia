<div class="min-h-screen bg-slate-900 flex flex-col items-center justify-center p-6 relative overflow-hidden font-sans selection:bg-blue-500 selection:text-white">
    
    <!-- Dekorasi Latar Belakang -->
    <div class="absolute top-0 right-0 -mr-40 -mt-40 w-96 h-96 bg-blue-600 rounded-full blur-[100px] opacity-20 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 -ml-40 -mb-40 w-96 h-96 bg-cyan-600 rounded-full blur-[100px] opacity-20 animate-pulse" style="animation-delay: 2s"></div>
    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>

    <div class="max-w-5xl w-full relative z-10">
        
        <!-- Header Kiosk -->
        <div class="text-center mb-10 animate-fade-in-down">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl shadow-2xl shadow-blue-500/20 mb-6 transform hover:scale-105 transition-transform duration-500">
                <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-2 font-display">ANJUNGAN PENDAFTARAN MANDIRI</h1>
            <p class="text-slate-400 text-lg font-medium tracking-wide">Puskesmas Digital Indonesia</p>
        </div>

        <!-- TAHAP 1: Input Identitas -->
        @if($tahap == 1)
            <div class="bg-white/5 backdrop-blur-2xl rounded-[2.5rem] p-8 md:p-14 border border-white/10 shadow-2xl animate-fade-in-up">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-white mb-2">Selamat Datang</h2>
                    <p class="text-slate-400">Tempelkan kartu BPJS atau ketik NIK Anda untuk memulai.</p>
                </div>

                <div class="space-y-8 max-w-2xl mx-auto">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-blue-500 rounded-3xl blur opacity-20 group-hover:opacity-40 transition-opacity"></div>
                        <input 
                            type="text" 
                            wire:model="identitas" 
                            wire:keydown.enter="cekPasien"
                            class="relative w-full bg-slate-900/50 border-2 border-slate-700 rounded-3xl py-6 px-8 text-3xl font-bold text-white text-center focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all tracking-[0.15em] placeholder-slate-600"
                            placeholder="NIK / NO. KARTU"
                            maxlength="16"
                            inputmode="numeric"
                            autofocus
                        >
                    </div>

                    @if($pesanError)
                        <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-4 flex items-center gap-3 text-red-400 animate-shake">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <span class="font-bold">{{ $pesanError }}</span>
                        </div>
                    @endif
                    
                    <x-input-error :messages="$errors->get('identitas')" class="text-center text-red-400 font-bold" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4">
                        <button wire:click="cekPasien" class="w-full py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-bold text-lg uppercase tracking-wider hover:shadow-lg hover:shadow-blue-600/30 transform hover:-translate-y-1 transition-all">
                            Lanjutkan
                        </button>
                        <button wire:click="resetKiosk" class="w-full py-5 bg-slate-800 text-slate-400 rounded-2xl font-bold text-lg uppercase tracking-wider hover:bg-slate-700 hover:text-white transition-all">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- TAHAP 2: Konfirmasi Data -->
        @if($tahap == 2)
            <div class="bg-white/5 backdrop-blur-2xl rounded-[2.5rem] p-8 md:p-14 border border-white/10 shadow-2xl animate-fade-in-up">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-white mb-2">Konfirmasi Identitas</h2>
                    <p class="text-slate-400">Apakah data berikut sudah benar?</p>
                </div>

                <div class="bg-slate-800/50 rounded-3xl p-8 mb-10 border border-white/5 max-w-2xl mx-auto">
                    <div class="space-y-4">
                        <div class="flex justify-between border-b border-white/5 pb-4">
                            <span class="text-slate-400">Nama Lengkap</span>
                            <span class="text-xl font-bold text-white text-right">{{ $pasien->nama_lengkap }}</span>
                        </div>
                        <div class="flex justify-between border-b border-white/5 pb-4">
                            <span class="text-slate-400">NIK / BPJS</span>
                            <span class="text-xl font-bold text-white text-right">{{ $pasien->no_bpjs ?? $pasien->nik }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Tanggal Lahir</span>
                            <span class="text-xl font-bold text-white text-right">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-2xl mx-auto">
                    <button wire:click="konfirmasiPasien" class="w-full py-5 bg-emerald-500 text-white rounded-2xl font-bold text-lg uppercase tracking-wider hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 transform hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Ya, Benar
                    </button>
                    <button wire:click="resetKiosk" class="w-full py-5 bg-red-500/10 text-red-400 border border-red-500/20 rounded-2xl font-bold text-lg uppercase tracking-wider hover:bg-red-500 hover:text-white transition-all">
                        Bukan Saya
                    </button>
                </div>
            </div>
        @endif

        <!-- TAHAP 3: Pilih Poli -->
        @if($tahap == 3)
            <div class="space-y-8 animate-fade-in-up">
                <div class="text-center">
                    <h2 class="text-3xl font-black text-white mb-2">Pilih Poliklinik</h2>
                    <p class="text-slate-400">Silakan ketuk poliklinik tujuan Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($daftarPoli as $poli)
                        <button 
                            wire:click="pilihPoli({{ $poli->id }})"
                            class="group bg-slate-800/50 backdrop-blur-xl hover:bg-blue-600 rounded-[2rem] p-8 border border-white/10 transition-all text-left relative overflow-hidden shadow-xl hover:shadow-blue-600/20 transform hover:-translate-y-2 duration-300"
                        >
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-150"></div>
                            <div class="relative z-10 flex flex-col h-full justify-between">
                                <div>
                                    <span class="inline-block px-3 py-1 rounded-lg bg-blue-500/20 text-blue-400 text-xs font-bold uppercase tracking-wider mb-4 group-hover:bg-white/20 group-hover:text-white">Buka</span>
                                    <h3 class="text-2xl font-black text-white group-hover:text-white mb-1">{{ $poli->nama_poli }}</h3>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-slate-400 group-hover:text-blue-100 text-sm">Ketuk untuk pilih</span>
                                    <div class="w-10 h-10 rounded-full bg-slate-700 group-hover:bg-white text-white group-hover:text-blue-600 flex items-center justify-center transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                    </div>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>

                <div class="text-center pt-8">
                    <button wire:click="$set('tahap', 1)" class="text-slate-500 font-bold uppercase tracking-widest hover:text-white transition-colors flex items-center justify-center gap-2 mx-auto">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Kembali ke Awal
                    </button>
                </div>
            </div>
        @endif

        <!-- TAHAP 4: Cetak Tiket -->
        @if($tahap == 4)
            <div class="flex justify-center items-center py-10 animate-fade-in-up">
                <!-- Tiket Fisik Simulation -->
                <div class="bg-white text-slate-900 w-80 rounded-3xl p-6 shadow-3xl relative overflow-hidden">
                    <!-- Gerigi Kertas Atas -->
                    <div class="absolute top-0 left-0 right-0 h-4 bg-slate-900" style="mask-image: radial-gradient(circle at 10px 0, transparent 0, transparent 10px, black 11px); mask-size: 20px 20px; mask-repeat: repeat-x;"></div>
                    
                    <div class="mt-4 text-center border-b-2 border-dashed border-slate-300 pb-6 mb-6">
                        <h3 class="font-black text-xl tracking-tight">Puskesmas Digital</h3>
                        <p class="text-xs text-slate-500 uppercase tracking-widest mt-1">Nomor Antrean Anda</p>
                    </div>

                    <div class="text-center mb-6">
                        <span class="block text-7xl font-black text-slate-900 tracking-tighter">{{ $tiketAntrean->nomor_antrean }}</span>
                        <span class="inline-block mt-2 px-3 py-1 bg-slate-100 rounded text-xs font-bold uppercase text-slate-600">{{ $poliTerpilih->nama_poli }}</span>
                    </div>

                    <div class="text-center space-y-2 text-xs font-medium text-slate-500 border-t-2 border-dashed border-slate-300 pt-6">
                        <p>Pasien: <span class="text-slate-900 font-bold">{{ Str::limit($pasien->nama_lengkap, 15) }}</span></p>
                        <p>Tanggal: <span class="text-slate-900 font-bold">{{ now()->format('d/m/Y H:i') }}</span></p>
                        <p class="mt-4 text-[10px] text-slate-400">Simpan struk ini hingga dipanggil.</p>
                    </div>

                    <!-- Gerigi Kertas Bawah -->
                    <div class="absolute bottom-0 left-0 right-0 h-4 bg-slate-900" style="mask-image: radial-gradient(circle at 10px 100%, transparent 0, transparent 10px, black 11px); mask-size: 20px 20px; mask-repeat: repeat-x;"></div>
                </div>
            </div>
            
            <div class="text-center space-y-4">
                <h3 class="text-2xl font-bold text-white">Terima Kasih!</h3>
                <p class="text-slate-400">Mohon menunggu panggilan di ruang tunggu.</p>
                
                <button wire:click="resetKiosk" class="px-8 py-3 bg-white/10 text-white rounded-xl font-bold uppercase tracking-wider hover:bg-white/20 transition-all">
                    Selesai (Auto-Reset <span x-data="{ count: 10 }" x-init="setInterval(() => { if(count > 0) count--; }, 1000)" x-text="count">10</span>s)
                </button>
            </div>

            <script>
                setTimeout(() => {
                    @this.resetKiosk();
                }, 10000);
            </script>
        @endif

    </div>
    
    <!-- Loading Overlay -->
    <div wire:loading class="absolute inset-0 z-50 bg-slate-900/80 backdrop-blur-sm flex items-center justify-center flex-col">
        <div class="w-16 h-16 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mb-4"></div>
        <p class="text-white font-bold tracking-widest animate-pulse">MEMPROSES...</p>
    </div>
</div>
