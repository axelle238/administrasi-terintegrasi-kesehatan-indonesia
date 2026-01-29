<div class="space-y-6">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <button wire:click="setFilter('')" class="p-6 rounded-2xl border transition-all text-left {{ $filterStatus === '' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 border-indigo-600' : 'bg-white dark:bg-gray-800 text-gray-500 hover:border-indigo-300 border-gray-200 dark:border-gray-700' }}">
            <p class="text-xs font-bold uppercase tracking-widest opacity-80">Total Masuk</p>
            <h3 class="text-3xl font-black mt-1">{{ $totalPengaduan }}</h3>
        </button>
        
        <button wire:click="setFilter('Menunggu')" class="p-6 rounded-2xl border transition-all text-left {{ $filterStatus === 'Menunggu' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30 border-amber-500' : 'bg-white dark:bg-gray-800 text-gray-500 hover:border-amber-300 border-gray-200 dark:border-gray-700' }}">
            <p class="text-xs font-bold uppercase tracking-widest opacity-80">Perlu Respon</p>
            <h3 class="text-3xl font-black mt-1">{{ $pending }}</h3>
        </button>

        <button wire:click="setFilter('Diproses')" class="p-6 rounded-2xl border transition-all text-left {{ $filterStatus === 'Diproses' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30 border-blue-500' : 'bg-white dark:bg-gray-800 text-gray-500 hover:border-blue-300 border-gray-200 dark:border-gray-700' }}">
            <p class="text-xs font-bold uppercase tracking-widest opacity-80">Sedang Ditangani</p>
            <h3 class="text-3xl font-black mt-1">{{ $proses }}</h3>
        </button>

        <button wire:click="setFilter('Selesai')" class="p-6 rounded-2xl border transition-all text-left {{ $filterStatus === 'Selesai' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30 border-emerald-500' : 'bg-white dark:bg-gray-800 text-gray-500 hover:border-emerald-300 border-gray-200 dark:border-gray-700' }}">
            <p class="text-xs font-bold uppercase tracking-widest opacity-80">Selesai</p>
            <h3 class="text-3xl font-black mt-1">{{ $selesai }}</h3>
        </button>
    </div>

    <!-- Search & Content -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between gap-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" /></svg>
                Daftar Aspirasi
            </h3>
            <div class="relative w-full sm:w-72">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari pelapor, subjek..." 
                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Subjek & Pesan</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($pengaduans as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ $p->created_at->format('d/m/Y') }}
                                <span class="block text-xs opacity-70">{{ $p->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $p->nama_pelapor }}</div>
                                <div class="text-xs text-gray-500">{{ $p->no_telepon_pelapor }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $p->subjek }}</div>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2 max-w-xs">{{ $p->isi_pengaduan }}</p>
                                @if($p->file_lampiran)
                                    <span class="inline-flex items-center gap-1 mt-2 px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                        Ada Lampiran
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $statusClass = match($p->status) {
                                        'Menunggu' => 'bg-amber-100 text-amber-700',
                                        'Diproses' => 'bg-blue-100 text-blue-700',
                                        'Selesai' => 'bg-emerald-100 text-emerald-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider {{ $statusClass }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.masyarakat.pengaduan.show', $p->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold mr-3">Detail</a>
                                <button wire:click="delete({{ $p->id }})" wire:confirm="Hapus pengaduan ini?" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                Tidak ada pengaduan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $pengaduans->links() }}
        </div>
    </div>
</div>
