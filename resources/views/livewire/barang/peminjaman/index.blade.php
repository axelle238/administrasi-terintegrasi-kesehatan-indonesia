<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Peminjaman Aset</h2>
            <p class="text-sm text-slate-500">Monitoring peminjaman barang oleh pegawai.</p>
        </div>
        <a href="{{ route('barang.peminjaman.create') }}" wire:navigate class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Catat Peminjaman
        </a>
    </div>

    <!-- Filters -->
    <div class="flex gap-4">
        <div class="relative flex-1">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari peminjam, barang, atau no transaksi..." class="w-full pl-10 pr-4 py-2 bg-white border-none rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <select wire:model.live="filterStatus" class="bg-white border-none rounded-xl shadow-sm px-4 py-2 focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Status</option>
            <option value="Dipinjam">Sedang Dipinjam</option>
            <option value="Dikembalikan">Sudah Kembali</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Transaksi</th>
                    <th class="px-6 py-4">Peminjam</th>
                    <th class="px-6 py-4">Barang</th>
                    <th class="px-6 py-4 text-center">Jadwal Kembali</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($peminjaman as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $p->no_transaksi }}</div>
                        <div class="text-xs text-slate-500">{{ $p->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-700">{{ $p->pegawai->user->name ?? '-' }}</div>
                        <div class="text-xs text-slate-500">{{ $p->pegawai->jabatan ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-700">{{ $p->barang->nama_barang ?? '-' }}</div>
                        <div class="text-xs text-slate-500 font-mono">{{ $p->barang->kode_barang ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($p->tanggal_kembali_rencana)
                            @php
                                $isOverdue = $p->status == 'Dipinjam' && \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->isPast();
                            @endphp
                            <span class="{{ $isOverdue ? 'text-red-600 font-bold' : 'text-slate-600' }}">
                                {{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d M Y') }}
                            </span>
                            @if($isOverdue) <span class="block text-[10px] text-red-500 font-bold">Terlambat</span> @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $p->status == 'Dipinjam' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($p->status == 'Dipinjam')
                            <a href="{{ route('barang.peminjaman.kembali', $p->id) }}" wire:navigate class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold hover:bg-slate-50 text-slate-600 shadow-sm">
                                Proses Kembali
                            </a>
                        @else
                            <span class="text-xs text-slate-400 font-bold">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">Tidak ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4">
        {{ $peminjaman->links() }}
    </div>
</div>