<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Kunjungan Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form action="{{ route('laporan.kunjungan') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                    <div class="w-full md:w-auto">
                        <x-input-label for="start_date" :value="__('Dari Tanggal')" />
                        <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="request('start_date', $startDate->format('Y-m-d'))" />
                    </div>
                    <div class="w-full md:w-auto">
                        <x-input-label for="end_date" :value="__('Sampai Tanggal')" />
                        <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="request('end_date', $endDate->format('Y-m-d'))" />
                    </div>
                    <div class="flex gap-2 w-full md:w-auto">
                        <x-primary-button class="justify-center w-full md:w-auto">
                            {{ __('Filter') }}
                        </x-primary-button>
                        <button type="button" onclick="window.print()" class="px-4 py-2 bg-gray-500 text-white rounded-md font-semibold text-xs uppercase hover:bg-gray-600 w-full md:w-auto">
                            Cetak
                        </button>
                    </div>
                </form>
            </div>

            <!-- Result -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-center font-bold text-lg mb-4 hidden print:block">
                        LAPORAN KUNJUNGAN PASIEN<br>
                        <span class="text-sm font-normal">Periode: {{ $startDate->translatedFormat('d F Y') }} - {{ $endDate->translatedFormat('d F Y') }}</span>
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 border">Tanggal</th>
                                    <th class="px-4 py-2 border">No. RM</th>
                                    <th class="px-4 py-2 border">Nama Pasien</th>
                                    <th class="px-4 py-2 border">JK</th>
                                    <th class="px-4 py-2 border">Umur</th>
                                    <th class="px-4 py-2 border">Diagnosa (ICD-10)</th>
                                    <th class="px-4 py-2 border">Dokter</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kunjungans as $kunjungan)
                                <tr>
                                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($kunjungan->tanggal_periksa)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 border font-mono">{{ $kunjungan->id }}</td>
                                    <td class="px-4 py-2 border">{{ $kunjungan->pasien->nama_lengkap }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $kunjungan->pasien->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                                    <td class="px-4 py-2 border text-center">
                                        {{ \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->age }} Thn
                                    </td>
                                    <td class="px-4 py-2 border">{{ $kunjungan->diagnosa }}</td>
                                    <td class="px-4 py-2 border">{{ $kunjungan->dokter->name }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 italic">Tidak ada data kunjungan pada periode ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 text-sm text-gray-600 print:mt-8">
                        Total Kunjungan: <span class="font-bold">{{ $kunjungans->count() }} Pasien</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>