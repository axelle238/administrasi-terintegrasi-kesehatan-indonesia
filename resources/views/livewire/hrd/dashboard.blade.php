<div class="space-y-6">
    <!-- Header Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Pegawai -->
        <div class="bg-gradient-to-br from-purple-600 to-indigo-700 p-6 rounded-3xl text-white shadow-xl shadow-purple-500/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-purple-100 uppercase tracking-widest mb-1">Total Pegawai</p>
            <h3 class="text-3xl font-black">{{ $totalPegawai }}</h3>
            <p class="mt-4 text-[10px] font-medium bg-purple-500/30 px-2 py-1 rounded inline-block">{{ $pegawaiAktif }} Aktif Bekerja</p>
        </div>

        <!-- Dokumen Expired -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Alert Dokumen</p>
            <h3 class="text-3xl font-black {{ $dokumenExpired > 0 ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">{{ $dokumenExpired }}</h3>
            <div class="mt-4 flex items-center gap-2">
                @if($dokumenExpired > 0)
                    <svg class="w-4 h-4 text-red-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span class="text-xs text-red-500 font-bold">STR/SIP Segera Expired</span>
                @else
                    <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    <span class="text-xs text-emerald-500 font-bold">Semua Aman</span>
                @endif
            </div>
        </div>

        <!-- Shortcut Cuti -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:border-purple-200 transition-colors cursor-pointer" wire:click="setTab('cuti')">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Manajemen Cuti</p>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white mt-1">Kelola Pengajuan</h3>
                </div>
                <div class="p-2 bg-purple-50 dark:bg-purple-900/30 rounded-lg text-purple-600 dark:text-purple-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-purple-600 font-bold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                Lihat Detail <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </p>
        </div>

        <!-- Shortcut Penilaian -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:border-indigo-200 transition-colors cursor-pointer" wire:click="setTab('kinerja')">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Penilaian Kinerja</p>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white mt-1">Input KPI Bulanan</h3>
                </div>
                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-indigo-600 font-bold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                Lihat Grafik <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="border-b border-gray-100 dark:border-gray-700 px-6 pt-4 flex gap-8 overflow-x-auto">
            <button wire:click="setTab('ikhtisar')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'ikhtisar' ? 'text-purple-600' : 'text-gray-400 hover:text-gray-600' }}">
                Ringkasan SDM
                @if($activeTab == 'ikhtisar') <div class="absolute bottom-0 left-0 w-full h-1 bg-purple-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('presensi')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'presensi' ? 'text-purple-600' : 'text-gray-400 hover:text-gray-600' }}">
                Jadwal & Kehadiran
                @if($activeTab == 'presensi') <div class="absolute bottom-0 left-0 w-full h-1 bg-purple-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('cuti')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'cuti' ? 'text-purple-600' : 'text-gray-400 hover:text-gray-600' }}">
                Pengajuan Cuti
                @if($activeTab == 'cuti') <div class="absolute bottom-0 left-0 w-full h-1 bg-purple-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('kinerja')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'kinerja' ? 'text-purple-600' : 'text-gray-400 hover:text-gray-600' }}">
                Analitik Kinerja
                @if($activeTab == 'kinerja') <div class="absolute bottom-0 left-0 w-full h-1 bg-purple-600 rounded-t-full"></div> @endif
            </button>
        </div>

        <div class="p-8 min-h-[400px]">
            <!-- TAB 1: IKHTISAR -->
            @if($activeTab == 'ikhtisar')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Peringatan Dokumen STR/SIP</h4>
                            <div class="space-y-3">
                                @forelse($tabData['dokumenAlert'] as $alert)
                                    <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-800 rounded-xl border border-red-100 dark:border-red-900/30 shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-xs">!</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $alert->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $alert->nip }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-bold text-red-600 block">STR: {{ \Carbon\Carbon::parse($alert->masa_berlaku_str)->format('d M Y') }}</span>
                                            <span class="text-[10px] text-gray-400">Segera perbarui</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-400 text-sm">Semua dokumen pegawai masih berlaku aman.</div>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Biaya Gaji Bulan Ini</h4>
                            <div class="p-6 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl text-white shadow-lg">
                                <p class="text-sm font-medium text-emerald-100">Total Penggajian</p>
                                <h3 class="text-3xl font-black mt-1">Rp {{ number_format($tabData['gajiBulanIni'], 0, ',', '.') }}</h3>
                                <p class="text-xs mt-4 opacity-80">Sudah termasuk tunjangan dan potongan pajak.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Komposisi SDM</h4>
                        <div class="space-y-4">
                            @foreach($tabData['komposisiRole'] as $role)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-gray-600 dark:text-gray-300 capitalize">{{ str_replace('_', ' ', $role->role) }}</span>
                                    <div class="flex items-center gap-3">
                                        <div class="w-24 bg-gray-100 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                            <div class="bg-purple-500 h-full rounded-full" style="width: {{ ($role->total / $totalPegawai) * 100 }}%"></div>
                                        </div>
                                        <span class="text-sm font-black w-6 text-right">{{ $role->total }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 2: PRESENSI -->
            @if($activeTab == 'presensi')
                <div class="animate-fade-in-up space-y-8">
                    <!-- Stats Presensi -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-100 dark:border-blue-800 text-center">
                            <span class="text-xs font-bold text-blue-600 block mb-1">Dijadwalkan</span>
                            <span class="text-2xl font-black text-blue-800 dark:text-blue-300">{{ $tabData['statistikKehadiran']['total'] }}</span>
                        </div>
                        <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800 text-center">
                            <span class="text-xs font-bold text-emerald-600 block mb-1">Hadir (Simulasi)</span>
                            <span class="text-2xl font-black text-emerald-800 dark:text-emerald-300">{{ $tabData['statistikKehadiran']['hadir'] }}</span>
                        </div>
                        <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-2xl border border-red-100 dark:border-red-800 text-center">
                            <span class="text-xs font-bold text-red-600 block mb-1">Belum Hadir</span>
                            <span class="text-2xl font-black text-red-800 dark:text-red-300">{{ $tabData['statistikKehadiran']['absen'] }}</span>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Jadwal Jaga Hari Ini</h4>
                        <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-bold text-gray-500 uppercase">Pegawai</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-500 uppercase">Unit/Ruangan</th>
                                        <th class="px-4 py-3 text-center font-bold text-gray-500 uppercase">Shift</th>
                                        <th class="px-4 py-3 text-center font-bold text-gray-500 uppercase">Jam</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($tabData['jadwalHariIni'] as $jadwal)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                            <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $jadwal->pegawai->user->name }}</td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $jadwal->ruangan->nama_ruangan ?? '-' }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="px-2 py-1 rounded text-xs font-bold bg-purple-100 text-purple-700">{{ $jadwal->shift->nama_shift }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-center font-mono text-gray-500">{{ $jadwal->shift->jam_masuk }} - {{ $jadwal->shift->jam_keluar }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Tidak ada jadwal jaga hari ini.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 3: CUTI -->
            @if($activeTab == 'cuti')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-up">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Sedang Cuti Hari Ini</h4>
                        <div class="space-y-3">
                            @forelse($tabData['sedangCuti'] as $cuti)
                                <div class="flex items-center gap-4 p-4 bg-orange-50 dark:bg-orange-900/20 rounded-2xl border border-orange-100 dark:border-orange-800">
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-orange-600 font-bold shadow-sm">
                                        {{ substr($cuti->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-bold text-gray-900 dark:text-white">{{ $cuti->user->name }}</h5>
                                        <p class="text-xs text-gray-500">{{ $cuti->jenis_cuti }} • Hingga {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center py-8 text-gray-400 text-sm border border-dashed border-gray-200 rounded-2xl">Tidak ada pegawai cuti hari ini.</p>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Pengajuan Cuti Menunggu Persetujuan</h4>
                        <div class="space-y-3">
                            @forelse($tabData['cutiPending'] as $pending)
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <div class="flex justify-between items-start mb-2">
                                        <h5 class="text-sm font-bold text-gray-900 dark:text-white">{{ $pending->user->name }}</h5>
                                        <span class="text-xs font-bold bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Menunggu</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mb-3">{{ $pending->alasan }}</p>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="font-mono text-gray-600">{{ \Carbon\Carbon::parse($pending->tanggal_mulai)->format('d/m') }} - {{ \Carbon\Carbon::parse($pending->tanggal_selesai)->format('d/m/Y') }}</span>
                                        <a href="#" class="text-indigo-600 font-bold hover:underline">Review &rarr;</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center py-8 text-gray-400 text-sm border border-dashed border-gray-200 rounded-2xl">Tidak ada pengajuan baru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 4: KINERJA -->
            @if($activeTab == 'kinerja')
                <div class="animate-fade-in-up space-y-8">
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Top Performance (Bulan Ini)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($tabData['topPerformance'] as $k)
                                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                                    <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-bl from-yellow-400 to-transparent opacity-20 rounded-bl-full"></div>
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                                            {{ substr($k->pegawai->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h5 class="text-sm font-bold text-gray-900 dark:text-white">{{ $k->pegawai->user->name }}</h5>
                                            <p class="text-[10px] text-gray-500 uppercase tracking-wider">{{ $k->pegawai->jabatan }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-end">
                                        <span class="text-xs text-gray-400">Rata-rata Skor</span>
                                        <span class="text-2xl font-black text-indigo-600">{{ number_format($k->rata_rata, 1) }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-12 text-center border border-dashed border-gray-200 rounded-2xl text-gray-400">Belum ada data penilaian kinerja bulan ini.</div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tren Kinerja Rata-rata (6 Bulan)</h4>
                        <div class="h-64 flex items-end justify-between gap-4 bg-slate-50 dark:bg-slate-700/30 p-6 rounded-2xl border border-slate-100 dark:border-slate-700">
                            @foreach($tabData['trenKinerja']['data'] as $idx => $val)
                                <div class="flex flex-col items-center flex-1 h-full justify-end group">
                                    <div class="w-full max-w-[60px] bg-indigo-500 rounded-t-lg relative transition-all duration-300 hover:bg-indigo-600" 
                                         style="height: {{ $val > 0 ? ($val / 100) * 100 : 0 }}%">
                                         <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">{{ $val }}</span>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500 mt-2">{{ $tabData['trenKinerja']['labels'][$idx] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>