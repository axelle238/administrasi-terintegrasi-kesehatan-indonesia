<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Sirkulasi Peminjaman</h2>
            <p class="text-sm text-slate-500">Monitoring peminjaman inventaris kantor dan alat medis.</p>
        </div>
        <a href="{{ route('barang.peminjaman.create') }}" wire:navigate class="px-6 py-2 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 flex items-center gap-2 shadow-lg shadow-blue-500/30 transition-all relative z-10">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Catat Peminjaman
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between gap-4 items-center">
            <div class="relative w-full md:w-64">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari No Transaksi..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            
            <div class="flex gap-2">
                <select wire:model.live="filterStatus" class="bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-600 py-2 pl-4 pr-8 cursor-pointer focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Dipinjam">Sedang Dipinjam</option>
                    <option value="Dikembalikan">Sudah Kembali</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-bold">No Transaksi</th>
                        <th class="px-6 py-4 font-bold">Peminjam</th>
                        <th class="px-6 py-4 font-bold">Barang</th>
                        <th class="px-6 py-4 font-bold">Tgl Pinjam</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($peminjaman as $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-slate-600 font-bold">{{ $p->no_transaksi }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $p->pegawai->user->name ?? '-' }}</div>
                            <div class="text-xs text-slate-400">{{ $p->pegawai->nip ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $p->barang->nama_barang ?? '-' }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y') }}
                            @if($p->tanggal_kembali_rencana)
                                <br><span class="text-[10px] text-slate-400">Exp: {{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d/m/Y') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($p->status == 'Dipinjam')
                                <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs font-bold">Dipinjam</span>
                            @else
                                <span class="px-2 py-1 rounded bg-emerald-100 text-emerald-700 text-xs font-bold">Dikembalikan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if($p->status == 'Dipinjam')
                                    <a href="{{ route('barang.peminjaman.kembali', $p->id) }}" wire:navigate class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg hover:bg-amber-100 transition-colors">
                                        Kembalikan
                                    </a>
                                    <a href="{{ route('barang.peminjaman.print', $p->id) }}" target="_blank" class="text-slate-400 hover:text-blue-600 p-1 rounded-full hover:bg-slate-100 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                                    </a>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $peminjaman->links() }}
        </div>
    </div>
</div>
