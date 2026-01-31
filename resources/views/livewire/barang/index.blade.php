<div class="space-y-6">
    <!-- Filters & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-black text-slate-800">Master Data Barang</h2>
            <p class="text-sm text-slate-500">Database seluruh aset tetap dan barang habis pakai (medis/umum).</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('barang.print-labels-bulk') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                Cetak Label
            </a>
            <a href="{{ route('barang.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 flex items-center gap-2 shadow-lg shadow-blue-500/30">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Barang
            </a>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white p-4 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col md:flex-row gap-4 items-center">
        <div class="relative w-full md:w-64">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, kode, merk..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
        
        <select wire:model.live="filterTipe" class="bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-600 py-2 pl-4 pr-8 cursor-pointer focus:ring-2 focus:ring-blue-500">
            <option value="all">Semua Tipe</option>
            <option value="medis">Aset Medis / Alkes</option>
            <option value="umum">Aset Umum / Non-Medis</option>
        </select>

        <select wire:model.live="filterKategori" class="bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-600 py-2 pl-4 pr-8 cursor-pointer focus:ring-2 focus:ring-blue-500 w-full md:w-auto">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-bold">Barang</th>
                        <th class="px-6 py-4 font-bold">Kategori</th>
                        <th class="px-6 py-4 font-bold">Stok</th>
                        <th class="px-6 py-4 font-bold">Lokasi</th>
                        <th class="px-6 py-4 font-bold text-center">Status</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($barangs as $barang)
                    <tr class="hover:bg-slate-50 transition-colors cursor-pointer" wire:click="showDetail({{ $barang->id }})">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 overflow-hidden">
                                    @if($barang->gambar)
                                        <img src="{{ Storage::url($barang->gambar) }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $barang->nama_barang }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $barang->kode_barang }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $isMedis = str_contains(strtolower($barang->kategori->nama_kategori ?? ''), 'medis') || str_contains(strtolower($barang->kategori->nama_kategori ?? ''), 'obat');
                            @endphp
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $isMedis ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $barang->stok }} <span class="text-xs font-normal text-slate-500">{{ $barang->satuan }}</span></div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $barang->ruangan->nama_ruangan ?? $barang->lokasi_penyimpanan }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($barang->kondisi == 'Baik')
                                <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Baik</span>
                            @elseif($barang->kondisi == 'Rusak Ringan')
                                <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Rusak Ringan</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">Rusak Berat</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('barang.edit', $barang->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-xs" onclick="event.stopPropagation()">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">Data barang tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $barangs->links() }}
        </div>
    </div>

    <!-- Modal Detail & Kartu Stok -->
    <div x-show="$wire.isDetailOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" style="display: none;">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-4xl overflow-hidden max-h-[90vh] flex flex-col">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                <div>
                    <h3 class="text-xl font-black text-slate-800">{{ $selectedBarang->nama_barang ?? 'Detail Barang' }}</h3>
                    <p class="text-xs text-slate-500 font-mono mt-1">{{ $selectedBarang->kode_barang ?? '-' }}</p>
                </div>
                <button wire:click="closeDetail" class="p-2 bg-white rounded-full hover:bg-slate-200 transition-colors shadow-sm">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div class="p-8 overflow-y-auto custom-scrollbar">
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Lokasi</p>
                        <p class="text-slate-800 font-bold">{{ $selectedBarang->ruangan->nama_ruangan ?? $selectedBarang->lokasi_penyimpanan ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Merk / Brand</p>
                        <p class="text-slate-800 font-bold">{{ $selectedBarang->merk ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Kondisi</p>
                        <p class="text-slate-800 font-bold">{{ $selectedBarang->kondisi ?? '-' }}</p>
                    </div>
                </div>

                <h4 class="font-bold text-lg text-slate-800 mb-4 border-b border-dashed border-slate-200 pb-2">Kartu Stok (Riwayat Transaksi)</h4>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-slate-500 bg-slate-50 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 rounded-l-xl">Tanggal</th>
                                <th class="px-4 py-3">Transaksi</th>
                                <th class="px-4 py-3 text-center">Jumlah</th>
                                <th class="px-4 py-3 text-right rounded-r-xl">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($riwayatTransaksi as $log)
                            <tr>
                                <td class="px-4 py-3 font-mono text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-bold text-slate-700">{{ $log->jenis_transaksi }}</span>
                                    <div class="text-xs text-slate-400">{{ $log->keterangan }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-bold {{ in_array($log->jenis_transaksi, ['Masuk', 'Pengadaan']) ? 'text-emerald-600' : 'text-red-600' }}">
                                        {{ in_array($log->jenis_transaksi, ['Masuk', 'Pengadaan']) ? '+' : '-' }}{{ $log->jumlah }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right font-bold text-slate-800">
                                    {{ $log->stok_terakhir }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-slate-400">Belum ada riwayat transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>