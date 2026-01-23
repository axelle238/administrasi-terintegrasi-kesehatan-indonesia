<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    
    <!-- Filter Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 no-print">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jenis Laporan</label>
                <select wire:model.live="jenis_laporan" class="w-full rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 text-sm">
                    <option value="stok">Laporan Posisi Stok</option>
                    <option value="mutasi">Laporan Mutasi (Keluar/Masuk)</option>
                    <option value="aset">Laporan Daftar Aset Tetap</option>
                </select>
            </div>

            @if($jenis_laporan == 'mutasi')
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Dari Tanggal</label>
                    <input type="date" wire:model.live="tanggal_mulai" class="w-full rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Sampai Tanggal</label>
                    <input type="date" wire:model.live="tanggal_selesai" class="w-full rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 text-sm">
                </div>
            @else
                <div class="md:col-span-2"></div>
            @endif

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter Kategori</label>
                <select wire:model.live="kategori_filter" class="w-full rounded-xl border-gray-300 focus:border-teal-500 focus:ring-teal-500 text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="mt-4 flex justify-end">
            <button onclick="window.print()" class="bg-gray-900 text-white px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-2 hover:bg-gray-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Report Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden print:shadow-none print:border-0">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50 print:bg-white print:border-b-2 print:border-black">
            <div class="text-center">
                <h2 class="text-xl font-bold text-gray-900 uppercase">Laporan Inventaris Barang</h2>
                <p class="text-sm text-gray-600">
                    @if($jenis_laporan == 'stok') Posisi Stok Per {{ date('d F Y') }}
                    @elseif($jenis_laporan == 'mutasi') Mutasi Stok {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggal_selesai)->format('d/m/Y') }}
                    @elseif($jenis_laporan == 'aset') Daftar Aset Tetap Per {{ date('d F Y') }}
                    @endif
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 print:divide-gray-300">
                <thead class="bg-gray-50 print:bg-gray-100">
                    @if($jenis_laporan == 'stok')
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Lokasi</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Stok</th>
                        </tr>
                    @elseif($jenis_laporan == 'mutasi')
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Barang</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Jenis</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Ket</th>
                        </tr>
                    @elseif($jenis_laporan == 'aset')
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Kode Aset</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Nama Aset</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Tgl Perolehan</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Harga Perolehan</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider print:text-black">Nilai Buku</th>
                        </tr>
                    @endif
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white print:divide-gray-300">
                    @forelse($data as $item)
                        @if($jenis_laporan == 'stok')
                            <tr>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $item->kode_barang }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nama_barang }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->lokasi_penyimpanan }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-bold text-center {{ $item->stok <= 5 ? 'text-red-600' : 'text-gray-900' }}">{{ $item->stok }} {{ $item->satuan }}</td>
                            </tr>
                        @elseif($jenis_laporan == 'mutasi')
                            <tr>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->barang->nama_barang }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    <span class="px-2 py-0.5 rounded text-xs font-bold {{ $item->jenis_transaksi == 'Masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $item->jenis_transaksi }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-center font-bold">{{ $item->jumlah }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500 truncate max-w-xs">{{ $item->keterangan }}</td>
                            </tr>
                        @elseif($jenis_laporan == 'aset')
                            <tr>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $item->kode_barang }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nama_barang }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->tanggal_pengadaan ? \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d/m/Y') : '-' }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-right">Rp {{ number_format($item->harga_perolehan, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-right font-bold">Rp {{ number_format($item->nilai_buku, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada data untuk laporan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 no-print">
            {{ $data->links() }}
        </div>
    </div>
</div>
