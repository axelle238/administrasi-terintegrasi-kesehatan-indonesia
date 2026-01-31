<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Pengadaan Barang</h2>
            <p class="text-sm text-slate-500">Kelola pengajuan pembelian, persetujuan, dan penerimaan barang masuk.</p>
        </div>
        <a href="{{ route('barang.pengadaan.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Buat Pengajuan
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nomor pengajuan..." class="w-full md:w-64 pl-4 pr-4 py-2 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-bold">No. Pengajuan</th>
                        <th class="px-6 py-4 font-bold">Tanggal</th>
                        <th class="px-6 py-4 font-bold">Pemohon</th>
                        <th class="px-6 py-4 font-bold">Supplier</th>
                        <th class="px-6 py-4 font-bold text-right">Total Estimasi</th>
                        <th class="px-6 py-4 font-bold text-center">Status</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengadaans as $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono font-bold text-slate-700">
                            {{ $p->nomor_pengajuan }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $p->pemohon->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $p->supplier->nama_supplier ?? 'Umum' }}
                        </td>
                        <td class="px-6 py-4 text-right font-mono">
                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'Pending' => 'bg-amber-100 text-amber-700',
                                    'Disetujui' => 'bg-blue-100 text-blue-700',
                                    'Ditolak' => 'bg-red-100 text-red-700',
                                    'Selesai' => 'bg-emerald-100 text-emerald-700',
                                ];
                                $statusLabel = [
                                    'Pending' => 'Menunggu Approval',
                                    'Disetujui' => 'Menunggu Barang',
                                    'Ditolak' => 'Ditolak',
                                    'Selesai' => 'Diterima (Stok Masuk)',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClasses[$p->status] ?? 'bg-slate-100' }}">
                                {{ $statusLabel[$p->status] ?? $p->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if($p->status == 'Pending')
                                    <button wire:click="approve({{ $p->id }})" class="p-2 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100" title="Setujui">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </button>
                                    <button wire:click="reject({{ $p->id }})" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100" title="Tolak">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                @elseif($p->status == 'Disetujui')
                                    <button wire:click="receive({{ $p->id }})" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-bold hover:bg-blue-700 shadow-sm flex items-center gap-1" title="Terima Barang">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Terima Barang
                                    </button>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">Belum ada data pengadaan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $pengadaans->links() }}
        </div>
    </div>
</div>