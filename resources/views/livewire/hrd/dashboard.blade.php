<div class="space-y-8 animate-fade-in">
    <!-- Header Dashboard HRD -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-800 flex items-center gap-4">
                <div class="p-3 bg-rose-50 rounded-2xl text-rose-600 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                Manajemen Sumber Daya Manusia
            </h2>
            <p class="text-slate-500 font-medium mt-2 ml-16 leading-relaxed">
                Pusat monitoring kinerja pegawai, status STR/SIP, presensi harian, dan tata kelola kesejahteraan SDM.
            </p>
        </div>
        <div class="flex items-center gap-3 ml-16 lg:ml-0">
            <a href="{{ route('pegawai.create') }}" class="px-6 py-3 bg-slate-800 text-white rounded-2xl text-sm font-black hover:bg-slate-900 transition-all shadow-lg shadow-slate-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                Registrasi Pegawai
            </a>
        </div>
    </div>

    <!-- Global Key Performance Indicators -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pegawai -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-rose-200 transition-all">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pegawai</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($totalPegawai) }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
        </div>

        <!-- Sedang Bertugas (Realtime) -->
        <div class="bg-gradient-to-br from-rose-600 to-rose-700 p-6 rounded-3xl text-white shadow-xl shadow-rose-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-rose-100 uppercase tracking-widest mb-1 relative z-10">Sedang Bertugas</p>
            <h3 class="text-3xl font-black relative z-10">{{ $sedangBertugas }}</h3>
            <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-rose-100 uppercase relative z-10">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                </span>
                Real-time Shift
            </div>
        </div>

        <!-- Dokumen Expired Alert -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-amber-200 transition-all">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">STR/SIP Expired</p>
                <h3 class="text-3xl font-black text-amber-600 mt-1">{{ $dokumenExpired }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:animate-swing transition-transform">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
        </div>

        <!-- Penggajian Bulan Ini -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-indigo-200 transition-all">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Gaji Bulan Ini</p>
                <h3 class="text-xl font-black text-indigo-600 mt-1">Rp {{ number_format($tabData['gajiBulanIni'] ?? 0, 0, ',', '.') }}</h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs & Content -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 pt-6 border-b border-slate-50 flex gap-10 overflow-x-auto">
            <button wire:click="setTab('ikhtisar')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative whitespace-nowrap {{ $activeTab == 'ikhtisar' ? 'text-rose-600' : 'text-slate-400 hover:text-slate-600' }}">
                Ringkasan & Dokumen
                @if($activeTab == 'ikhtisar') <div class="absolute bottom-0 left-0 w-full h-1 bg-rose-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('presensi')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative whitespace-nowrap {{ $activeTab == 'presensi' ? 'text-rose-600' : 'text-slate-400 hover:text-slate-600' }}">
                Presensi & Jadwal
                @if($activeTab == 'presensi') <div class="absolute bottom-0 left-0 w-full h-1 bg-rose-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('cuti')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative whitespace-nowrap {{ $activeTab == 'cuti' ? 'text-rose-600' : 'text-slate-400 hover:text-slate-600' }}">
                Manajemen Cuti
                @if($activeTab == 'cuti') <div class="absolute bottom-0 left-0 w-full h-1 bg-rose-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('kinerja')" class="pb-5 text-sm font-black uppercase tracking-widest transition-all relative whitespace-nowrap {{ $activeTab == 'kinerja' ? 'text-rose-600' : 'text-slate-400 hover:text-slate-600' }}">
                Evaluasi Kinerja
                @if($activeTab == 'kinerja') <div class="absolute bottom-0 left-0 w-full h-1 bg-rose-600 rounded-t-full"></div> @endif
            </button>
        </div>

        <div class="p-8">
            @if($activeTab == 'ikhtisar')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 animate-fade-in-up">
                <!-- Charts Section -->
                <div class="space-y-8">
                    <!-- Status Kepegawaian -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100" x-data="chartStatus()">
                        <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-4">Status Kepegawaian</h4>
                        <div id="chart-status-pegawai" class="w-full flex justify-center"></div>
                    </div>

                    <!-- Distribusi Poli -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                        <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-4">Distribusi Medis per Poli</h4>
                        <div class="space-y-3 max-h-[300px] overflow-y-auto custom-scrollbar">
                            @foreach($tabData['distribusiPoli'] ?? [] as $poli)
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-slate-600">{{ $poli->nama_poli }}</span>
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 bg-slate-200 rounded-full overflow-hidden">
                                        <div class="bg-rose-500 h-full" style="width: {{ min(100, ($poli->pegawais_count / $totalPegawai) * 100 * 5) }}%"></div>
                                    </div>
                                    <span class="font-black text-slate-800 w-6 text-right">{{ $poli->pegawais_count }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Alert Dokumen -->
                <div class="lg:col-span-2 space-y-6">
                    <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        Monitoring Masa Berlaku STR / SIP (3 Bulan Kedepan)
                    </h4>
                    <div class="overflow-hidden border border-slate-100 rounded-3xl">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-slate-400 font-black uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Pegawai</th>
                                    <th class="px-6 py-4">Masa Berlaku STR</th>
                                    <th class="px-6 py-4">Masa Berlaku SIP</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($tabData['dokumenAlert'] ?? [] as $pegawai)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-black text-slate-800">{{ $pegawai->user->name ?? 'N/A' }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $pegawai->jabatan }}</p>
                                    </td>
                                    <td class="px-6 py-4 font-bold {{ $pegawai->masa_berlaku_str && \Carbon\Carbon::parse($pegawai->masa_berlaku_str)->isPast() ? 'text-rose-600' : 'text-slate-600' }}">
                                        {{ $pegawai->masa_berlaku_str ? \Carbon\Carbon::parse($pegawai->masa_berlaku_str)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 font-bold {{ $pegawai->masa_berlaku_sip && \Carbon\Carbon::parse($pegawai->masa_berlaku_sip)->isPast() ? 'text-rose-600' : 'text-slate-600' }}">
                                        {{ $pegawai->masa_berlaku_sip ? \Carbon\Carbon::parse($pegawai->masa_berlaku_sip)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 rounded bg-amber-100 text-amber-700 font-black uppercase tracking-tighter text-[10px]">Perlu Update</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400 font-medium">Semua dokumen kepegawaian aman & valid.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @if($activeTab == 'presensi')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 animate-fade-in-up">
                <!-- Statistik Kehadiran -->
                <div class="space-y-6">
                    <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs">Statistik Kehadiran Hari Ini</h4>
                    <div class="p-8 bg-rose-50 rounded-[2rem] border border-rose-100 flex flex-col items-center text-center">
                        <p class="text-xs font-black text-rose-400 uppercase tracking-widest mb-4">Total Dijadwalkan</p>
                        <h3 class="text-5xl font-black text-rose-600 mb-6">{{ $tabData['statistikKehadiran']['total'] }}</h3>
                        <div class="w-full flex justify-between gap-4">
                            <div class="flex-1 p-3 bg-white/60 rounded-2xl border border-rose-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase">Hadir</p>
                                <p class="text-xl font-black text-emerald-600">{{ $tabData['statistikKehadiran']['hadir'] }}</p>
                            </div>
                            <div class="flex-1 p-3 bg-white/60 rounded-2xl border border-rose-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase">Absen</p>
                                <p class="text-xl font-black text-rose-600">{{ $tabData['statistikKehadiran']['absen'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Jadwal -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex justify-between items-center">
                         <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs flex items-center gap-2">
                            <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Daftar Petugas Piket Hari Ini
                        </h4>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                   
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($tabData['jadwalHariIni'] ?? [] as $jadwal)
                        @php
                            $isNow = false;
                            if($jadwal->shift) {
                                $now = \Carbon\Carbon::now();
                                $start = \Carbon\Carbon::parse($jadwal->shift->jam_mulai);
                                $end = \Carbon\Carbon::parse($jadwal->shift->jam_selesai);
                                $isNow = $now->between($start, $end);
                            }
                        @endphp
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-4 group hover:bg-white hover:shadow-md transition-all {{ $isNow ? 'ring-2 ring-rose-500/20 bg-rose-50/30' : '' }}">
                            <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-rose-600 font-black text-xs shadow-sm relative">
                                {{ substr($jadwal->pegawai->user->name ?? '?', 0, 1) }}
                                @if($isNow)
                                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-black text-slate-800">{{ $jadwal->pegawai->user->name ?? 'Pegawai' }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ $jadwal->pegawai->jabatan }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 bg-rose-100 text-rose-700 rounded text-[9px] font-black uppercase">{{ $jadwal->shift->nama_shift ?? '-' }}</span>
                                <p class="text-[10px] font-bold text-slate-500 mt-1">{{ $jadwal->shift->jam_mulai ?? '-' }} - {{ $jadwal->shift->jam_selesai ?? '-' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($activeTab == 'cuti')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 animate-fade-in-up">
                <!-- Sedang Cuti -->
                <div>
                    <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-4">Sedang Cuti Hari Ini</h4>
                    <div class="space-y-4">
                        @forelse($tabData['sedangCuti'] ?? [] as $cuti)
                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-100 bg-white">
                             <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-black text-xs">
                                {{ substr($cuti->user->name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-800">{{ $cuti->user->name }}</p>
                                <span class="text-[10px] bg-purple-100 text-purple-700 px-2 py-0.5 rounded uppercase font-bold">{{ $cuti->jenis_cuti }}</span>
                            </div>
                            <div class="ml-auto text-right text-xs text-slate-500 font-medium">
                                Sampai {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d M') }}
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center border-2 border-dashed border-slate-100 rounded-2xl">
                            <p class="text-slate-400 text-sm font-bold">Tidak ada pegawai yang sedang cuti.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Cuti Akan Datang -->
                <div>
                    <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-4">Akan Cuti (7 Hari Kedepan)</h4>
                    <div class="space-y-4">
                        @forelse($tabData['cutiAkanDatang'] ?? [] as $cuti)
                        <div class="flex items-center gap-4 p-4 rounded-2xl border border-slate-100 bg-slate-50/50">
                             <div class="w-10 h-10 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center font-black text-xs">
                                {{ substr($cuti->user->name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-800">{{ $cuti->user->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $cuti->jenis_cuti }}</p>
                            </div>
                            <div class="ml-auto text-right text-xs font-bold text-slate-600">
                                {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d M') }}
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center border-2 border-dashed border-slate-100 rounded-2xl">
                            <p class="text-slate-400 text-sm font-bold">Tidak ada jadwal cuti mendatang.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pending Request -->
                <div class="lg:col-span-2 mt-4">
                    <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs mb-4 flex justify-between items-center">
                        Permintaan Menunggu Persetujuan
                        @if(count($tabData['cutiPending'] ?? []) > 0)
                        <span class="bg-rose-500 text-white text-[10px] px-2 py-0.5 rounded-full">{{ count($tabData['cutiPending']) }}</span>
                        @endif
                    </h4>
                    @if(count($tabData['cutiPending'] ?? []) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($tabData['cutiPending'] as $cuti)
                        <div class="p-4 rounded-2xl border border-rose-100 bg-rose-50/30 relative">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="text-sm font-black text-slate-800">{{ $cuti->user->name }}</p>
                                    <p class="text-[10px] text-slate-500">{{ $cuti->jenis_cuti }} • {{ $cuti->durasi }} Hari</p>
                                </div>
                                <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
                            </div>
                            <p class="text-xs text-slate-600 italic mb-4">"{{ Str::limit($cuti->alasan, 50) }}"</p>
                            <div class="flex gap-2">
                                <a href="{{ route('kepegawaian.cuti.index') }}" class="flex-1 py-1.5 bg-rose-600 text-white rounded-lg text-xs font-bold hover:bg-rose-700 text-center">Proses</a>
                                <a href="{{ route('kepegawaian.cuti.index') }}" class="flex-1 py-1.5 bg-white border border-slate-200 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-50 text-center">Detail</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-slate-400 text-sm italic">Tidak ada permintaan cuti pending.</p>
                    @endif
                </div>
            </div>
            @endif

            @if($activeTab == 'kinerja')
            <div class="space-y-10 animate-fade-in-up" x-data="chartKinerja()">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-lg font-black text-slate-800">Tren Kinerja Kolektif</h4>
                        <p class="text-xs text-slate-400 font-bold uppercase mt-1">Evaluasi Rata-Rata Bulanan</p>
                    </div>
                    <div class="flex items-center gap-2 bg-emerald-50 px-4 py-2 rounded-xl border border-emerald-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-black text-emerald-700 uppercase tracking-widest">Optimasi Layanan</span>
                    </div>
                </div>
                <div id="chart-tren-kinerja" class="w-full h-[350px]"></div>

                <!-- Top Performers -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6 border-t border-slate-50">
                    @foreach($tabData['topPerformance'] ?? [] as $kp)
                    <div class="p-6 bg-white border border-slate-100 rounded-[2rem] shadow-sm relative overflow-hidden group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-sm">
                                #{{ $loop->iteration }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-800">{{ $kp->pegawai->user->name ?? 'N/A' }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $kp->pegawai->jabatan }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-end">
                                <span class="text-[10px] font-black text-slate-400 uppercase">Skor Evaluasi</span>
                                <span class="text-2xl font-black text-indigo-600">{{ number_format($kp->rata_rata, 1) }}</span>
                            </div>
                            <div class="w-full bg-slate-50 h-2 rounded-full overflow-hidden border border-slate-100">
                                <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000" style="width: {{ $kp->rata_rata }}%"></div>
                            </div>
                        </div>
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function chartStatus() {
            return {
                init() {
                    const statusData = @json($tabData['distribusiStatus'] ?? []);
                    const options = {
                        series: statusData.map(r => r.total),
                        labels: statusData.map(r => r.status_kepegawaian),
                        chart: { type: 'pie', height: 250, fontFamily: 'Plus Jakarta Sans' },
                        colors: ['#f43f5e', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'],
                        legend: { position: 'bottom' },
                        dataLabels: { enabled: true },
                        stroke: { width: 0 }
                    };
                    new ApexCharts(document.querySelector("#chart-status-pegawai"), options).render();
                }
            }
        }

        function chartKinerja() {
            return {
                init() {
                    const data = @json($tabData['trenKinerja'] ?? ['labels' => [], 'data' => []]);
                    const options = {
                        series: [{
                            name: 'Skor Kinerja',
                            data: data.data
                        }],
                        chart: {
                            type: 'area',
                            height: 350,
                            toolbar: { show: false },
                            fontFamily: 'Plus Jakarta Sans, sans-serif'
                        },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        colors: ['#f43f5e'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.45,
                                opacityTo: 0.05,
                                stops: [20, 100]
                            }
                        },
                        xaxis: {
                            categories: data.labels,
                            axisBorder: { show: false },
                            labels: { style: { colors: '#94a3b8', fontWeight: 700 } }
                        },
                        yaxis: {
                            min: 0,
                            max: 100,
                            labels: { style: { colors: '#94a3b8', fontWeight: 700 } }
                        },
                        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                        tooltip: { theme: 'dark' }
                    };
                    new ApexCharts(document.querySelector("#chart-tren-kinerja"), options).render();
                }
            }
        }
    </script>
    @endpush
</div>