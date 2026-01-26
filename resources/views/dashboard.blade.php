<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight font-[Outfit]">
            {{ __('Pusat Komando & Informasi') }}
        </h2>
    </x-slot>

    <!-- Welcome & EWS Banner -->
    <div class="mb-8">
        <div class="relative bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/medical-icons.png')]"></div>
            <div class="relative p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-3xl font-extrabold text-white font-[Outfit] tracking-tight">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-slate-300 mt-2 text-lg">
                        Sistem berjalan optimal. Berikut adalah ringkasan operasional hari ini.
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <span class="px-3 py-1 bg-white/10 text-white rounded-lg text-sm font-semibold border border-white/20 backdrop-blur-sm">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-lg text-sm font-semibold border border-blue-500/30 backdrop-blur-sm">
                             v2.5.0 Enterprise
                        </span>
                    </div>
                </div>

                <!-- EWS Alerts (Early Warning System) -->
                @if($strExpired > 0 || $sipExpired > 0 || $obatExpired > 0)
                <div class="flex-shrink-0 bg-red-500/10 border border-red-500/30 rounded-xl p-4 backdrop-blur-md max-w-sm w-full animate-pulse">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <h4 class="font-bold text-red-200">Peringatan Dini (EWS)</h4>
                    </div>
                    <ul class="space-y-1 text-sm text-red-100">
                        @if($strExpired > 0) <li>• {{ $strExpired }} Pegawai STR akan kedaluwarsa</li> @endif
                        @if($sipExpired > 0) <li>• {{ $sipExpired }} Pegawai SIP akan kedaluwarsa</li> @endif
                        @if($obatExpired > 0) <li>• {{ $obatExpired }} Batch Obat akan kedaluwarsa</li> @endif
                    </ul>
                </div>
                @else
                <div class="hidden md:flex flex-col items-end opacity-80">
                    <svg class="w-24 h-24 text-white/10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm text-slate-400 mt-2 font-medium">Semua Lisensi & Stok Aman</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- SECTION 1: LAYANAN MEDIS & OPERASIONAL -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            Layanan Medis & Operasional
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Antrean Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Antrean Hari Ini</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <h4 class="text-4xl font-extrabold text-slate-800">{{ $antreanHariIni }}</h4>
                        <span class="text-sm text-slate-500 font-medium">Pasien</span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                         <a href="{{ route('antrean.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                            KELOLA <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rawat Inap Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-teal-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Pasien Rawat Inap</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <h4 class="text-4xl font-extrabold text-slate-800">{{ $pasienRawatInap }}</h4>
                        <span class="text-sm text-slate-500 font-medium">Orang</span>
                    </div>
                     <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                         <a href="{{ route('rawat-inap.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-800 flex items-center gap-1">
                            MONITOR <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <div class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center text-teal-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kamar Tersedia Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Kamar Tersedia</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <h4 class="text-4xl font-extrabold text-slate-800">{{ $kamarTersedia }}</h4>
                        <span class="text-sm text-slate-500 font-medium">Bed</span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                         <a href="{{ route('rawat-inap.kamar') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                            CEK KETERSEDIAAN <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                           <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pasien -->
             <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Total Pasien</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <h4 class="text-4xl font-extrabold text-slate-800">{{ number_format($totalPasien) }}</h4>
                        <span class="text-sm text-slate-500 font-medium">Database</span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                         <a href="{{ route('pasien.index') }}" class="text-xs font-bold text-purple-600 hover:text-purple-800 flex items-center gap-1">
                            DATABASE <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600">
                           <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: KEUANGAN & CHART -->
    @can('admin')
    <div class="mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Keuangan & Statistik
        </h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Financial Stats -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-6 -mt-6 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                    <p class="text-emerald-100 font-medium text-sm uppercase tracking-wider mb-1">Pendapatan Hari Ini</p>
                    <h4 class="text-3xl font-extrabold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h4>
                    <p class="text-xs text-emerald-200 mt-4 bg-black/10 inline-block px-2 py-1 rounded">Updated: Realtime</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-wider mb-2">Akumulasi Bulan Ini</p>
                    <h4 class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h4>
                    <div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 65%"></div>
                    </div>
                </div>

                 <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-wider mb-2">Estimasi Beban Gaji</p>
                    <h4 class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($pengeluaranGaji, 0, ',', '.') }}</h4>
                </div>
            </div>

            <!-- Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                         <h4 class="font-bold text-slate-800 text-lg">Tren Kunjungan Pasien</h4>
                         <p class="text-sm text-slate-400">Statistik 6 bulan terakhir</p>
                    </div>
                </div>
                <div class="flex-1 w-full min-h-[300px]">
                    <canvas id="kunjunganChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <!-- SECTION 3: ADMINISTRASI & ASET -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Administrasi & Inventaris
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('surat.index') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:border-amber-400 transition-colors flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h5 class="font-bold text-slate-800">Surat Masuk</h5>
                    <p class="text-sm text-slate-500">{{ $suratMasuk }} Dokumen perlu diarsip</p>
                </div>
            </a>

            <a href="{{ route('obat.index') }}" class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:border-red-400 transition-colors flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <div>
                    <h5 class="font-bold text-slate-800">Stok Obat Menipis</h5>
                    <p class="text-sm text-slate-500">{{ $obatMenipis }} Item perlu restock</p>
                </div>
            </a>

            <a href="#" class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:border-blue-400 transition-colors flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h5 class="font-bold text-slate-800">Maintenance Aset</h5>
                    <p class="text-sm text-slate-500">{{ $asetMaintenance }} Jadwal pemeliharaan</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Chart Script -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const ctx = document.getElementById('kunjunganChart');
            if(ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($dataGrafik['labels']),
                        datasets: [{
                            label: 'Jumlah Kunjungan',
                            data: @json($dataGrafik['data']),
                            borderColor: '#0ea5e9',
                            backgroundColor: 'rgba(14, 165, 233, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { borderDash: [2, 4], color: '#e2e8f0' }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>