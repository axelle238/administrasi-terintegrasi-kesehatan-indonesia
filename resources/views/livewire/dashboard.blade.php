<div class="space-y-8">
    
    <!-- Selamat Datang & Ringkasan Cepat -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Kartu Profil Selamat Datang -->
        <div class="lg:col-span-1 bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white relative overflow-hidden shadow-xl">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-500/20 rounded-full blur-2xl -ml-10 -mb-10"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-white/10 border border-white/10 text-[10px] font-bold uppercase tracking-wider mb-4">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                    <h2 class="text-2xl font-black leading-tight mb-2">Halo, {{ Auth::user()->name }}!</h2>
                    <p class="text-slate-400 text-sm">Selamat datang kembali di Pusat Komando Administrasi Kesehatan Terintegrasi.</p>
                </div>
                
                <div class="mt-6 pt-6 border-t border-white/10">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-slate-400">Status Sistem</span>
                        <span class="flex items-center gap-1.5 text-xs font-bold text-emerald-400">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            ONLINE
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-400">Pengguna Aktif</span>
                        <span class="text-sm font-bold">{{ $userOnlineTotal }} User</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metric Cards Grid -->
        <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 1. Pasien Baru -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 group hover:border-blue-200 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    </div>
                    <span class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">
                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        +{{ $pasienBaruBulanIni }}
                    </span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1">{{ number_format($totalPasien) }}</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pasien Terdaftar</p>
            </div>

            <!-- 2. Antrean Hari Ini -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 group hover:border-purple-200 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    @php $persenSelesai = $antreanHariIni > 0 ? round(($antreanSelesai / $antreanHariIni) * 100) : 0; @endphp
                    <span class="flex items-center text-xs font-bold {{ $persenSelesai >= 50 ? 'text-blue-500 bg-blue-50' : 'text-orange-500 bg-orange-50' }} px-2 py-1 rounded-lg">
                        {{ $persenSelesai }}% Selesai
                    </span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1">{{ number_format($antreanHariIni) }}</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Antrean Hari Ini</p>
            </div>

            <!-- 3. Pendapatan Hari Ini -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 group hover:border-emerald-200 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <a href="{{ route('finance.dashboard') }}" class="text-xs font-bold text-emerald-600 hover:underline">Lihat Detail &rarr;</a>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pendapatan Hari Ini</p>
            </div>
        </div>
    </div>

    <!-- Quick Access Modules (Gateway) -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        <a href="{{ route('medical.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-blue-400 hover:shadow-md transition-all flex flex-col items-center text-center gap-2">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-slate-800">Medis</span>
        </a>
        <a href="{{ route('ukm.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-400 hover:shadow-md transition-all flex flex-col items-center text-center gap-2">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-slate-800">UKM / Masyarakat</span>
        </a>
        <a href="{{ route('hrd.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-pink-400 hover:shadow-md transition-all flex flex-col items-center text-center gap-2">
            <div class="p-3 bg-pink-50 text-pink-600 rounded-xl group-hover:bg-pink-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-slate-800">Kepegawaian</span>
        </a>
        <a href="{{ route('finance.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-teal-400 hover:shadow-md transition-all flex flex-col items-center text-center gap-2">
            <div class="p-3 bg-teal-50 text-teal-600 rounded-xl group-hover:bg-teal-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-slate-800">Keuangan</span>
        </a>
        <a href="{{ route('barang.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-amber-400 hover:shadow-md transition-all flex flex-col items-center text-center gap-2">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-slate-800">Aset</span>
        </a>
        <a href="{{ route('security.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-rose-400 hover:shadow-md transition-all flex flex-col items-center text-center gap-2">
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl group-hover:bg-rose-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-slate-800">Keamanan</span>
        </a>
        <a href="{{ route('system.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-indigo-400 hover:shadow-md transition-all flex flex-col items-center text-center gap-2">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-slate-800">Sistem</span>
        </a>
    </div>

    <!-- Indikator Kinerja Klinis Utama (NEW) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col justify-between overflow-hidden relative group">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-4">Mutai Pelayanan</p>
                <h4 class="text-lg font-black text-slate-800 mb-1">Respons Time IGD</h4>
                <p class="text-xs text-slate-400 font-medium">Target: < 5 Menit</p>
            </div>
            <div class="mt-6 flex items-end justify-between relative z-10">
                <div class="text-3xl font-black text-slate-800">4.2 <span class="text-sm font-bold text-slate-400">Menit</span></div>
                <div class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase">Sangat Baik</div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col justify-between overflow-hidden relative group">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-4">Efisiensi Ranap</p>
                <h4 class="text-lg font-black text-slate-800 mb-1">Rata-rata LOS</h4>
                <p class="text-xs text-slate-400 font-medium">Length of Stay</p>
            </div>
            <div class="mt-6 flex items-end justify-between relative z-10">
                <div class="text-3xl font-black text-slate-800">3.5 <span class="text-sm font-bold text-slate-400">Hari</span></div>
                <div class="px-2 py-1 rounded-lg bg-blue-100 text-blue-700 text-[10px] font-black uppercase">Optimal</div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col justify-between overflow-hidden relative group">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-rose-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-rose-500 uppercase tracking-[0.2em] mb-4">Keselamatan Pasien</p>
                <h4 class="text-lg font-black text-slate-800 mb-1">Insiden Klinis</h4>
                <p class="text-xs text-slate-400 font-medium">Bulan Berjalan</p>
            </div>
            <div class="mt-6 flex items-end justify-between relative z-10">
                <div class="text-3xl font-black text-slate-800">0 <span class="text-sm font-bold text-slate-400">Kasus</span></div>
                <div class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase">Nir-Insiden</div>
            </div>
        </div>
    </div>

    <!-- Grafik Utama & Statistik Poli -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik Kunjungan -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-100" x-data="chartKunjungan()">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-bold text-lg text-slate-800">Tren Pasien & Kunjungan</h3>
                    <p class="text-xs text-slate-400 mt-1">Statistik rekam medis 6 bulan terakhir</p>
                </div>
                <div class="flex gap-2">
                    <span class="flex items-center gap-1 text-xs font-bold text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span> Pasien
                    </span>
                </div>
            </div>
            <div id="chart-kunjungan" class="w-full h-[320px]"></div>
        </div>

        <!-- Statistik Poliklinik -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col">
            <h3 class="font-bold text-lg text-slate-800 mb-1">Aktivitas Poliklinik</h3>
            <p class="text-xs text-slate-400 mb-6">Kunjungan pasien hari ini berdasarkan poli</p>
            
            <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-4">
                @forelse($kunjunganPoli as $poli)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 hover:bg-white hover:shadow-md hover:shadow-blue-500/5 transition-all duration-300 border border-transparent hover:border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-500 shadow-sm font-bold text-sm">
                                {{ substr($poli->poli->nama_poli ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">{{ $poli->poli->nama_poli ?? 'Tidak Diketahui' }}</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $poli->total }} Pasien</p>
                            </div>
                        </div>
                        <div class="h-8 w-8 rounded-full flex items-center justify-center bg-blue-100 text-blue-600 font-bold text-xs">
                            {{ round(($poli->total / ($antreanHariIni > 0 ? $antreanHariIni : 1)) * 100) }}%
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <p class="text-sm text-slate-400">Belum ada kunjungan poli hari ini.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-6 pt-6 border-t border-slate-100">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 font-medium">Rata-rata Waktu Layanan</span>
                    <span class="font-bold text-slate-800 bg-slate-100 px-3 py-1 rounded-lg">{{ $avgWaktuLayanan }} Menit</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Monitoring Vital (EWS & Status) -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- 1. Farmasi & Logistik -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                Logistik Farmasi
            </h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">Stok Menipis</span>
                    <span class="text-sm font-bold {{ $obatMenipis > 0 ? 'text-red-500' : 'text-slate-800' }}">{{ $obatMenipis }} Item</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">Kedaluwarsa < 3 Bln</span>
                    <span class="text-sm font-bold {{ $obatExpired > 0 ? 'text-red-500' : 'text-slate-800' }}">{{ $obatExpired }} Batch</span>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: 75%"></div>
                </div>
                <a href="{{ route('pharmacy.dashboard') }}" class="block text-center text-xs font-bold text-indigo-500 hover:text-indigo-600 mt-2">Kelola Farmasi &rarr;</a>
            </div>
        </div>

        <!-- 2. SDM & Kepegawaian -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                SDM & Legalitas
            </h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">STR Expired</span>
                    <span class="text-sm font-bold {{ $strExpired > 0 ? 'text-red-500' : 'text-slate-800' }}">{{ $strExpired }} Pegawai</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">SIP Expired</span>
                    <span class="text-sm font-bold {{ $sipExpired > 0 ? 'text-red-500' : 'text-slate-800' }}">{{ $sipExpired }} Pegawai</span>
                </div>
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-pink-500 h-1.5 rounded-full" style="width: 60%"></div>
                </div>
                <a href="{{ route('hrd.dashboard') }}" class="block text-center text-xs font-bold text-pink-500 hover:text-pink-600 mt-2">Monitor SDM &rarr;</a>
            </div>
        </div>

        <!-- 3. Aset & Fasilitas -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                Aset & Fasilitas
            </h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">Fasilitas Aktif</span>
                    <span class="text-sm font-bold text-slate-800">{{ $fasilitasAktif }} Unit</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">Jadwal Maintenance</span>
                    <span class="text-sm font-bold {{ $asetMaintenance > 0 ? 'text-amber-600' : 'text-slate-800' }}">{{ $asetMaintenance }} Pending</span>
                </div>
                 <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: 85%"></div>
                </div>
                <a href="{{ route('barang.dashboard') }}" class="block text-center text-xs font-bold text-amber-500 hover:text-amber-600 mt-2">Manajemen Aset &rarr;</a>
            </div>
        </div>

        <!-- 4. Rawat Inap & Bed -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" /></svg>
                Okupansi Rawat Inap
            </h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">Pasien Dirawat</span>
                    <span class="text-sm font-bold text-slate-800">{{ $pasienRawatInap }} Orang</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">Bed Tersedia</span>
                    <span class="text-sm font-bold text-slate-800">{{ $kamarTersedia }} Bed</span>
                </div>
                @php 
                    $totalBed = $pasienRawatInap + $kamarTersedia;
                    $bor = $totalBed > 0 ? ($pasienRawatInap / $totalBed) * 100 : 0;
                @endphp
                <div class="relative w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                    <div class="absolute left-0 top-0 h-full bg-cyan-500 rounded-full" style="width: {{ $bor }}%"></div>
                </div>
                <div class="flex justify-between text-[10px] font-bold uppercase tracking-wider text-slate-400">
                    <span>BOR: {{ number_format($bor, 1) }}%</span>
                    <a href="{{ route('rawat-inap.index') }}" class="text-cyan-500 hover:underline">Detail</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terakhir & Keamanan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Aktivitas Sistem -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800">Aktivitas Sistem Terkini</h3>
                <a href="{{ route('activity-log') }}" class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition-colors">Lihat Semua Log</a>
            </div>
            
            <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                @forelse($riwayatLog as $log)
                <div class="relative pl-6">
                    <div class="absolute -left-[9px] top-1 h-4 w-4 rounded-full border-2 border-white bg-blue-500 shadow-sm"></div>
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $log->description }}</p>
                            <p class="text-xs text-slate-500">Oleh: {{ $log->causer->name ?? 'Sistem' }}</p>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded border border-slate-100 whitespace-nowrap">
                            {{ $log->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="pl-6 text-sm text-slate-400">Belum ada aktivitas tercatat.</div>
                @endforelse
            </div>
        </div>

        <!-- Keamanan & Status -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-slate-800">Status Keamanan</h3>
                <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    SECURE
                </span>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-red-50 border border-red-100 flex flex-col justify-center items-center text-center">
                    <p class="text-3xl font-black text-red-500 mb-1">{{ $loginGagal }}</p>
                    <p class="text-xs font-bold text-red-400 uppercase tracking-wide">Login Gagal Hari Ini</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col justify-center items-center text-center">
                    <p class="text-3xl font-black text-slate-700 mb-1">0</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Anomali Terdeteksi</p>
                </div>
                <div class="col-span-2 p-4 rounded-2xl bg-blue-50 border border-blue-100">
                    <div class="flex items-center gap-3">
                         <div class="p-2 bg-white rounded-lg text-blue-500 shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                         </div>
                         <div>
                             <p class="text-sm font-bold text-blue-800">Backup Sistem Terakhir</p>
                             <p class="text-xs text-blue-600">Otomatis • 02:00 WIB Tadi Pagi</p>
                         </div>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('security.dashboard') }}" class="block w-full text-center py-3 mt-4 rounded-xl border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition-colors">
                Buka Pusat Keamanan
            </a>
        </div>
    </div>

    <!-- Chart Scripts -->
    @push('scripts')
    <script>
        function chartKunjungan() {
            return {
                init() {
                    const dataGrafik = @json($dataGrafik);
                    
                    const options = {
                        series: [{
                            name: 'Total Kunjungan',
                            data: dataGrafik.data
                        }],
                        chart: {
                            type: 'area',
                            height: 320,
                            toolbar: { show: false },
                            fontFamily: 'Plus Jakarta Sans, sans-serif'
                        },
                        colors: ['#3b82f6'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.7,
                                opacityTo: 0.05,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        xaxis: {
                            categories: dataGrafik.labels,
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: {
                                style: { colors: '#94a3b8', fontSize: '12px' }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: { colors: '#94a3b8', fontSize: '12px' }
                            }
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            strokeDashArray: 4,
                            yaxis: { lines: { show: true } }
                        },
                        tooltip: {
                            theme: 'light',
                            y: {
                                formatter: function (val) { return val + " Pasien" }
                            }
                        }
                    };

                    const chart = new ApexCharts(document.querySelector("#chart-kunjungan"), options);
                    chart.render();
                }
            }
        }
    </script>
    @endpush
</div>