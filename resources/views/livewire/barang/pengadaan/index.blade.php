<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Daftar Pengadaan Barang</h2>
            <p class="text-sm text-slate-500">Kelola permintaan pembelian dan penerimaan aset baru.</p>
        </div>
        <a href="{{ route('barang.pengadaan.create') }}" wire:navigate class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pengajuan
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
        <div class="relative max-w-md">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nomor pengajuan..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Nomor & Tanggal</th>
                    <th class="px-6 py-4">Pemohon</th>
                    <th class="px-6 py-4">Supplier</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pengadaans as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $p->nomor_pengajuan }}</div>
                        <div class="text-xs text-slate-500">{{ $p->tanggal_pengajuan->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-700">{{ $p->pemohon->name ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-slate-600">{{ $p->supplier->nama_supplier ?? 'Umum' }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $statusClass = match($p->status) {
                                'Pending' => 'bg-yellow-100 text-yellow-700',
                                'Disetujui' => 'bg-blue-100 text-blue-700',
                                'Ditolak' => 'bg-red-100 text-red-700',
                                'Selesai' => 'bg-emerald-100 text-emerald-700',
                                default => 'bg-slate-100 text-slate-700'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        @if($p->status == 'Pending')
                            <button wire:click="approve({{ $p->id }})" wire:confirm="Setujui pengajuan ini?" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100" title="Setujui">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </button>
                            <button wire:click="reject({{ $p->id }})" wire:confirm="Tolak pengajuan ini?" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100" title="Tolak">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        @endif

                        @if($p->status == 'Disetujui')
                            <button wire:click="receive({{ $p->id }})" wire:confirm="Barang sudah diterima? Stok akan otomatis bertambah." class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Terima Barang
                            </button>
                        @endif
                        
                        @if($p->status == 'Selesai')
                            <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Completed
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada data pengajuan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4">
        {{ $pengadaans->links() }}
    </div>
</div>
