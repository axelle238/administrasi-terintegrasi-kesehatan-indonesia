<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pembayaran') }} #{{ $pembayaran->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">
                
                <!-- Kiri: Invoice Detail -->
                <div class="w-full md:w-2/3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="border-b pb-4 mb-4 flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold">Rincian Biaya Pengobatan</h3>
                                <p class="text-sm text-gray-500">No. Rekam Medis: {{ $pembayaran->rekam_medis_id }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Tanggal</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($pembayaran->created_at)->format('d F Y') }}</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="font-semibold text-sm text-gray-500 uppercase mb-2">Pasien</h4>
                            <p class="text-lg font-bold">{{ $pembayaran->rekamMedis->pasien->nama_lengkap }}</p>
                            <p class="text-sm text-gray-600">{{ $pembayaran->rekamMedis->pasien->alamat }}</p>
                        </div>

                        <div class="mb-6">
                            <h4 class="font-semibold text-sm text-gray-500 uppercase mb-2">Item Tagihan</h4>
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Deskripsi</th>
                                        <th class="px-4 py-2 text-right">Biaya</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    <!-- Tindakan -->
                                    @foreach($pembayaran->rekamMedis->tindakans as $tindakan)
                                    <tr>
                                        <td class="px-4 py-2">
                                            <span class="font-medium">{{ $tindakan->nama_tindakan }}</span> <br>
                                            <span class="text-xs text-gray-500">Jasa Medis/Tindakan</span>
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            Rp {{ number_format($tindakan->pivot->biaya, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach

                                    <!-- Obat -->
                                    @foreach($pembayaran->rekamMedis->obats as $obat)
                                    <tr>
                                        <td class="px-4 py-2">
                                            <span class="font-medium">{{ $obat->nama_obat }}</span> <br>
                                            <span class="text-xs text-gray-500">{{ $obat->pivot->jumlah }} {{ $obat->satuan }} x Rp {{ number_format($obat->harga_satuan, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            Rp {{ number_format($obat->harga_satuan * $obat->pivot->jumlah, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-t-2 border-gray-200">
                                    <tr>
                                        <td class="px-4 py-3 font-bold text-right">Total Tagihan</td>
                                        <td class="px-4 py-3 font-bold text-right text-lg text-blue-600">
                                            Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Action Payment -->
                <div class="w-full md:w-1/3">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-200">Proses Pembayaran</h3>
                        
                        @if($pembayaran->status_pembayaran == 'Belum Lunas')
                        <form action="{{ route('kasir.update', $pembayaran->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <x-input-label for="metode_pembayaran" :value="__('Metode Pembayaran')" />
                                <select id="metode_pembayaran" name="metode_pembayaran" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="Tunai">Tunai (Cash)</option>
                                    <option value="Debit">Kartu Debit</option>
                                    <option value="QRIS">QRIS</option>
                                    <option value="BPJS">BPJS Kesehatan (Klaim)</option>
                                </select>
                            </div>

                            <div class="mb-4" x-data="{ bayar: 0, total: {{ $pembayaran->total_bayar }} }">
                                <x-input-label for="bayar" :value="__('Uang Diterima (Khusus Tunai)')" />
                                <input type="number" id="bayar" name="bayar" x-model="bayar" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="0">
                                
                                <div class="mt-2 text-sm" x-show="bayar > 0">
                                    Kembalian: <span class="font-bold" :class="bayar >= total ? 'text-green-600' : 'text-red-600'" x-text="'Rp ' + (bayar - total).toLocaleString('id-ID')"></span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow transition-colors">
                                Bayar & Lunas
                            </button>
                        </form>
                        @else
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-center">
                                <span class="font-bold block text-lg">LUNAS</span>
                                <span class="text-sm">Dibayar via {{ $pembayaran->metode_pembayaran }}</span>
                                <span class="block text-xs mt-1">{{ \Carbon\Carbon::parse($pembayaran->updated_at)->format('d M Y H:i') }}</span>
                            </div>

                            <a href="{{ route('kasir.print', $pembayaran->id) }}" target="_blank" class="block w-full text-center bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-lg shadow transition-colors">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak Kwitansi
                            </a>
                        @endif

                        <a href="{{ route('kasir.index') }}" class="block w-full text-center mt-4 text-gray-500 hover:text-gray-700">Kembali ke Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>