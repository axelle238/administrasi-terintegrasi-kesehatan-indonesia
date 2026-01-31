<div class="space-y-6">
    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Mutasi & Perpindahan Aset</h2>
            <p class="text-sm text-slate-500">Kelola riwayat perpindahan barang antar ruangan atau unit kerja secara real-time.</p>
        </div>
        <a href="{{ route('barang.mutasi.create') }}" wire:navigate class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 flex items-center gap-2 shadow-lg shadow-blue-500/30 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Catat Mutasi Baru
        </a>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between gap-4 items-center">
            <div class="relative w-full md:w-64">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari barang atau PJ..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            
            <div class="flex gap-2">
                <select wire:model.live="perPage" class="bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-600 py-2 pl-4 pr-8 cursor-pointer focus:ring-2 focus:ring-blue-500">
                    <option value="10">10 Data</option>
                    <option value="25">25 Data</option>
                    <option value="50">50 Data</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-bold rounded-tl-[2rem]">Tanggal</th>
                        <th class="px-6 py-4 font-bold">Barang</th>
                        <th class="px-6 py-4 font-bold text-center">Asal &rarr; Tujuan</th>
                        <th class="px-6 py-4 font-bold text-center">Jumlah</th>
                        <th class="px-6 py-4 font-bold">PJ</th>
                        <th class="px-6 py-4 font-bold rounded-tr-[2rem] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mutasi as $m)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-slate-600 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($m->tanggal_mutasi)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $m->barang->nama_barang ?? 'Barang Terhapus' }}</div>
                            <div class="text-xs text-slate-400 font-mono">{{ $m->barang->kode_barang ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-3">
                                <span class="px-2 py-1 bg-red-50 text-red-600 rounded text-xs font-bold">{{ $m->ruanganAsal->nama_ruangan ?? $m->lokasi_asal }}</span>
                                <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded text-xs font-bold">{{ $m->ruanganTujuan->nama_ruangan ?? $m->lokasi_tujuan }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-black text-slate-800 text-lg">{{ $m->jumlah }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $m->penanggung_jawab }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('barang.mutasi.print', $m->id) }}" target="_blank" class="text-slate-400 hover:text-blue-600 transition-colors inline-block" title="Cetak Surat Jalan">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            Tidak ada data mutasi yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $mutasi->links() }}
        </div>
    </div>
</div>
