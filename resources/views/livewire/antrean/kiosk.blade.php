<div class="min-h-screen bg-slate-900 flex flex-col items-center justify-center p-6 relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 -mr-40 -mt-40 w-96 h-96 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
    <div class="absolute bottom-0 left-0 -ml-40 -mb-40 w-96 h-96 bg-cyan-600 rounded-full blur-3xl opacity-20"></div>

    <div class="max-w-4xl w-full relative z-10">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 rounded-3xl shadow-2xl mb-6">
                <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter mb-4 uppercase">Mandiri Antrean</h1>
            <p class="text-slate-400 text-lg font-bold tracking-widest uppercase">Pelayanan Cepat Tanpa Antre di Loket</p>
        </div>

        <!-- Step 1: Identifikasi -->
        @if($step == 1)
            <div x-data="{ num: '' }" class="bg-white/10 backdrop-blur-xl rounded-[3rem] p-8 md:p-16 border border-white/10 shadow-3xl">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-black text-white mb-2">Selamat Datang</h2>
                    <p class="text-slate-400">Silakan masukkan NIK atau Nomor Kartu BPJS Anda</p>
                </div>

                <div class="space-y-8">
                    <input 
                        type="text" 
                        wire:model="identifier" 
                        class="w-full bg-slate-800/50 border-2 border-white/10 rounded-3xl py-6 px-8 text-3xl font-black text-white text-center focus:border-blue-500 focus:ring-0 transition-all tracking-[0.2em]"
                        placeholder="•••• •••• •••• ••••"
                        maxlength="16"
                    >
                    <x-input-error :messages="$errors->get('identifier')" class="text-center text-red-400 font-bold" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <button wire:click="checkPasien" class="w-full py-6 bg-blue-600 text-white rounded-3xl font-black text-xl uppercase tracking-widest hover:bg-blue-700 transition-all shadow-2xl shadow-blue-600/30">
                            Lanjutkan
                        </button>
                        <button wire:click="resetKiosk" class="w-full py-6 bg-slate-800 text-slate-400 rounded-3xl font-black text-xl uppercase tracking-widest hover:bg-slate-700 transition-all">
                            Bersihkan
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Step 2: Pilih Poli -->
        @if($step == 2)
            <div class="space-y-8">
                <div class="text-center">
                    <h2 class="text-2xl font-black text-white mb-2">Halo, {{ $pasien->nama_lengkap }}</h2>
                    <p class="text-slate-400 font-bold uppercase tracking-widest">Silakan Pilih Poliklinik Tujuan</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($polis as $poli)
                        <button 
                            wire:click="selectPoli({{ $poli->id }})"
                            class="group bg-white/10 backdrop-blur-xl hover:bg-blue-600 rounded-[2.5rem] p-8 border border-white/10 transition-all text-left relative overflow-hidden shadow-xl"
                        >
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-150"></div>
                            <div class="relative z-10">
                                <span class="text-blue-500 group-hover:text-white font-black text-4xl mb-4 block">{{ substr($poli->nama_poli, 0, 1) }}</span>
                                <h3 class="text-2xl font-black text-white group-hover:text-white">{{ $poli->nama_poli }}</h3>
                                <p class="text-slate-400 group-hover:text-blue-100 text-sm mt-2">Ketuk untuk mengambil nomor.</p>
                            </div>
                        </button>
                    @endforeach
                </div>

                <div class="text-center pt-8">
                    <button wire:click="resetKiosk" class="text-slate-500 font-black uppercase tracking-[0.3em] hover:text-white transition-colors">
                        Batal & Kembali
                    </button>
                </div>
            </div>
        @endif

        <!-- Step 3: Cetak Tiket -->
        @if($step == 3)
            <div class="bg-white rounded-[4rem] p-12 md:p-20 text-center shadow-3xl animate-fade-in">
                <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-10 text-emerald-600">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                </div>
                
                <h2 class="text-2xl font-black text-slate-900 mb-2 uppercase tracking-tighter">Berhasil Terdaftar</h2>
                <p class="text-slate-500 font-bold uppercase tracking-widest mb-12">Nomor Antrean Anda Adalah:</p>

                <div class="inline-block px-16 py-10 bg-slate-900 rounded-[3rem] shadow-2xl mb-12">
                    <span class="text-8xl md:text-9xl font-black text-white tracking-tighter">{{ $nomor_antrean }}</span>
                </div>

                <div class="text-slate-400 font-medium mb-12">
                    <p>Silakan ambil struk Anda dan tunggu di ruang tunggu.</p>
                    <p class="text-sm mt-2 italic">Auto-reset dalam 10 detik...</p>
                </div>

                <button wire:click="resetKiosk" class="px-12 py-5 bg-blue-600 text-white rounded-3xl font-black text-sm uppercase tracking-widest shadow-xl shadow-blue-600/30 hover:bg-blue-700 transition-all">
                    Selesai
                </button>

                <script>
                    setTimeout(() => {
                        @this.resetKiosk();
                    }, 10000);
                </script>
            </div>
        @endif

    </div>

    <!-- Footer Kiosk -->
    <div class="mt-20 text-center relative z-10">
        <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.5em]">SATRIA Healthcare Digital Solutions &copy; {{ date('Y') }}</p>
    </div>
</div>