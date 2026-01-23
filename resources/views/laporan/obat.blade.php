<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Stok Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-4 no-print">
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-gray-800 text-white rounded-md font-bold hover:bg-gray-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <h3 class="text-center font-bold text-lg mb-6 hidden print:block">
                        LAPORAN STOK OPNAME OBAT<br>
                        <span class="text-sm font-normal">Per Tanggal: {{ date('d F Y') }}</span>
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 border">Kode Obat</th>
                                    <th class="px-4 py-2 border">Nama Obat</th>
                                    <th class="px-4 py-2 border">Jenis</th>
                                    <th class="px-4 py-2 border text-center">Stok Fisik</th>
                                    <th class="px-4 py-2 border">Satuan</th>
                                    <th class="px-4 py-2 border">Exp. Date</th>
                                    <th class="px-4 py-2 border text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($obats as $obat)
                                <tr>
                                    <td class="px-4 py-2 border font-mono">{{ $obat->kode_obat }}</td>
                                    <td class="px-4 py-2 border font-bold">{{ $obat->nama_obat }}</td>
                                    <td class="px-4 py-2 border">{{ $obat->jenis_obat }}</td>
                                    <td class="px-4 py-2 border text-center font-bold {{ $obat->stok <= $obat->min_stok ? 'text-red-600' : '' }}">
                                        {{ $obat->stok }}
                                    </td>
                                    <td class="px-4 py-2 border">{{ $obat->satuan }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->format('d/m/Y') }}
                                        @if(\Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->isPast())
                                            <span class="text-red-600 font-bold text-xs block">(Expired)</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        @if($obat->stok <= 0)
                                            <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded font-bold">Habis</span>
                                        @elseif($obat->stok <= $obat->min_stok)
                                            <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded font-bold">Kritis</span>
                                        @else
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded font-bold">Aman</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 text-sm text-gray-600 hidden print:block">
                        <div class="flex justify-between mt-12">
                            <div class="text-center w-1/3">
                                <p>Mengetahui,</p>
                                <p>Kepala Puskesmas</p>
                                <br><br><br>
                                <p>( ........................ )</p>
                            </div>
                            <div class="text-center w-1/3">
                                <p>Jakarta, {{ date('d F Y') }}</p>
                                <p>Petugas Farmasi</p>
                                <br><br><br>
                                <p>( ........................ )</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>