<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 pb-20">
    <!-- Presensi Card -->
    <div class="bg-white rounded-[3rem] shadow-xl overflow-hidden relative border border-slate-100" 
         x-data="{ 
            lat: null, 
            lng: null,
            time: '',
            initGeo() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        this.lat = position.coords.latitude;
                        this.lng = position.coords.longitude;
                    }, (error) => {
                        alert('Gagal mengambil lokasi. Pastikan GPS aktif.');
                    });
                }
                setInterval(() => {
                    this.time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                }, 1000);
            },
            doClockIn() {
                if(!this.lat) { alert('Menunggu lokasi...'); return; }
                $wire.clockIn(this.lat, this.lng);
            },
            doClockOut() {
                if(!this.lat) { alert('Menunggu lokasi...'); return; }
                $wire.clockOut(this.lat, this.lng);
            }
         }" 
         x-init="initGeo()">
        
        <!-- Header Visual -->
        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-10 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-white/5 opacity-30 pattern-grid"></div>
            <h3 class="text-indigo-100 font-bold uppercase tracking-widest text-sm mb-2">Waktu Server Saat Ini</h3>
            <h1 class="text-6xl font-black text-white font-mono tracking-tight" x-text="time">--:--:--</h1>
            <p class="text-indigo-200 text-sm mt-4 font-medium flex justify-center items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <span x-text="lat ? 'Lokasi Terkunci: ' + lat.toFixed(4) + ', ' + lng.toFixed(4) : 'Mencari Lokasi...'">Mencari Lokasi...</span>
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="p-10 flex justify-center">
            @if($currentStep === 'check-in')
                <button @click="doClockIn()" class="group relative w-64 h-64 rounded-full bg-indigo-50 border-8 border-indigo-100 flex flex-col items-center justify-center hover:scale-105 transition-transform shadow-lg cursor-pointer">
                    <div class="absolute inset-0 rounded-full border-4 border-dashed border-indigo-200 animate-spin-slow"></div>
                    <svg class="w-16 h-16 text-indigo-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    <span class="text-2xl font-black text-indigo-800 uppercase tracking-tight">Masuk Kerja</span>
                    <span class="text-xs text-indigo-400 font-bold mt-1">Tap untuk Absen</span>
                </button>
            @elseif($currentStep === 'check-out')
                <button @click="doClockOut()" class="group relative w-64 h-64 rounded-full bg-orange-50 border-8 border-orange-100 flex flex-col items-center justify-center hover:scale-105 transition-transform shadow-lg cursor-pointer">
                    <div class="absolute inset-0 rounded-full border-4 border-dashed border-orange-200 animate-spin-slow"></div>
                    <svg class="w-16 h-16 text-orange-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    <span class="text-2xl font-black text-orange-800 uppercase tracking-tight">Pulang Kerja</span>
                    <span class="text-xs text-orange-400 font-bold mt-1">Selesai Bertugas</span>
                </button>
            @else
                <div class="w-64 h-64 rounded-full bg-emerald-50 border-8 border-emerald-100 flex flex-col items-center justify-center text-emerald-600">
                    <svg class="w-20 h-20 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="text-xl font-black uppercase">Sudah Absen</span>
                    <span class="text-xs font-bold mt-1">Sampai Jumpa Besok!</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Riwayat Bulan Ini -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <h3 class="text-lg font-black text-slate-800 mb-6">Riwayat Kehadiran Bulan Ini</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-400 uppercase font-black bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 rounded-l-xl">Tanggal</th>
                        <th class="px-6 py-3">Masuk</th>
                        <th class="px-6 py-3">Pulang</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 rounded-r-xl text-right">Durasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($history as $h)
                    <tr>
                        <td class="px-6 py-4 font-bold text-slate-700">
                            {{ \Carbon\Carbon::parse($h->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 font-mono text-emerald-600 font-bold">
                            {{ \Carbon\Carbon::parse($h->jam_masuk)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 font-mono text-orange-600 font-bold">
                            {{ $h->jam_keluar ? \Carbon\Carbon::parse($h->jam_keluar)->format('H:i') : '--:--' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $h->status_kehadiran == 'Terlambat' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $h->status_kehadiran }}
                            </span>
                            @if($h->keterlambatan_menit > 0)
                                <span class="text-xs text-red-500 font-bold ml-2">(+{{ $h->keterlambatan_menit }}m)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-slate-600">
                            @if($h->jam_masuk && $h->jam_keluar)
                                {{ \Carbon\Carbon::parse($h->jam_masuk)->diffInHours(\Carbon\Carbon::parse($h->jam_keluar)) }} Jam
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-slate-400 font-medium">Belum ada data presensi bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
