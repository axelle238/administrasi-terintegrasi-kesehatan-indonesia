<div class="min-h-screen bg-gray-100 flex flex-col" wire:poll.2s>
    <!-- Header -->
    <div class="bg-teal-700 text-white p-6 shadow-lg">
        <div class="flex justify-between items-center max-w-7xl mx-auto w-full">
            <div class="flex items-center gap-4">
                 <!-- Logo Placeholder -->
                 <div class="bg-white p-2 rounded-lg text-teal-700 font-bold text-2xl">P</div>
                 <div>
                     <h1 class="text-3xl font-bold">PUSKESMAS JAGAKARSA</h1>
                     <p class="text-teal-100">Melayani dengan Hati, Menuju Jagakarsa Sehat</p>
                 </div>
            </div>
            <div class="text-right">
                <h2 class="text-4xl font-bold">{{ now()->format('H:i') }}</h2>
                <p class="text-teal-100">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grow flex flex-col md:flex-row p-6 gap-6 max-w-7xl mx-auto w-full">
        
        <!-- Left Side: Main Displays -->
        <div class="w-full md:w-2/3 flex flex-col gap-6">
            <!-- Poli Display -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-8 border-teal-500 flex flex-col justify-center items-center p-8 relative h-1/2">
                <div class="absolute top-0 left-0 w-full bg-teal-500 text-white text-center py-2 text-xl font-bold uppercase tracking-widest">
                    Nomor Antrean Poli
                </div>
                
                @if($sedangDipanggil)
                    <div class="text-[8rem] font-black text-gray-800 leading-none animate-pulse">
                        {{ $sedangDipanggil->nomor_antrean }}
                    </div>
                    <div class="text-3xl font-bold text-teal-600 bg-teal-50 px-6 py-2 rounded-xl mt-4">
                        {{ $sedangDipanggil->poli_tujuan }}
                    </div>
                @else
                    <div class="text-gray-300 text-2xl font-bold">Belum ada panggilan</div>
                @endif
            </div>

            <!-- Pharmacy Display -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-8 border-blue-500 flex flex-col justify-center items-center p-8 relative h-1/2">
                <div class="absolute top-0 left-0 w-full bg-blue-500 text-white text-center py-2 text-xl font-bold uppercase tracking-widest">
                    Nomor Antrean Farmasi
                </div>
                
                @if($sedangDipanggilFarmasi)
                    <div class="text-[8rem] font-black text-gray-800 leading-none animate-bounce mt-4">
                        {{ $sedangDipanggilFarmasi->nomor_antrean }}
                    </div>
                    <div class="text-2xl font-medium text-gray-400 mt-2">
                        Pasien: {{ $sedangDipanggilFarmasi->pasien->nama_lengkap }}
                    </div>
                @else
                    <div class="text-gray-300 text-2xl font-bold">Belum ada panggilan</div>
                @endif
            </div>
        </div>

        <!-- Sidebar (Antrean Berikutnya) -->
        <div class="w-full md:w-1/3 flex flex-col gap-6">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden grow">
                <div class="bg-gray-800 text-white py-4 px-6 text-xl font-bold uppercase tracking-wider flex justify-between items-center">
                    <span>Antrean Berikutnya</span>
                    <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse ($antreanBerikutnya as $next)
                        <div class="p-6 flex justify-between items-center hover:bg-gray-50 transition-colors">
                            <div>
                                <div class="text-4xl font-bold text-gray-800">{{ $next->nomor_antrean }}</div>
                                <div class="text-sm text-gray-500 mt-1">{{ $next->poli_tujuan }}</div>
                            </div>
                            <div class="text-right">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Menunggu</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-gray-400 italic">
                            Tidak ada antrean menunggu
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Video / Info Placeholder -->
            <div class="bg-blue-600 rounded-2xl shadow-lg p-6 text-white text-center h-48 flex flex-col justify-center items-center">
                <h3 class="text-2xl font-bold mb-2">Info Sehat</h3>
                <p>Tetap patuhi protokol kesehatan. Gunakan masker saat berada di area Puskesmas.</p>
            </div>
        </div>
    </div>
    
    <!-- Running Text Footer -->
    <div class="bg-gray-900 text-white py-3 overflow-hidden">
        <div class="whitespace-nowrap animate-marquee">
            Selamat Datang di Puskesmas Jagakarsa. Jam Operasional: Senin-Jumat 08:00 - 15:00. Sabtu 08:00 - 12:00. | Gunakan Aplikasi Mobile JKN untuk pendaftaran online. | Jagalah kebersihan lingkungan.
        </div>
    </div>
    
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('announce-queue', (event) => {
                const data = event[0]; 
                // Play Ding Dong (Optional, create file first if needed)
                // new Audio('/sounds/dingdong.mp3').play();
                
                // Speak
                const text = `Nomor Antrean, ${data.nomor_antrean}, Silakan menuju, ${data.poli_tujuan}`;
                
                if ('speechSynthesis' in window) {
                    // Cancel previous
                    window.speechSynthesis.cancel();
                    
                    const msg = new SpeechSynthesisUtterance(text);
                    msg.lang = 'id-ID'; 
                    msg.rate = 0.8;
                    window.speechSynthesis.speak(msg);
                }
            });
        });
    </script>

    <style>
        .animate-marquee {
            animation: marquee 20s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
    </style>
</div>