<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('apotek.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                {{ __('Validasi Resep') }}
            </h2>
        </div>
    </x-slot>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-center">
            <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-red-700 font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Info Pasien & Resep -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Card Pasien -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700">Data Pasien</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Lengkap</label>
                        <p class="text-lg font-bold text-gray-800">{{ $rekamMedis->pasien->nama_lengkap }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">NIK</label>
                            <p class="text-gray-700 font-mono text-sm">{{ $rekamMedis->pasien->nik }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tgl Lahir</label>
                            <p class="text-gray-700">{{ $rekamMedis->pasien->tanggal_lahir }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Diagnosa Dokter</label>
                        <div class="bg-blue-50 text-blue-800 px-3 py-2 rounded-lg text-sm font-medium mt-1">
                            {{ $rekamMedis->diagnosa }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Dokter -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="p-6 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-xl">
                        {{ substr($rekamMedis->dokter->name, 0, 1) }}
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Dokter Peresep</label>
                        <p class="font-bold text-gray-800">{{ $rekamMedis->dokter->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Item Obat -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden h-full flex flex-col">
                <div class="bg-white px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Rincian E-Resep
                    </h3>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded uppercase">No. RM: {{ $rekamMedis->id }}</span>
                </div>

                <div class="p-6 flex-1">
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full">
                            <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-left">Nama Obat</th>
                                    <th class="px-4 py-3 text-center">Permintaan</th>
                                    <th class="px-4 py-3 text-left">Aturan Pakai</th>
                                    <th class="px-4 py-3 text-center">Stok Gudang</th>
                                    <th class="px-4 py-3 text-center">Ketersediaan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($rekamMedis->obats as $obat)
                                @php
                                    $stokCukup = $obat->stok >= $obat->pivot->jumlah;
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-gray-800">{{ $obat->nama_obat }}</div>
                                        <div class="text-xs text-gray-500">{{ $obat->jenis_obat }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="font-bold text-lg">{{ $obat->pivot->jumlah }}</span> 
                                        <span class="text-xs text-gray-500">{{ $obat->satuan }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="bg-gray-100 px-2 py-1 rounded text-sm font-medium text-gray-700 inline-block">
                                            {{ $obat->pivot->aturan_pakai }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="font-mono {{ $obat->stok <= 10 ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                            {{ $obat->stok }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($stokCukup)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Ready
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 animate-pulse">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                                Stok Kurang
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-5 border-t border-gray-100">
                    <form action="{{ route('apotek.process', $rekamMedis->id) }}" method="POST" class="flex flex-col md:flex-row justify-between items-center gap-4">
                        @csrf
                        @method('PATCH')
                        
                        <div class="text-sm text-gray-500 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Klik "Validasi" untuk mengurangi stok gudang secara otomatis.
                        </div>

                        <div class="flex gap-3 w-full md:w-auto">
                            <a href="{{ route('apotek.index') }}" class="w-full md:w-auto px-6 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors text-center">
                                Kembali
                            </a>
                            <button type="button" onclick="window.print()" class="w-full md:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak Etiket
                            </button>
                            <button type="submit" class="w-full md:w-auto px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1" onclick="return confirm('Yakin validasi resep ini? Stok akan berkurang permanen.')">
                                ✔ Validasi & Selesai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>