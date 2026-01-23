<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- Patient Info Header -->
            <div class="mb-8 bg-blue-50 p-4 rounded-lg border border-blue-100">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Informasi Resep</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 block">Nama Pasien:</span>
                        <span class="font-semibold text-gray-900">{{ $pasien->nama_lengkap }}</span>
                        <span class="text-xs text-gray-500">({{ $pasien->nik }})</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Dokter Penanggung Jawab:</span>
                        <span class="font-semibold text-gray-900">{{ $dokter->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Tanggal Periksa:</span>
                        <span class="font-semibold text-gray-900">{{ $rekamMedis->tanggal_periksa->format('d F Y') }}</span>
                    </div>
                </div>
            </div>

            <h4 class="text-md font-bold text-gray-700 mb-4 uppercase tracking-wider">Daftar Obat (Resep)</h4>
            
            <div class="overflow-x-auto border rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Obat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Resep</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aturan Pakai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok Tersedia</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status Stok</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($details as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">{{ $item['kode_obat'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item['nama_obat'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-700">
                                    {{ $item['jumlah_resep'] }} {{ $item['satuan'] }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 italic">
                                    {{ $item['aturan_pakai'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item['stok_current'] }} {{ $item['satuan'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($item['stok_current'] >= $item['jumlah_resep'])
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Cukup
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 animate-pulse">
                                            Kurang
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('apotek.print-etiket', $rekamMedis->id) }}" target="_blank" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Etiket
                </a>

                <a href="{{ route('apotek.index') }}" wire:navigate class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 bg-white shadow-sm">
                    Kembali
                </a>
                
                <button 
                    wire:click="process" 
                    wire:confirm="Konfirmasi penyerahan obat? Stok akan dikurangi secara otomatis."
                    class="px-6 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 shadow-lg flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Proses & Serahkan Obat
                </button>
            </div>
        </div>
    </div>
</div>
