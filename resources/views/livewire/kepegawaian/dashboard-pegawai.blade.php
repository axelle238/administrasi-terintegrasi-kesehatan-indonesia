<div class="space-y-8 animate-fade-in">
    <!-- Profil Singkat & Status -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col lg:flex-row justify-between items-center gap-8 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-orange-50 rounded-full blur-3xl -mr-32 -mt-32 opacity-50"></div>
        
        <div class="flex flex-col md:flex-row items-center gap-6 relative z-10">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-tr from-orange-500 to-amber-400 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-orange-200">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">{{ Auth::user()->name }}</h2>
                <p class="text-orange-600 font-bold uppercase tracking-widest text-xs mt-1">{{ $pegawai->jabatan }} • NIP: {{ $pegawai->nip ?? '-' }}</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-4">
                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Status: {{ $pegawai->status_kepegawaian }}</span>
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Poli: {{ $pegawai->poli->nama_poli ?? 'Umum' }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 w-full lg:w-max relative z-10">
            <div class="bg-orange-50 p-4 rounded-3xl border border-orange-100 text-center">
                <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest mb-1">Sisa Cuti</p>
                <h4 class="text-2xl font-black text-orange-600">{{ $pegawai->sisa_cuti ?? 0 }} <span class="text-xs font-bold text-orange-400">Hari</span></h4>
            </div>
            <div class="bg-blue-50 p-4 rounded-3xl border border-blue-100 text-center">
                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Kehadiran</p>
                <h4 class="text-2xl font-black text-blue-600">98%</h4>
            </div>
            <div class="bg-emerald-50 p-4 rounded-3xl border border-emerald-100 text-center col-span-2 sm:col-span-1">
                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Skor Kinerja</p>
                <h4 class="text-2xl font-black text-emerald-600">{{ $kinerja ? number_format(($kinerja->orientasi_pelayanan + $kinerja->integritas + $kinerja->komitmen + $kinerja->disiplin + $kinerja->kerjasama) / 5, 1) : '0.0' }}</h4>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Jadwal & Tugas -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="text-xl font-black text-slate-800 mb-6 flex items-center gap-3">
                    <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    Jadwal Dinas Hari Ini
                </h3>
                
                @if($jadwalHariIni)
                <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-indigo-600 shadow-sm">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-lg font-black text-slate-800 uppercase tracking-tight">{{ $jadwalHariIni->shift->nama_shift }}</p>
                            <p class="text-sm font-bold text-slate-500">{{ $jadwalHariIni->shift->jam_masuk }} — {{ $jadwalHariIni->shift->jam_keluar }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">Sedang Berlangsung</span>
                    </div>
                </div>
                @else
                <div class="p-10 text-center bg-slate-50 rounded-[2rem] border border-dashed border-slate-200">
                    <p class="text-slate-400 font-bold">Tidak ada jadwal dinas terdaftar untuk hari ini.</p>
                </div>
                @endif

                <!-- Menu Cepat -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8 pt-8 border-t border-slate-50">
                    <a href="{{ route('kepegawaian.cuti.index') }}" class="p-4 bg-white rounded-2xl border border-slate-100 text-center hover:border-orange-300 hover:shadow-lg transition-all group">
                        <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <span class="text-[10px] font-black text-slate-600 uppercase">Ajukan Cuti</span>
                    </a>
                    <button class="p-4 bg-white rounded-2xl border border-slate-100 text-center hover:border-blue-300 hover:shadow-lg transition-all group">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-[10px] font-black text-slate-600 uppercase">Presensi</span>
                    </button>
                    <button class="p-4 bg-white rounded-2xl border border-slate-100 text-center hover:border-emerald-300 hover:shadow-lg transition-all group">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <span class="text-[10px] font-black text-slate-600 uppercase">Slip Gaji</span>
                    </button>
                    <button class="p-4 bg-white rounded-2xl border border-slate-100 text-center hover:border-indigo-300 hover:shadow-lg transition-all group">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <span class="text-[10px] font-black text-slate-600 uppercase">Profil</span>
                    </button>
                </div>
            </div>

            <!-- Riwayat Cuti Terbaru -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <h3 class="text-xl font-black text-slate-800 mb-6 flex items-center justify-between">
                    <span>Riwayat Pengajuan Cuti</span>
                    <a href="{{ route('kepegawaian.cuti.index') }}" class="text-[10px] font-black text-orange-600 uppercase tracking-widest hover:underline">Semua &rarr;</a>
                </h3>
                <div class="space-y-4">
                    @forelse($riwayatCuti as $cuti)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div>
                            <p class="text-sm font-black text-slate-800">{{ $cuti->jenis_cuti }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->translatedFormat('d M') }} — {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->translatedFormat('d M Y') }}</p>
                        </div>
                        <div>
                            @php
                                $statusStyle = match($cuti->status) {
                                    'Disetujui' => 'bg-emerald-100 text-emerald-700',
                                    'Ditolak' => 'bg-rose-100 text-rose-700',
                                    default => 'bg-amber-100 text-amber-700'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $statusStyle }}">
                                {{ $cuti->status }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 py-6 text-sm italic">Belum ada riwayat pengajuan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Dashboard Pegawai -->
        <div class="space-y-8">
            <!-- Informasi Gaji Terakhir -->
            <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden group">
                <div class="absolute right-0 bottom-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-16 -mb-16 group-hover:scale-150 transition-transform"></div>
                <h3 class="text-lg font-black mb-6 text-slate-400 uppercase tracking-widest">Penghasilan Terakhir</h3>
                @if($gajiTerakhir)
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-tighter">{{ $gajiTerakhir->bulan }} {{ $gajiTerakhir->tahun }}</p>
                    <h4 class="text-3xl font-black text-white">Rp {{ number_format($gajiTerakhir->total_gaji, 0, ',', '.') }}</h4>
                </div>
                <button class="mt-8 w-full py-3 bg-white/10 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-white/20 transition-all">Download Slip PDF</button>
                @else
                <p class="text-slate-500 text-sm">Data penggajian belum tersedia.</p>
                @endif
            </div>

            <!-- Dokumen Kadaluwarsa Alert -->
            @php
                $isExpired = \Carbon\Carbon::parse($pegawai->masa_berlaku_str)->isPast() || \Carbon\Carbon::parse($pegawai->masa_berlaku_sip)->isPast();
            @endphp
            <div class="p-8 rounded-[2.5rem] border {{ $isExpired ? 'bg-rose-50 border-rose-100' : 'bg-blue-50 border-blue-100' }}">
                <h3 class="text-lg font-black mb-6 {{ $isExpired ? 'text-rose-800' : 'text-blue-800' }} uppercase tracking-widest">Status Dokumen Medis</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest mb-1 text-slate-400">Masa Berlaku STR</p>
                        <p class="text-sm font-black {{ \Carbon\Carbon::parse($pegawai->masa_berlaku_str)->isPast() ? 'text-rose-600' : 'text-slate-700' }}">
                            {{ \Carbon\Carbon::parse($pegawai->masa_berlaku_str)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest mb-1 text-slate-400">Masa Berlaku SIP</p>
                        <p class="text-sm font-black {{ \Carbon\Carbon::parse($pegawai->masa_berlaku_sip)->isPast() ? 'text-rose-600' : 'text-slate-700' }}">
                            {{ \Carbon\Carbon::parse($pegawai->masa_berlaku_sip)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>
                @if($isExpired)
                <div class="mt-6 p-4 bg-white/60 rounded-2xl border border-rose-200">
                    <p class="text-[10px] text-rose-600 font-bold leading-tight uppercase">⚠️ Harap segera melakukan pembaruan dokumen STR/SIP untuk menghindari penonaktifan akses klinis.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
