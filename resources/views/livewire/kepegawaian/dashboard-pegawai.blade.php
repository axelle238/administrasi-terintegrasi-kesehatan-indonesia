<div class="space-y-8 animate-fade-in">
    <!-- Hero Section: Profile & Status -->
    <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-indigo-500/30">
        <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-500/20 rounded-full blur-3xl -ml-10 -mb-10"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <!-- Avatar & Greeting -->
            <div class="flex flex-col items-center md:items-start text-center md:text-left flex-1">
                <div class="flex items-center gap-6 mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-white/20 backdrop-blur border border-white/30 flex items-center justify-center text-3xl font-black shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-indigo-200 text-sm font-bold uppercase tracking-widest mb-1">Selamat Datang,</p>
                        <h2 class="text-3xl md:text-4xl font-black leading-tight">{{ $user->name }}</h2>
                        <p class="text-white/80 font-medium text-sm mt-1 flex items-center gap-2 justify-center md:justify-start">
                            <span class="px-2 py-0.5 rounded bg-white/20 text-xs font-bold">{{ $pegawai->jabatan ?? 'Staff' }}</span>
                            <span>•</span>
                            <span>{{ $pegawai->nip ?? 'NIP Belum Diatur' }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Status Card -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-6 w-full md:w-auto min-w-[300px]">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-bold text-indigo-200 uppercase tracking-wider">Status Presensi</p>
                        <h3 class="text-2xl font-black mt-1">
                            @if($presensiHariIni && $presensiHariIni->jam_keluar)
                                <span class="text-emerald-300">Selesai</span>
                            @elseif($presensiHariIni)
                                <span class="text-amber-300">Sedang Bertugas</span>
                            @else
                                <span class="text-white/60">Belum Check-in</span>
                            @endif
                        </h3>
                    </div>
                    <div class="p-2 bg-white/20 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                
                @if($jadwalHariIni)
                    <div class="flex items-center gap-3 text-sm bg-black/20 p-3 rounded-xl border border-white/5">
                        <span class="font-bold text-indigo-200">Jadwal Hari Ini:</span>
                        <span class="font-mono font-bold">{{ $jadwalHariIni->shift->jam_mulai }} - {{ $jadwalHariIni->shift->jam_selesai }}</span>
                    </div>
                @else
                    <div class="text-sm text-indigo-200 bg-white/5 p-3 rounded-xl text-center">Tidak ada jadwal hari ini (Off).</div>
                @endif

                @if(!$presensiHariIni)
                    <a href="{{ route('kepegawaian.presensi.index') }}" class="mt-4 block w-full py-3 bg-white text-indigo-600 rounded-xl font-bold text-center hover:bg-indigo-50 transition-colors shadow-lg">
                        Lakukan Presensi Sekarang
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 hover:border-indigo-200 transition-colors group">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hadir Bulan Ini</p>
            <h3 class="text-2xl font-black text-slate-800">{{ $stats['hadir_bulan_ini'] }} <span class="text-xs text-slate-400 font-medium">Hari</span></h3>
        </div>

        <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 hover:border-emerald-200 transition-colors group">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lembur</p>
            <h3 class="text-2xl font-black text-slate-800">{{ $stats['lembur_bulan_ini'] }} <span class="text-xs text-slate-400 font-medium">Jam</span></h3>
        </div>

        <!-- Cuti dengan Visual Circular -->
        <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 hover:border-rose-200 transition-colors group relative overflow-hidden">
            <div class="absolute right-0 bottom-0 w-16 h-16 mr-[-10px] mb-[-10px]">
                <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                    <path class="text-slate-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                    <path class="text-rose-500" stroke-dasharray="{{ min(100, ($stats['sisa_cuti'] / 12) * 100) }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4" />
                </svg>
            </div>
            <div class="relative z-10">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                </div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sisa Cuti</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $stats['sisa_cuti'] }} <span class="text-xs text-slate-400 font-medium">/ 12 Hari</span></h3>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl shadow-sm border border-slate-100 hover:border-amber-200 transition-colors group">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Skor Kinerja</p>
            <h3 class="text-2xl font-black text-slate-800">{{ number_format($stats['poin_kinerja'], 1) }}</h3>
        </div>
    </div>

    <!-- Main Content: Actions & Timeline -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Quick Actions -->
        <div class="lg:col-span-2 space-y-8">
            <div>
                <h3 class="text-lg font-black text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                    Menu Cepat
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <a href="{{ route('kepegawaian.presensi.index') }}" class="p-4 bg-white rounded-2xl border border-slate-100 hover:border-indigo-200 hover:shadow-lg transition-all group text-center flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-700">Absen Masuk/Pulang</span>
                    </a>
                    
                    <a href="{{ route('kepegawaian.cuti.index') }}" class="p-4 bg-white rounded-2xl border border-slate-100 hover:border-rose-200 hover:shadow-lg transition-all group text-center flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-rose-700">Ajukan Cuti</span>
                    </a>

                    <a href="{{ route('kepegawaian.aktivitas.index') }}" class="p-4 bg-white rounded-2xl border border-slate-100 hover:border-emerald-200 hover:shadow-lg transition-all group text-center flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-emerald-700">Isi Laporan (LKH)</span>
                    </a>

                    <a href="{{ route('kepegawaian.lembur.index') }}" class="p-4 bg-white rounded-2xl border border-slate-100 hover:border-amber-200 hover:shadow-lg transition-all group text-center flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-amber-700">Form Lembur</span>
                    </a>

                    <a href="{{ route('kepegawaian.jadwal.swap') }}" class="p-4 bg-white rounded-2xl border border-slate-100 hover:border-blue-200 hover:shadow-lg transition-all group text-center flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-blue-700">Tukar Shift</span>
                    </a>

                    <a href="{{ route('kepegawaian.gaji.index') }}" class="p-4 bg-white rounded-2xl border border-slate-100 hover:border-teal-200 hover:shadow-lg transition-all group text-center flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-teal-700">Slip Gaji</span>
                    </a>
                </div>
            </div>

            <!-- Recent Activity Timeline -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100">
                <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                    <span class="w-2 h-8 bg-slate-300 rounded-full"></span>
                    Aktivitas Terakhir
                </h3>
                <div class="space-y-6 relative border-l-2 border-slate-100 ml-3">
                    @forelse($timeline as $log)
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-2 border-white 
                            {{ $log['type'] == 'presensi' ? 'bg-emerald-500' : 'bg-blue-500' }}">
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $log['title'] }}</p>
                                <p class="text-xs text-slate-500">{{ $log['desc'] }}</p>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded border border-slate-100 whitespace-nowrap">
                                {{ $log['time']->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="pl-6 py-4 text-sm text-slate-400 italic">Belum ada aktivitas tercatat.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Right: Info -->
        <div class="space-y-6">
            <!-- Next Shift -->
            <div class="bg-slate-900 rounded-3xl p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                <h4 class="text-sm font-bold text-indigo-200 uppercase tracking-widest mb-4">Shift Berikutnya</h4>
                @if($nextShift)
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center font-black text-xl">
                            {{ $nextShift->tanggal->format('d') }}
                        </div>
                        <div>
                            <p class="font-bold text-lg">{{ $nextShift->tanggal->translatedFormat('l, F Y') }}</p>
                            <p class="text-sm text-indigo-200">{{ $nextShift->shift->nama_shift }} ({{ $nextShift->shift->jam_mulai }} - {{ $nextShift->shift->jam_selesai }})</p>
                        </div>
                    </div>
                    <div class="w-full bg-white/10 h-1 rounded-full overflow-hidden">
                        <div class="bg-indigo-500 h-full w-1/3"></div>
                    </div>
                    <p class="text-[10px] mt-2 text-indigo-300">Siapkan diri Anda untuk pelayanan prima.</p>
                @else
                    <p class="text-sm text-slate-400">Belum ada jadwal berikutnya.</p>
                @endif
            </div>

            <!-- Documents Shortcut -->
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                <h4 class="text-sm font-bold text-slate-800 uppercase tracking-widest mb-4">Dokumen Digital</h4>
                <div class="space-y-3">
                    <a href="{{ route('profile.edit') }}#documents" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-600">Kelola Arsip</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
