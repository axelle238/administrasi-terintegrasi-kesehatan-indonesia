<div class="min-h-screen bg-teal-50 flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[600px] flex flex-col">
        <!-- Header -->
        <div class="bg-teal-600 p-8 text-center text-white">
            <h1 class="text-4xl font-extrabold tracking-tight">PUSKESMAS JAGAKARSA</h1>
            <p class="text-teal-100 text-lg mt-2">Mesin Antrean Mandiri (Self Service Kiosk)</p>
        </div>

        <div class="flex-grow p-8 flex flex-col items-center justify-center">
            
            <!-- STEP 1: Input Identitas -->
            @if($step === 1)
                <div class="w-full max-w-lg text-center space-y-8">
                    <h2 class="text-2xl font-bold text-gray-800">Silakan Masukkan NIK atau Nomor BPJS Anda</h2>
                    
                    <div>
                        <input wire:model="identifier" type="number" class="w-full text-center text-3xl font-mono tracking-widest p-4 rounded-xl border-2 border-teal-200 focus:border-teal-500 focus:ring-teal-500" placeholder="Nomor Kartu / NIK" autofocus>
                        @error('identifier') <p class="text-red-500 mt-2 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- On-screen Numpad (Optional Visual) -->
                    <div class="grid grid-cols-3 gap-4 max-w-xs mx-auto">
                        @foreach([1,2,3,4,5,6,7,8,9] as $n)
                            <button onclick="document.getElementById('numpad-target').value += '{{ $n }}'; @this.set('identifier', document.getElementById('numpad-target').value)" class="p-4 bg-gray-100 rounded-lg text-xl font-bold hover:bg-gray-200 active:bg-gray-300">{{ $n }}</button>
                        @endforeach
                        <button onclick="document.getElementById('numpad-target').value = ''; @this.set('identifier', '')" class="p-4 bg-red-100 text-red-600 rounded-lg font-bold hover:bg-red-200">C</button>
                        <button onclick="document.getElementById('numpad-target').value += '0'; @this.set('identifier', document.getElementById('numpad-target').value)" class="p-4 bg-gray-100 rounded-lg text-xl font-bold hover:bg-gray-200">0</button>
                        <button wire:click="checkPasien" class="p-4 bg-teal-600 text-white rounded-lg font-bold hover:bg-teal-700">OK</button>
                    </div>
                    <!-- Hidden input helper for numpad logic above if strictly JS needed, but wire:model is fine for physical keyboard -->
                    <input id="numpad-target" type="hidden">
                </div>
            @endif

            <!-- STEP 2: Pilih Poli -->
            @if($step === 2)
                <div class="w-full text-center space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Halo, {{ $pasien->nama_lengkap }}</h2>
                        <p class="text-gray-500">Silakan pilih layanan tujuan Anda hari ini:</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($polis as $poli)
                            <button wire:click="selectPoli({{ $poli->id }})" class="p-8 bg-white border-2 border-teal-100 rounded-2xl hover:border-teal-500 hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col items-center gap-4 group">
                                <div class="w-16 h-16 bg-teal-50 rounded-full flex items-center justify-center text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <span class="text-xl font-bold text-gray-800">{{ $poli->nama_poli }}</span>
                            </button>
                        @endforeach
                    </div>
                    
                    <button wire:click="resetKiosk" class="text-gray-400 underline hover:text-gray-600">Batal / Kembali</button>
                </div>
            @endif

            <!-- STEP 3: Cetak Tiket -->
            @if($step === 3)
                <div class="w-full max-w-md text-center space-y-8 animate-fade-in">
                    <div class="bg-white border-2 border-gray-800 p-8 rounded-xl shadow-lg relative print-area">
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-teal-600 text-white px-4 py-1 rounded-full text-sm font-bold">
                            TIKET ANTREAN
                        </div>
                        <h3 class="text-gray-500 text-lg uppercase tracking-widest mt-2">{{ $pasien->poli_tujuan ?? 'POLI UMUM' }}</h3>
                        <div class="text-6xl font-black text-gray-900 my-4">{{ $nomor_antrean }}</div>
                        <p class="text-gray-600">{{ now()->translatedFormat('l, d F Y H:i') }}</p>
                        <p class="mt-4 font-bold text-lg">{{ $pasien->nama_lengkap }}</p>
                        <p class="text-sm text-gray-400">{{ $pasien->no_bpjs ?? 'UMUM' }}</p>
                        <div class="mt-6 pt-4 border-t border-dashed border-gray-300 text-xs text-gray-400">
                            Silakan menunggu di ruang tunggu. <br> Nomor Anda akan dipanggil.
                        </div>
                    </div>

                    <div class="space-y-4 no-print">
                        <p class="text-green-600 font-bold text-xl">Berhasil Mengambil Antrean!</p>
                        <p class="text-gray-500">Tiket sedang dicetak...</p>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-4">
                            <div class="bg-teal-600 h-2.5 rounded-full animate-progress" style="width: 100%"></div>
                        </div>

                        <script>
                            // Auto Print & Reset
                            document.addEventListener('livewire:initialized', () => {
                                window.print();
                                setTimeout(() => {
                                    @this.call('resetKiosk');
                                }, 5000);
                            });
                        </script>
                        
                        <button wire:click="resetKiosk" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Selesai</button>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<style>
    @keyframes progress { from { width: 0%; } to { width: 100%; } }
    .animate-progress { animation: progress 5s linear; }
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; width: 100%; border: none; shadow: none; }
        .no-print { display: none; }
    }
</style>
