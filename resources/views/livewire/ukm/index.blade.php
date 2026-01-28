<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Data Kegiatan UKM</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Monitoring pelaksanaan Upaya Kesehatan Masyarakat di lapangan.</p>
        </div>
        <a href="{{ route('ukm.create') }}" wire:navigate class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Catat Kegiatan Baru
        </a>
    </div>

    <!-- Search -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Cari kegiatan, jenis, atau lokasi...">
        </div>
    </div>

    <!-- Timeline/Table List -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kegiatan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jenis & Lokasi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Peserta</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($kegiatans as $k)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-800 dark:text-white">{{ $k->nama_kegiatan }}</div>
                                <div class="text-xs text-slate-500 mt-1 truncate max-w-xs">{{ $k->deskripsi }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 text-[10px] font-black rounded-lg uppercase tracking-widest">{{ $k->jenis_kegiatan }}</span>
                                <div class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">{{ $k->lokasi }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-slate-700 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($k->tanggal_kegiatan)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-black text-slate-800 dark:text-white">{{ $k->jumlah_peserta }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Orang</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold space-x-3">
                                @if($k->file_laporan)
                                    <a href="{{ Storage::url($k->file_laporan) }}" target="_blank" class="text-emerald-600 hover:text-emerald-900 uppercase">Laporan</a>
                                @endif
                                <button onclick="confirm('Hapus data kegiatan?') || event.stopImmediatePropagation()" wire:click="delete({{ $k->id }})" class="text-red-600 hover:text-red-900 uppercase">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 font-bold">Belum ada catatan kegiatan UKM.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $kegiatans->links() }}
        </div>
    </div>
</div>