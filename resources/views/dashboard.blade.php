<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black text-slate-800 leading-tight font-display tracking-tight">
            {{ __('Pusat Komando & Informasi Utama') }}
        </h2>
    </x-slot>

    <!-- Welcome & Status Banner -->
    <div class="mb-8 animate-fade-in">
        <div class="relative bg-slate-900 rounded-[2rem] shadow-2xl overflow-hidden border border-slate-800">
            <!-- Background Effects -->
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/medical-icons.png')]"></div>
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-blue-600/30 rounded-full blur-[100px]"></div>
            <div class="absolute -left-20 -bottom-20 w-96 h-96 bg-violet-600/20 rounded-full blur-[100px]"></div>

            <div class="relative p-8 flex flex-col md:flex-row items-center justify-between gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-500/30 backdrop-blur-md">
                             Sistem Terintegrasi v2.0
                        </span>
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-500/30 backdrop-blur-md flex items-center gap-2">
                             <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Operasional Normal
                        </span>
                    </div>
                    <h3 class="text-3xl md:text-4xl font-black text-white font-display tracking-tight leading-none mb-4">
                        Selamat Datang, {{ Auth::user()->name }}
                    </h3>
                    <p class="text-slate-400 text-lg max-w-2xl leading-relaxed">
                        Pusat kendali operasional rumah sakit. Pantau statistik real-time, kelola sumber daya, dan ambil keputusan berbasis data.
                    </p>
                </div>

                <!-- Quick Stats / EWS -->
                @if($strExpired > 0 || $sipExpired > 0 || $obatExpired > 0)
                <div class="bg-rose-950/50 border border-rose-500/30 rounded-2xl p-5 backdrop-blur-md max-w-sm w-full animate-pulse">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="p-2 bg-rose-500/20 rounded-lg text-rose-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-rose-200 uppercase text-xs tracking-widest">Peringatan Sistem</h4>
                            <p class="text-[10px] text-rose-300">Tindakan Diperlukan Segera</p>
                        </div>
                    </div>
                    <ul class="space-y-2 text-xs font-bold text-rose-100/80">
                        @if($strExpired > 0) <li class="flex items-center gap-2"><span class="w-1 h-1 bg-rose-500 rounded-full"></span> {{ $strExpired }} STR Pegawai Kedaluwarsa</li> @endif
                        @if($sipExpired > 0) <li class="flex items-center gap-2"><span class="w-1 h-1 bg-rose-500 rounded-full"></span> {{ $sipExpired }} SIP Pegawai Kedaluwarsa</li> @endif
                        @if($obatExpired > 0) <li class="flex items-center gap-2"><span class="w-1 h-1 bg-rose-500 rounded-full"></span> {{ $obatExpired }} Batch Obat Expired</li> @endif
                    </ul>
                </div>
                @else
                <div class="hidden md:flex flex-col items-end opacity-60">
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-sm text-right">
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Waktu Server</p>
                        <p class="text-2xl font-black text-white font-mono">{{ \Carbon\Carbon::now()->format('H:i') }} <span class="text-sm text-slate-500">WIB</span></p>
                        <p class="text-xs text-slate-400 mt-1 font-bold">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cluster Navigation Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8">
        <!-- Manajemen -->
        <a href="{{ route('hrd.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-slate-300 hover:shadow-md transition-all flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-slate-800 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Manajemen SDM</h4>
                <p class="text-[10px] text-slate-400 mt-1">Kepegawaian</p>
            </div>
        </a>

        <!-- Keuangan -->
        <a href="{{ route('finance.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-emerald-300 hover:shadow-md transition-all flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Keuangan</h4>
                <p class="text-[10px] text-slate-400 mt-1">Billing & Kas</p>
            </div>
        </a>

        <!-- Medis -->
        <a href="{{ route('medical.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-rose-300 hover:shadow-md transition-all flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Layanan Medis</h4>
                <p class="text-[10px] text-slate-400 mt-1">KIA & Rawat Jalan</p>
            </div>
        </a>

        <!-- Farmasi -->
        <a href="{{ route('pharmacy.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-teal-300 hover:shadow-md transition-all flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Farmasi</h4>
                <p class="text-[10px] text-slate-400 mt-1">Stok Obat</p>
            </div>
        </a>

        <!-- Aset -->
        <a href="{{ route('barang.dashboard') }}" class="group bg-white p-4 rounded-2xl shadow-sm border border-slate-100 hover:border-indigo-300 hover:shadow-md transition-all flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider">Aset Logistik</h4>
                <p class="text-[10px] text-slate-400 mt-1">Inventaris RS</p>
            </div>
        </a>
    </div>

    <!-- MAIN KPI CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pasien Hari Ini -->
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Antrean Hari Ini</p>
                </div>
                <div class="flex items-baseline gap-1">
                    <h3 class="text-4xl font-black text-slate-800">{{ $antreanHariIni }}</h3>
                    <span class="text-sm font-bold text-slate-400">Pasien</span>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-xs text-slate-500">{{ $antreanSelesai }} Selesai Dilayani</span>
                    <a href="{{ route('antrean.index') }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Rawat Inap -->
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-teal-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 bg-teal-500 rounded-full"></span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Okupansi Bed</p>
                </div>
                <div class="flex items-baseline gap-1">
                    <h3 class="text-4xl font-black text-slate-800">{{ $pasienRawatInap }}</h3>
                    <span class="text-sm font-bold text-slate-400">Terisi</span>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-xs text-slate-500">{{ $kamarTersedia }} Bed Tersedia</span>
                    <a href="{{ route('rawat-inap.index') }}" class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center hover:bg-teal-600 hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendapatan Harian</p>
                </div>
                <div class="flex items-baseline gap-1">
                    <h3 class="text-3xl font-black text-slate-800">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Akumulasi Bulan Ini</span>
                    <a href="{{ route('finance.dashboard') }}" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Keamanan -->
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-rose-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 {{ $loginGagal > 0 ? 'bg-rose-500 animate-ping' : 'bg-slate-400' }} rounded-full"></span>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Keamanan Sistem</p>
                </div>
                <div class="flex items-baseline gap-1">
                    @if($loginGagal > 0)
                        <h3 class="text-4xl font-black text-rose-600">{{ $loginGagal }}</h3>
                        <span class="text-sm font-bold text-rose-400">Insiden</span>
                    @else
                        <h3 class="text-4xl font-black text-emerald-600">Aman</h3>
                    @endif
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-xs text-slate-500">{{ $loginGagal > 0 ? 'Login Gagal Terdeteksi' : 'Tidak ada ancaman' }}</span>
                    <a href="{{ route('security.dashboard') }}" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- VISUALISASI DATA -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Grafik Kunjungan -->
        <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h4 class="text-xl font-black text-slate-800">Tren Kunjungan Pasien</h4>
                    <p class="text-xs font-bold text-slate-400 uppercase mt-1">Analisis 6 Bulan Terakhir</p>
                </div>
                <div class="flex gap-2">
                     <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase">Rawat Jalan</span>
                </div>
            </div>
            <div id="kunjunganChart" class="w-full h-[300px]"></div>
        </div>

        <!-- Feed Aktivitas -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 flex flex-col">
            <h4 class="text-xl font-black text-slate-800 mb-6">Aktivitas Terkini</h4>
            <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-6">
                @foreach($riwayatLog as $log)
                <div class="flex gap-4 relative">
                    <div class="flex flex-col items-center">
                        <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                        <div class="w-0.5 h-full bg-slate-100 my-1"></div>
                    </div>
                    <div class="pb-2">
                        <p class="text-xs font-black text-slate-800">{{ $log->description }}</p>
                        <p class="text-[10px] text-slate-500 mt-0.5">
                            <span class="font-bold text-blue-600">{{ $log->causer->name ?? 'System' }}</span> • {{ $log->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('activity-log') }}" class="mt-6 w-full py-3 bg-slate-50 text-slate-600 rounded-xl text-xs font-black uppercase tracking-widest text-center hover:bg-slate-100 transition-colors">
                Lihat Semua Log
            </a>
        </div>
    </div>

    <!-- Chart Script -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart Kunjungan (ApexCharts)
            var optionsKunjungan = {
                series: [{
                    name: 'Total Pasien',
                    data: @json($dataGrafik['data'])
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: { show: false },
                    fontFamily: 'Plus Jakarta Sans, sans-serif'
                },
                colors: ['#3b82f6'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: {
                    categories: @json($dataGrafik['labels']),
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 'bold' } }
                },
                yaxis: {
                    labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 'bold' } }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    padding: { top: 0, right: 0, bottom: 0, left: 10 }
                },
                tooltip: { theme: 'light' }
            };

            var chart = new ApexCharts(document.querySelector("#kunjunganChart"), optionsKunjungan);
            chart.render();
        });
    </script>
    @endpush
</x-app-layout>