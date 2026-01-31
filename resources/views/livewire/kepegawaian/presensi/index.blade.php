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

        <div class="p-10">
            @if($currentStep === 'check-in')
                <!-- Step 1: Pilih Jenis Presensi -->
                <div class="mb-10">
                    <h4 class="text-center text-slate-500 font-bold uppercase tracking-widest text-xs mb-6">Pilih Jenis Kehadiran</h4>
                    
                    <!-- Grid Utama -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-4xl mx-auto mb-4">
                        <!-- WFO -->
                        <button wire:click="setJenis('WFO')" class="p-4 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 {{ $jenis_presensi == 'WFO' ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-200' : 'border-slate-100 hover:border-slate-300' }}">
                            <div class="w-12 h-12 rounded-full {{ $jenis_presensi == 'WFO' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <span class="font-bold text-sm {{ $jenis_presensi == 'WFO' ? 'text-indigo-700' : 'text-slate-600' }}">WFO (Kantor)</span>
                        </button>

                        <!-- WFH -->
                        <button wire:click="setJenis('WFH')" class="p-4 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 {{ $jenis_presensi == 'WFH' ? 'border-purple-500 bg-purple-50 ring-2 ring-purple-200' : 'border-slate-100 hover:border-slate-300' }}">
                            <div class="w-12 h-12 rounded-full {{ $jenis_presensi == 'WFH' ? 'bg-purple-600 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                            </div>
                            <span class="font-bold text-sm {{ $jenis_presensi == 'WFH' ? 'text-purple-700' : 'text-slate-600' }}">WFH (Rumah)</span>
                        </button>
                    </div>

                    <!-- Grid Dinas Luar (Advanced) -->
                    <div class="max-w-4xl mx-auto">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 ml-1">Opsi Dinas Luar (DL)</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- DL Awal -->
                            <button wire:click="setJenis('DL Awal')" class="p-4 rounded-2xl border-2 transition-all text-left {{ $jenis_presensi == 'DL Awal' ? 'border-amber-500 bg-amber-50 ring-2 ring-amber-200' : 'border-slate-100 hover:border-slate-300' }}">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-lg {{ $jenis_presensi == 'DL Awal' ? 'bg-amber-600 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </div>
                                    <span class="font-bold text-sm {{ $jenis_presensi == 'DL Awal' ? 'text-amber-700' : 'text-slate-600' }}">DL Awal</span>
                                </div>
                                <p class="text-[10px] {{ $jenis_presensi == 'DL Awal' ? 'text-amber-600' : 'text-slate-400' }} leading-tight">
                                    Dinas Pagi. Dispensasi presensi masuk 07:30 - 11:59.
                                </p>
                            </button>

                            <!-- DL Akhir -->
                            <button wire:click="setJenis('DL Akhir')" class="p-4 rounded-2xl border-2 transition-all text-left {{ $jenis_presensi == 'DL Akhir' ? 'border-orange-500 bg-orange-50 ring-2 ring-orange-200' : 'border-slate-100 hover:border-slate-300' }}">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-lg {{ $jenis_presensi == 'DL Akhir' ? 'bg-orange-600 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                                    </div>
                                    <span class="font-bold text-sm {{ $jenis_presensi == 'DL Akhir' ? 'text-orange-700' : 'text-slate-600' }}">DL Akhir</span>
                                </div>
                                <p class="text-[10px] {{ $jenis_presensi == 'DL Akhir' ? 'text-orange-600' : 'text-slate-400' }} leading-tight">
                                    Dinas Siang. Dispensasi presensi pulang 12:00 - 16:00.
                                </p>
                            </button>

                            <!-- DL Penuh -->
                            <button wire:click="setJenis('DL Penuh')" class="p-4 rounded-2xl border-2 transition-all text-left {{ $jenis_presensi == 'DL Penuh' ? 'border-red-500 bg-red-50 ring-2 ring-red-200' : 'border-slate-100 hover:border-slate-300' }}">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-lg {{ $jenis_presensi == 'DL Penuh' ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <span class="font-bold text-sm {{ $jenis_presensi == 'DL Penuh' ? 'text-red-700' : 'text-slate-600' }}">DL Penuh</span>
                                </div>
                                <p class="text-[10px] {{ $jenis_presensi == 'DL Penuh' ? 'text-red-600' : 'text-slate-400' }} leading-tight">
                                    Dinas Seharian. Dispensasi penuh 07:30 - 16:00.
                                </p>
                            </button>
                        </div>
                    </div>

                    @if($jenis_presensi != 'WFO')
                        <div class="mt-6 max-w-xl mx-auto animate-fade-in">
                            <label class="block text-xs font-bold text-slate-500 mb-1">Catatan Kegiatan / Lokasi (Wajib)</label>
                            <textarea wire:model="keterangan_tambahan" class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 font-medium" rows="2" placeholder="Contoh: Kunjungan ke Kecamatan X..."></textarea>
                        </div>
                    @endif
                </div>

                <!-- Step 2: Tombol Aksi -->
                <div class="flex justify-center">
                    <button @click="doClockIn()" class="group relative w-64 h-64 rounded-full bg-indigo-50 border-8 border-indigo-100 flex flex-col items-center justify-center hover:scale-105 transition-transform shadow-lg cursor-pointer">
                        <div class="absolute inset-0 rounded-full border-4 border-dashed border-indigo-200 animate-spin-slow"></div>
                        <svg class="w-16 h-16 text-indigo-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                        <span class="text-2xl font-black text-indigo-800 uppercase tracking-tight">Masuk Kerja</span>
                        <span class="text-xs text-indigo-400 font-bold mt-1">Mode: {{ $jenis_presensi }}</span>
                    </button>
                </div>

            @elseif($currentStep === 'check-out')
                <div class="flex justify-center">
                    <button @click="doClockOut()" class="group relative w-64 h-64 rounded-full bg-orange-50 border-8 border-orange-100 flex flex-col items-center justify-center hover:scale-105 transition-transform shadow-lg cursor-pointer">
                        <div class="absolute inset-0 rounded-full border-4 border-dashed border-orange-200 animate-spin-slow"></div>
                        <svg class="w-16 h-16 text-orange-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        <span class="text-2xl font-black text-orange-800 uppercase tracking-tight">Pulang Kerja</span>
                        <span class="text-xs text-orange-400 font-bold mt-1">Selesai Bertugas</span>
                    </button>
                </div>
            @else
                <div class="flex justify-center">
                    <div class="w-64 h-64 rounded-full bg-emerald-50 border-8 border-emerald-100 flex flex-col items-center justify-center text-emerald-600">
                        <svg class="w-20 h-20 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-xl font-black uppercase">Sudah Absen</span>
                        <span class="text-xs font-bold mt-1">Sampai Jumpa Besok!</span>
                    </div>
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
                        <th class="px-6 py-3">Jenis</th>
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
                        <td class="px-6 py-4">
                            @php
                                $badge = match($h->jenis_presensi) {
                                    'WFH' => 'bg-purple-100 text-purple-700',
                                    'DL Awal' => 'bg-amber-100 text-amber-700',
                                    'DL Akhir' => 'bg-orange-100 text-orange-700',
                                    'DL Penuh' => 'bg-red-100 text-red-700',
                                    default => 'bg-indigo-100 text-indigo-700'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-wider {{ $badge }}">
                                {{ $h->jenis_presensi ?? 'WFO' }}
                            </span>
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
                        <td colspan="6" class="text-center py-8 text-slate-400 font-medium">Belum ada data presensi bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
