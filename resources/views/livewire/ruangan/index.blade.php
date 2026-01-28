<div class="space-y-6">
    
    <!-- Header & Action -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Manajemen Ruangan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pengelolaan lokasi, gedung, dan unit ruangan pelayanan kesehatan.</p>
        </div>
        <a href="{{ route('ruangan.create') }}" wire:navigate class="group relative inline-flex items-center justify-center px-6 py-2.5 overflow-hidden font-bold text-white transition-all duration-300 bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 dark:focus:ring-offset-gray-900 shadow-lg shadow-indigo-500/20">
            <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
            <span class="relative flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Ruangan Baru
            </span>
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
        <div class="relative max-w-md w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-shadow" placeholder="Cari nama ruangan, kode, atau PIC...">
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kode</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Ruangan</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi / Gedung</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Penanggung Jawab</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($ruangans as $ruangan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $ruangan->kode_ruangan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <div class="font-bold">{{ $ruangan->nama_ruangan }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($ruangan->keterangan, 40) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 font-medium">
                                {{ $ruangan->lokasi_gedung ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-2">
                                     <div class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-xs font-bold text-indigo-600 dark:text-indigo-300">
                                        {{ substr($ruangan->penanggung_jawab ?? '?', 0, 1) }}
                                    </div>
                                    <span class="font-medium">{{ $ruangan->penanggung_jawab ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('ruangan.edit', $ruangan) }}" wire:navigate class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200 mr-3 transition-colors font-bold">Edit</a>
                                <button onclick="confirm('Yakin hapus data ruangan ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $ruangan->id }})" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200 transition-colors font-bold">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    <span class="font-medium font-bold text-gray-400">Belum ada data ruangan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $ruangans->links() }}
        </div>
    </div>
</div>
