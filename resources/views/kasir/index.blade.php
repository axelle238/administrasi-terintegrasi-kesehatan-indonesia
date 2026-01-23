<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kasir & Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Search/Filter could go here -->
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700 uppercase font-bold text-gray-500 dark:text-gray-300">
                                <tr>
                                    <th class="px-6 py-3">No. RM / Tagihan</th>
                                    <th class="px-6 py-3">Tanggal Periksa</th>
                                    <th class="px-6 py-3">Pasien</th>
                                    <th class="px-6 py-3">Total Tagihan</th>
                                    <th class="px-6 py-3 text-center">Status</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($tagihans as $tagihan)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 font-mono font-bold">
                                        #{{ $tagihan->id }} <br>
                                        <span class="text-xs text-gray-500">RM-{{ $tagihan->rekam_medis_id }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($tagihan->rekamMedis->tanggal_periksa)->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold">{{ $tagihan->rekamMedis->pasien->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500">{{ $tagihan->rekamMedis->pasien->nik }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-200">
                                        Rp {{ number_format($tagihan->total_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($tagihan->status_pembayaran == 'Lunas')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Lunas</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 animate-pulse">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('kasir.show', $tagihan->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            Proses
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 italic">Tidak ada data tagihan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $tagihans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>