<div class="space-y-8">
    
    <!-- Section 1: Ringkasan Eksekutif (Key Performance Indicators) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pasien & Kunjungan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pasien</p>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ number_format($totalPasien) }}</h3>
                    </div>
                </div>
                <div class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 px-3 py-1 rounded-lg w-max">
                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    +{{ $pasienBaruBulanIni }} Bulan Ini
                </div>
            </div>
        </div>

        <!-- Antrean Hari Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 dark:bg-purple-900/20 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center text-purple-600 dark:text-purple-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Antrean Hari Ini</p>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $antreanHariIni }}</h3>
                    </div>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-500">Selesai: <span class="font-bold text-slate-800 dark:text-white">{{ $antreanSelesai }}</span></span>
                    <span class="text-purple-600 font-bold bg-purple-50 px-2 py-1 rounded">Avg: {{ $avgWaktuLayanan }} Menit</span>
                </div>
            </div>
        </div>

        <!-- Pendapatan Harian -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/20 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendapatan Hari Ini</p>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mb-1">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 65%"></div>
                </div>
                <p class="text-[10px] text-slate-400 text-right">Target Harian</p>
            </div>
        </div>

        <!-- Okupansi Bed -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-orange-50 dark:bg-orange-900/20 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-900/50 flex items-center justify-center text-orange-600 dark:text-orange-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Okupansi Rawat Inap</p>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $pasienRawatInap }} <span class="text-sm font-medium text-slate-400">Pasien</span></h3>
                    </div>
                </div>
                <div class="flex items-center text-xs font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-lg w-max">
                    {{ $kamarTersedia }} Bed Tersedia
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Operasional Medis & Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik Kunjungan (Kiri - Lebar) -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Tren Kunjungan Pasien</h3>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-lg">6 Bulan Terakhir</span>
            </div>
            
            <!-- Simple CSS Bar Chart for Visual -->
            <div class="h-64 flex items-end justify-between gap-2">
                @foreach($dataGrafik['data'] as $index => $value)
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-full bg-blue-100 dark:bg-blue-900/30 rounded-t-xl relative overflow-hidden transition-all duration-500 group-hover:bg-blue-200" style="height: {{ $value > 0 ? ($value / max($dataGrafik['data']) * 100) : 0 }}%">
                            <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-blue-500 to-blue-400 opacity-80"></div>
                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-20">{{ $value }}</span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-wide">{{ $dataGrafik['labels'][$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Detail Kunjungan Poli (Kanan) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Kunjungan Poli Hari Ini</h3>
            <div class="space-y-4">
                @forelse($kunjunganPoli as $poliStat)
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors cursor-default">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 font-bold">
                                {{ substr($poliStat->poli->nama_poli ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $poliStat->poli->nama_poli ?? 'Unknown' }}</p>
                                <p class="text-xs text-slate-400">Poliklinik</p>
                            </div>
                        </div>
                        <span class="text-lg font-black text-slate-800 dark:text-white">{{ $poliStat->total }}</span>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-400 text-sm">Belum ada kunjungan hari ini.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Section 3: Early Warning System & Alerts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- EWS SDM & Farmasi -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border-l-4 border-red-500">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                Peringatan Dini (EWS)
            </h3>
            <div class="space-y-3">
                @if($strExpired > 0)
                    <div class="flex justify-between items-center bg-red-50 p-3 rounded-lg text-red-700 text-sm font-medium">
                        <span>STR Dokter Kadaluwarsa</span>
                        <span class="font-bold bg-red-200 px-2 py-0.5 rounded">{{ $strExpired }}</span>
                    </div>
                @endif
                @if($sipExpired > 0)
                    <div class="flex justify-between items-center bg-orange-50 p-3 rounded-lg text-orange-700 text-sm font-medium">
                        <span>SIP Dokter Kadaluwarsa</span>
                        <span class="font-bold bg-orange-200 px-2 py-0.5 rounded">{{ $sipExpired }}</span>
                    </div>
                @endif
                @if($obatExpired > 0)
                    <div class="flex justify-between items-center bg-yellow-50 p-3 rounded-lg text-yellow-700 text-sm font-medium">
                        <span>Obat Kedaluwarsa (3 Bulan)</span>
                        <span class="font-bold bg-yellow-200 px-2 py-0.5 rounded">{{ $obatExpired }}</span>
                    </div>
                @endif
                @if($obatMenipis > 0)
                    <div class="flex justify-between items-center bg-slate-100 p-3 rounded-lg text-slate-700 text-sm font-medium">
                        <span>Stok Obat Menipis</span>
                        <span class="font-bold bg-slate-200 px-2 py-0.5 rounded">{{ $obatMenipis }}</span>
                    </div>
                @endif
                
                @if($strExpired == 0 && $sipExpired == 0 && $obatExpired == 0 && $obatMenipis == 0)
                    <div class="text-center py-4 text-emerald-600 font-bold bg-emerald-50 rounded-xl">
                        Semua Indikator Aman
                    </div>
                @endif
            </div>
        </div>

        <!-- Top 5 Penyakit (Tabel Mini) -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Top 5 Diagnosa Bulan Ini</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Diagnosa (ICD-10)</th>
                            <th class="px-4 py-3 text-right rounded-r-lg">Total Kasus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @forelse($topPenyakit as $index => $penyakit)
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-700 dark:text-gray-300">
                                    <span class="font-bold text-blue-600 mr-2">#{{ $index + 1 }}</span>
                                    {{ $penyakit->diagnosa }}
                                </td>
                                <td class="px-4 py-3 text-right font-black text-slate-800 dark:text-white">
                                    {{ $penyakit->total }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-6 text-center text-slate-400">Belum ada data diagnosa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 4: Administrasi & Logistik Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-indigo-600 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-xs font-bold text-indigo-200 uppercase tracking-widest mb-1">Surat Masuk</p>
                <h3 class="text-3xl font-black">{{ $suratMasuk }}</h3>
                <a href="{{ route('surat.index') }}" wire:navigate class="mt-4 inline-block text-xs font-bold bg-indigo-500 hover:bg-indigo-400 px-3 py-1.5 rounded-lg transition-colors">Lihat Arsip &rarr;</a>
            </div>
            <svg class="absolute bottom-0 right-0 w-24 h-24 text-indigo-500 opacity-20 -mr-6 -mb-6 transform group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
        </div>

        <div class="bg-teal-600 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-xs font-bold text-teal-200 uppercase tracking-widest mb-1">Pengaduan</p>
                <h3 class="text-3xl font-black">{{ $pengaduanPending }} <span class="text-sm font-medium text-teal-200">Pending</span></h3>
                <a href="{{ route('admin.masyarakat.pengaduan.index') }}" wire:navigate class="mt-4 inline-block text-xs font-bold bg-teal-500 hover:bg-teal-400 px-3 py-1.5 rounded-lg transition-colors">Tindak Lanjut &rarr;</a>
            </div>
            <svg class="absolute bottom-0 right-0 w-24 h-24 text-teal-500 opacity-20 -mr-6 -mb-6 transform group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
        </div>

        <div class="bg-rose-600 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-xs font-bold text-rose-200 uppercase tracking-widest mb-1">Maintenance Aset</p>
                <h3 class="text-3xl font-black">{{ $asetMaintenance }} <span class="text-sm font-medium text-rose-200">Item</span></h3>
                <a href="{{ route('barang.maintenance') }}" wire:navigate class="mt-4 inline-block text-xs font-bold bg-rose-500 hover:bg-rose-400 px-3 py-1.5 rounded-lg transition-colors">Jadwal &rarr;</a>
            </div>
            <svg class="absolute bottom-0 right-0 w-24 h-24 text-rose-500 opacity-20 -mr-6 -mb-6 transform group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
        </div>

        <div class="bg-slate-800 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Penggajian</p>
                <h3 class="text-lg font-black truncate">Rp {{ number_format($pengeluaranGaji, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-slate-400 mb-3">Total Bulan Ini</p>
                <a href="{{ route('kepegawaian.gaji.index') }}" wire:navigate class="inline-block text-xs font-bold bg-slate-700 hover:bg-slate-600 px-3 py-1.5 rounded-lg transition-colors">Detail Payroll &rarr;</a>
            </div>
            <svg class="absolute bottom-0 right-0 w-24 h-24 text-slate-700 opacity-20 -mr-6 -mb-6 transform group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
        </div>
    </div>
</div>
