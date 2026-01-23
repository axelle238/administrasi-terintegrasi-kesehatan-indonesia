<div class="space-y-6">
    {{-- Header Stats Absensi (Personal) --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Halo, {{ Auth::user()->name }}!</h3>
                <p class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <button wire:click="clockIn" class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow transition transform hover:scale-105 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Absen Masuk / Pulang
            </button>
        </div>
    </div>

    {{-- Early Warning System (EWS) Section --}}
    @if($strExpired > 0 || $sipExpired > 0 || $obatExpired > 0 || $obatMenipis > 0)
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @if($strExpired > 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-bold">{{ $strExpired }} Pegawai</p>
                        <p class="text-xs text-red-600">STR Akan Habis (< 3 Bln)</p>
                    </div>
                </div>
            </div>
        @endif

        @if($sipExpired > 0)
            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-orange-700 font-bold">{{ $sipExpired }} Pegawai</p>
                        <p class="text-xs text-orange-600">SIP Akan Habis (< 3 Bln)</p>
                    </div>
                </div>
            </div>
        @endif

        @if($obatExpired > 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-bold">{{ $obatExpired }} Batch</p>
                        <p class="text-xs text-red-600">Obat Kedaluwarsa (< 3 Bln)</p>
                    </div>
                </div>
            </div>
        @endif

        @if($obatMenipis > 0)
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 font-bold">{{ $obatMenipis }} Item</p>
                        <p class="text-xs text-yellow-600">Stok Obat Menipis</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @endif

    {{-- Main Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Antrean Hari Ini -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-b-4 border-indigo-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm font-medium">Antrean Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $antreanHariIni }}</p>
                </div>
            </div>
        </div>

        <!-- Pasien Rawat Inap -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-b-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm font-medium">Pasien Rawat Inap</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pasienRawatInap }} <span class="text-xs font-normal text-gray-400">Org</span></p>
                </div>
            </div>
        </div>

        <!-- Kamar Tersedia -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-b-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm font-medium">Kamar Tersedia</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $kamarTersedia }} <span class="text-xs font-normal text-gray-400">Bed</span></p>
                </div>
            </div>
        </div>

        <!-- Surat Masuk -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-b-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm font-medium">Surat Masuk</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $suratMasuk }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Grafik Kunjungan -->
        <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-indigo-500">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tren Kunjungan (6 Bulan)</h3>
            <div class="relative h-64">
                <canvas id="kunjunganChart"></canvas>
            </div>
        </div>

        <!-- Grafik Pendapatan -->
        <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-green-500">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Pendapatan Harian (7 Hari Terakhir)</h3>
            <div class="relative h-64">
                <canvas id="pendapatanChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Links & System Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Menu Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('pasien.create') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition">
                    <span class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3 text-indigo-600 font-bold">+</span>
                    Pendaftaran Pasien
                </a>
                <a href="{{ route('antrean.index') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-teal-50 hover:text-teal-700 transition">
                    <span class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center mr-3 text-teal-600 font-bold">A</span>
                    Kelola Antrean
                </a>
                <a href="{{ route('kasir.index') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-green-50 hover:text-green-700 transition">
                    <span class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 text-green-600 font-bold">$</span>
                    Kasir
                </a>
            </div>
        </div>
        
        <!-- System Info -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-lg shadow-sm text-white md:col-span-2">
            <h3 class="text-lg font-bold mb-2">Status Sistem</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400">Versi Aplikasi</p>
                    <p class="font-mono">v2.0 (Paripurna)</p>
                </div>
                <div>
                    <p class="text-gray-400">Database</p>
                    <p class="font-mono">MySQL / MariaDB</p>
                </div>
                <div>
                    <p class="text-gray-400">Framework</p>
                    <p class="font-mono">Laravel 12 + Livewire 4</p>
                </div>
                <div>
                    <p class="text-gray-400">Server Time</p>
                    <p class="font-mono">{{ now()->format('H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        // Kunjungan Chart
        new Chart(document.getElementById('kunjunganChart'), {
            type: 'line',
            data: @json($chartData),
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } },
                elements: { line: { tension: 0.4 } } // Smooth curve
            }
        });

        // Pendapatan Chart
        new Chart(document.getElementById('pendapatanChart'), {
            type: 'bar',
            data: {
                labels: @json($revenueData['labels']),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($revenueData['data']),
                    backgroundColor: 'rgba(16, 185, 129, 0.6)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
