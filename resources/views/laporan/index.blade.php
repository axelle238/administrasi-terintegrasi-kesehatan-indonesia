<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pusat Laporan & Statistik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Laporan Kunjungan -->
                <a href="{{ route('laporan.kunjungan') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                    <div class="flex items-center mb-2">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4 group-hover:bg-blue-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Laporan Kunjungan Pasien</h5>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">
                        Lihat statistik kunjungan pasien per periode, diagnosa terbanyak, dan demografi pasien.
                    </p>
                </a>

                <!-- Laporan Obat -->
                <a href="{{ route('laporan.obat') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                    <div class="flex items-center mb-2">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4 group-hover:bg-green-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Laporan Farmasi & Stok Obat</h5>
                    </div>
                    <p class="font-normal text-gray-700 dark:text-gray-400">
                        Monitoring stok obat, obat kedaluwarsa, dan riwayat penggunaan obat (fast moving/slow moving).
                    </p>
                </a>
                
                <!-- Placeholder Keuangan (Optional for Future) -->
                 <div class="block p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 opacity-75">
                    <div class="flex items-center mb-2">
                         <div class="p-3 rounded-full bg-gray-200 text-gray-500 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-500">Laporan Keuangan (Segera Hadir)</h5>
                    </div>
                     <p class="font-normal text-gray-500">
                        Rekapitulasi pendapatan klinik dari kasir (Tunai, QRIS, BPJS).
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>