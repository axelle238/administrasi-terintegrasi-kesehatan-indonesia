<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Rincian Tagihan -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 bg-white">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Rincian Tagihan Pasien</h3>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                        <div>
                            <span class="text-gray-500 block">Nama Pasien</span>
                            <span class="font-semibold text-gray-900">{{ $pasien->nama_lengkap }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">No. Rekam Medis</span>
                            <span class="font-mono text-gray-900">{{ str_pad($pasien->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Penjamin</span>
                            @if($metode_pembayaran == 'BPJS')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">BPJS Kesehatan</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-bold">Umum / Mandiri</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-gray-500 block">Tanggal Periksa</span>
                            <span class="text-gray-900">{{ $rekamMedis->tanggal_periksa->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <!-- Tabel Tindakan -->
                    <h4 class="text-sm font-semibold text-gray-700 mb-2 mt-4">Jasa & Tindakan Medis</h4>
                    <table class="w-full text-sm mb-4">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="text-left py-2 px-2">Keterangan</th>
                                <th class="text-right py-2 px-2">Biaya</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($detailsTindakan as $item)
                                <tr>
                                    <td class="py-2 px-2">{{ $item['nama'] }}</td>
                                    <td class="py-2 px-2 text-right">Rp {{ number_format($item['biaya'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-semibold">
                                <td class="py-2 px-2 text-right">Subtotal Tindakan</td>
                                <td class="py-2 px-2 text-right">Rp {{ number_format($totalTindakan, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Tabel Obat -->
                    <h4 class="text-sm font-semibold text-gray-700 mb-2 mt-6">Farmasi & Obat</h4>
                    <table class="w-full text-sm mb-4">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="text-left py-2 px-2">Nama Obat</th>
                                <th class="text-center py-2 px-2">Qty</th>
                                <th class="text-right py-2 px-2">Harga</th>
                                <th class="text-right py-2 px-2">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($detailsObat as $item)
                                <tr>
                                    <td class="py-2 px-2">{{ $item['nama'] }}</td>
                                    <td class="py-2 px-2 text-center">{{ $item['jumlah'] }}</td>
                                    <td class="py-2 px-2 text-right">{{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td class="py-2 px-2 text-right">{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-semibold">
                                <td colspan="3" class="py-2 px-2 text-right">Subtotal Obat</td>
                                <td class="py-2 px-2 text-right">Rp {{ number_format($totalObat, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Pembayaran -->
        <div class="md:col-span-1">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-indigo-100 sticky top-6">
                <div class="p-6 bg-indigo-50 border-b border-indigo-100">
                    <h3 class="text-lg font-bold text-indigo-900">Total Tagihan</h3>
                    <div class="text-3xl font-black text-indigo-700 mt-2">
                        Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                    </div>
                    @if($metode_pembayaran == 'BPJS')
                        <p class="text-sm text-green-600 font-bold mt-1">Ditanggung BPJS (Gratis)</p>
                    @endif
                </div>

                <div class="p-6 space-y-4">
                    <!-- Rincian Akhir -->
                    <div class="text-sm space-y-2 pb-4 border-b border-gray-100">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Tindakan</span>
                            <span class="font-medium">Rp {{ number_format($totalTindakan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Obat</span>
                            <span class="font-medium">Rp {{ number_format($totalObat, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Admin</span>
                            <span class="font-medium">Rp {{ number_format($biayaAdministrasi, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($totalTagihan > 0)
                        <div>
                            <x-input-label value="Metode Pembayaran" />
                            <select wire:model.live="metode_pembayaran" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer Bank</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label value="Jumlah Bayar (Rp)" />
                            <x-text-input wire:model.live.debounce.500ms="jumlah_bayar" type="number" class="w-full mt-1 text-right font-bold text-lg" />
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-medium">Kembalian</span>
                                <span class="text-xl font-bold {{ $kembalian < 0 ? 'text-red-600' : 'text-green-600' }}">
                                    Rp {{ number_format($kembalian, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @endif

                    <button 
                        wire:click="processPayment" 
                        wire:confirm="Pastikan data pembayaran sudah benar. Lanjutkan?"
                        class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow transition transform hover:scale-105 flex justify-center items-center gap-2"
                        @if($totalTagihan > 0 && $jumlah_bayar < $totalTagihan) disabled @endif
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @if($totalTagihan > 0)
                            Bayar & Cetak
                        @else
                            Selesaikan (BPJS)
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
