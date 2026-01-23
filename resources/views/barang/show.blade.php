<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Barang & Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Detail Barang -->
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Barang</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Kode Barang</p>
                                    <p class="font-bold text-lg font-mono">{{ $barang->kode_barang }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Kategori</p>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-bold">{{ $barang->kategori->nama_kategori }}</span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nama Barang</p>
                                    <p class="font-medium">{{ $barang->nama_barang }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Merk / Brand</p>
                                    <p class="font-medium">{{ $barang->merk ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Kondisi</p>
                                    <p class="font-medium">{{ $barang->kondisi }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Lokasi Penyimpanan</p>
                                    <p class="font-medium">{{ $barang->lokasi_penyimpanan ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Stok Saat Ini</p>
                                    <p class="font-bold text-2xl {{ $barang->stok == 0 ? 'text-red-600' : 'text-green-600' }}">{{ $barang->stok }} {{ $barang->satuan }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Pengadaan</p>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- History Transaksi -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Riwayat Transaksi</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-4 py-2">Tanggal</th>
                                            <th class="px-4 py-2">Jenis</th>
                                            <th class="px-4 py-2 text-right">Jumlah</th>
                                            <th class="px-4 py-2 text-right">Sisa Stok</th>
                                            <th class="px-4 py-2">Oleh</th>
                                            <th class="px-4 py-2">Ket</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @forelse($riwayats as $riwayat)
                                        <tr>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-0.5 rounded text-xs font-bold {{ $riwayat->jenis_transaksi == 'Masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $riwayat->jenis_transaksi }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-right font-bold">{{ $riwayat->jumlah }}</td>
                                            <td class="px-4 py-2 text-right text-gray-500">{{ $riwayat->stok_terakhir }}</td>
                                            <td class="px-4 py-2 text-xs">{{ $riwayat->user->name }}</td>
                                            <td class="px-4 py-2 text-xs text-gray-500">{{ $riwayat->keterangan }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-4 text-center text-gray-500 italic">Belum ada riwayat transaksi.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $riwayats->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Transaksi -->
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-bold mb-4 text-center">Catat Transaksi</h3>
                            <form action="{{ route('barang.transaksi', $barang->id) }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <x-input-label for="jenis_transaksi" :value="__('Jenis Transaksi')" />
                                    <select name="jenis_transaksi" id="jenis_transaksi" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm" required>
                                        <option value="Masuk">Barang Masuk (Restock)</option>
                                        <option value="Keluar">Barang Keluar (Dipakai)</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="tanggal" :value="__('Tanggal')" />
                                    <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="date('Y-m-d')" required />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="jumlah" :value="__('Jumlah')" />
                                    <x-text-input id="jumlah" class="block mt-1 w-full" type="number" name="jumlah" min="1" placeholder="0" required />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" />
                                    <textarea name="keterangan" id="keterangan" rows="2" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm" placeholder="Contoh: Pembelian baru / Permintaan Poli Gigi"></textarea>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                    Simpan Transaksi
                                </button>

                                <div class="mt-4 pt-4 border-t text-center">
                                    <a href="{{ route('barang.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">Kembali ke Daftar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
