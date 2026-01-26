<div class="space-y-6">
    
    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        
        <!-- Tabs -->
        <div class="flex bg-white rounded-xl p-1 shadow-sm border border-slate-200">
            <button 
                wire:click="setTab('belum_bayar')" 
                class="px-4 py-2 text-sm font-bold rounded-lg transition-all {{ $tab === 'belum_bayar' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-800' }}"
            >
                Menunggu Pembayaran
            </button>
            <button 
                wire:click="setTab('lunas')" 
                class="px-4 py-2 text-sm font-bold rounded-lg transition-all {{ $tab === 'lunas' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-800' }}"
            >
                Riwayat Transaksi
            </button>
        </div>

        <div class="w-full md:w-1/3 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" class="pl-10 block w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm" placeholder="Cari Pasien / NIK...">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Info Pasien</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Penjamin</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status Medis</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($tagihan as $item)
                        <tr class="hover:bg-slate-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                <span class="font-bold">{{ \Carbon\Carbon::parse($item->tanggal_periksa)->format('d/m/Y') }}</span>
                                <span class="text-slate-400 block text-xs mt-0.5">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-800">{{ $item->pasien->nama_lengkap }}</div>
                                <div class="text-xs text-slate-500 font-mono">{{ $item->pasien->nik }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->pasien->no_bpjs)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        BPJS
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                        Umum
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    @if($item->diagnosa)
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full" title="Sudah Diperiksa"></span>
                                        <span class="text-xs text-slate-600">Medis Selesai</span>
                                    @else
                                        <span class="w-2 h-2 bg-amber-500 rounded-full" title="Belum Diperiksa"></span>
                                        <span class="text-xs text-slate-600">Menunggu Dokter</span>
                                    @endif
                                    
                                    @if($item->status_resep == 'Selesai')
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700">Obat OK</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($tab == 'belum_bayar')
                                    <a href="{{ route('kasir.process', $item->id) }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl font-bold text-xs uppercase tracking-wide hover:bg-blue-700 shadow-lg shadow-blue-600/20 transition-all transform hover:-translate-y-0.5">
                                        <span>Proses Bayar</span>
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </a>
                                @else
                                    <div class="flex items-center justify-end gap-2">
                                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">LUNAS</span>
                                        @if($item->pembayaran)
                                            <a href="{{ route('kasir.print', $item->pembayaran->id) }}" target="_blank" class="text-slate-400 hover:text-blue-600 p-2 hover:bg-slate-100 rounded-lg transition" title="Cetak Ulang">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <svg class="w-12 h-12 mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <span class="text-sm font-medium">Tidak ada data transaksi ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
            {{ $tagihan->links() }}
        </div>
    </div>
</div>