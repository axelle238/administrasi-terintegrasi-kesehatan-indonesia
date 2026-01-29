<div class="space-y-8">
    <!-- Row 1: Real-time Attendance & Alerts -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Kehadiran Hari Ini (Updated) -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-black text-slate-800 dark:text-white">Kehadiran Hari Ini</h3>
                    <p class="text-xs text-slate-500 font-bold">Total Dijadwalkan: <span class="text-indigo-600">{{ $kehadiranStatistik['dijadwalkan'] }} Pegawai</span></p>
                </div>
                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                    <span class="block text-2xl font-black text-emerald-600">{{ $kehadiranStatistik['hadir'] }}</span>
                    <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider">Hadir Tepat Waktu</span>
                </div>
                <div class="p-3 bg-yellow-50 rounded-xl border border-yellow-100">
                    <span class="block text-2xl font-black text-yellow-600">{{ $kehadiranStatistik['terlambat'] }}</span>
                    <span class="text-[10px] font-bold text-yellow-800 uppercase tracking-wider">Terlambat</span>
                </div>
                <div class="p-3 bg-red-50 rounded-xl border border-red-100">
                    <span class="block text-2xl font-black text-red-600">{{ $kehadiranStatistik['alpa'] }}</span>
                    <span class="text-[10px] font-bold text-red-800 uppercase tracking-wider">Belum Hadir/Alpa</span>
                </div>
            </div>
            
            <!-- Progress Bar Visual -->
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden flex">
                <div class="bg-emerald-500 h-full" style="width: {{ $kehadiranStatistik['dijadwalkan'] > 0 ? ($kehadiranStatistik['hadir'] / $kehadiranStatistik['dijadwalkan']) * 100 : 0 }}%"></div>
                <div class="bg-yellow-500 h-full" style="width: {{ $kehadiranStatistik['dijadwalkan'] > 0 ? ($kehadiranStatistik['terlambat'] / $kehadiranStatistik['dijadwalkan']) * 100 : 0 }}%"></div>
                <div class="bg-red-500 h-full" style="width: {{ $kehadiranStatistik['dijadwalkan'] > 0 ? ($kehadiranStatistik['alpa'] / $kehadiranStatistik['dijadwalkan']) * 100 : 0 }}%"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">STR Kedaluwarsa (3 Bln)</p>
                    <h3 class="text-2xl font-black text-orange-600">{{ $strExpired }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">SIP Kedaluwarsa (3 Bln)</p>
                    <h3 class="text-2xl font-black text-red-600">{{ $sipExpired }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Grafik & Demografi -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik Kinerja -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Tren Rata-rata Kinerja Pegawai</h3>
            <div class="h-64 flex items-end justify-between gap-4 px-4">
                @foreach($trenKinerja['data'] as $index => $val)
                    <div class="flex flex-col items-center flex-1 group" title="Skor: {{ $val }}">
                        <div class="w-full bg-indigo-500 dark:bg-indigo-600 rounded-t-sm relative transition-all duration-300 hover:bg-indigo-400" 
                             style="height: {{ $val > 0 ? ($val / 100) * 100 : 0 }}%"> <!-- Asumsi max skor 100 -->
                             <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-bold text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity">{{ $val }}</span>
                        </div>
                        <span class="text-[10px] text-slate-400 mt-2 font-bold">{{ $trenKinerja['labels'][$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Demografi & Cuti -->
        <div class="space-y-6">
            <!-- Gender Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Distribusi Gender</h3>
                <div class="space-y-4">
                    @foreach($distribusiGender as $gender)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-slate-600">
                                @if($gender->jenis_kelamin == 'L') Laki-laki @else Perempuan @endif
                            </span>
                            <span class="text-sm font-black">{{ $gender->total }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="{{ $gender->jenis_kelamin == 'L' ? 'bg-blue-500' : 'bg-pink-500' }} h-2 rounded-full" style="width: {{ ($gender->total / max($totalPegawai, 1)) * 100 }}%"></div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <p class="text-xs text-center text-slate-400">Total Pegawai Aktif: <strong class="text-slate-800">{{ $totalPegawai }}</strong></p>
                </div>
            </div>

            <!-- Cuti Hari Ini -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Sedang Cuti Hari Ini <span class="bg-pink-100 text-pink-600 px-2 py-0.5 rounded-full text-xs ml-2">{{ $pegawaiCutiHariIni }}</span></h3>
                <div class="space-y-3 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($listCutiHariIni as $cuti)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-pink-50 dark:bg-pink-900/20">
                            <div class="w-8 h-8 rounded-full bg-pink-200 flex items-center justify-center text-pink-700 font-bold text-[10px]">
                                {{ substr($cuti->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-700 dark:text-gray-300 truncate">{{ $cuti->user->name }}</p>
                                <p class="text-[10px] text-slate-500 truncate">{{ $cuti->jenis_cuti }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-slate-400 text-xs py-4">Semua pegawai masuk (tidak ada cuti).</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Jadwal & Komposisi -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Jadwal Jaga -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Jadwal Jaga Hari Ini</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Pegawai</th>
                            <th class="px-4 py-3">Shift</th>
                            <th class="px-4 py-3 rounded-r-lg">Jam</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @forelse($jadwalHariIni as $jadwal)
                            <tr>
                                <td class="px-4 py-3 font-bold text-slate-700 dark:text-gray-300">
                                    {{ $jadwal->pegawai->user->name }}
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">
                                    {{ $jadwal->shift->nama_shift }}
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">
                                    {{ $jadwal->shift->jam_masuk }} - {{ $jadwal->shift->jam_keluar }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4 text-slate-400">Belum ada jadwal jaga hari ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Komposisi Role -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Komposisi SDM</h3>
            <div class="space-y-4">
                @foreach($komposisiRole as $role)
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-600 dark:text-gray-300 uppercase">{{ $role->role }}</span>
                        <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-full text-xs font-black">{{ $role->total }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ ($role->total / $totalPegawai) * 100 }}%"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Row 4: Top Kinerja -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Top Kinerja Pegawai Bulan Ini</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-400 uppercase bg-slate-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">Peringkat</th>
                        <th class="px-4 py-3">Nama Pegawai</th>
                        <th class="px-4 py-3 text-right rounded-r-lg">Total Skor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                    @forelse($topKinerja as $index => $kinerja)
                        <tr>
                            <td class="px-4 py-3 font-black text-slate-500">#{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-bold text-slate-700 dark:text-gray-300">
                                {{ $kinerja->pegawai->user->name }}
                            </td>
                            <td class="px-4 py-3 text-right font-black text-indigo-600">
                                {{ $kinerja->total_skor }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4 text-slate-400">Belum ada data kinerja bulan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
