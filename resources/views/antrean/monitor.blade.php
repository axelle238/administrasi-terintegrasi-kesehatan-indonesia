<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitor Antrean - Puskesmas Jagakarsa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #f3f4f6; font-family: 'Inter', sans-serif; overflow: hidden; }
        .blink { animation: blinker 1s linear infinite; }
        @keyframes blinker { 50% { opacity: 0; } }
    </style>
    <!-- Auto Refresh setiap 5 detik -->
    <meta http-equiv="refresh" content="5">
</head>
<body class="h-screen flex flex-col">

    <!-- Header -->
    <div class="bg-teal-700 text-white p-6 shadow-lg flex justify-between items-center">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white rounded-full">
                <svg class="w-8 h-8 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <div>
                <h1 class="text-3xl font-black tracking-tight">PUSKESMAS JAGAKARSA</h1>
                <p class="text-teal-200 text-lg">Melayani dengan Sepenuh Hati</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-2xl font-bold">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</h2>
            <h3 class="text-4xl font-mono font-black">{{ \Carbon\Carbon::now()->format('H:i') }}</h3>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 flex p-6 gap-6">
        
        <!-- Main Display (Sedang Dipanggil) -->
        <div class="w-2/3 bg-white rounded-3xl shadow-2xl border-4 border-teal-500 flex flex-col items-center justify-center p-8 relative overflow-hidden">
            <div class="absolute top-0 w-full bg-teal-500 text-white text-center py-4 text-2xl font-bold uppercase tracking-widest">
                Nomor Antrean Dipanggil
            </div>
            
            @if($sedangDipanggil)
                <div class="text-9xl font-black text-gray-800 mt-8 mb-4">{{ $sedangDipanggil->nomor_antrean }}</div>
                
                <div class="text-center space-y-2">
                    <p class="text-gray-500 text-xl uppercase">Silakan Menuju</p>
                    <div class="text-5xl font-bold text-teal-600 blink">{{ $sedangDipanggil->poli_tujuan }}</div>
                </div>

                <div class="mt-12 bg-gray-100 rounded-xl px-8 py-4 w-full text-center">
                    <p class="text-gray-500 text-lg">Nama Pasien</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $sedangDipanggil->pasien->nama_lengkap }}</p>
                </div>
            @else
                <div class="text-center text-gray-400">
                    <svg class="w-32 h-32 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-3xl font-bold">Belum ada panggilan</p>
                </div>
            @endif
        </div>

        <!-- Sidebar List (Antrean Berikutnya) -->
        <div class="w-1/3 flex flex-col gap-4">
            <div class="bg-gray-800 text-white p-4 rounded-t-2xl text-center text-xl font-bold uppercase">
                Antrean Berikutnya
            </div>
            
            <div class="flex-1 space-y-4 overflow-y-hidden">
                @forelse($antreanBerikutnya as $antrean)
                    <div class="bg-white rounded-xl shadow-lg p-6 flex justify-between items-center border-l-8 border-gray-300">
                        <div>
                            <span class="block text-4xl font-black text-gray-800">{{ $antrean->nomor_antrean }}</span>
                            <span class="text-gray-500 text-sm">Poli {{ $antrean->poli_tujuan }}</span>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold uppercase">Menunggu</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white/50 rounded-xl p-8 text-center text-gray-500 italic">
                        Tidak ada antrean menunggu.
                    </div>
                @endforelse
            </div>

            <!-- Footer Running Text (Optional) -->
            <div class="bg-teal-100 text-teal-800 p-4 rounded-xl text-center font-medium shadow-inner">
                <marquee>Mohon menunggu panggilan sesuai nomor antrean. Tetap patuhi protokol kesehatan.</marquee>
            </div>
        </div>

    </div>

</body>
</html>
