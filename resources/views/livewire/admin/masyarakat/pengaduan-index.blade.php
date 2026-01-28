<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Pengaduan Masyarakat</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Monitoring dan tindak lanjut keluhan serta aspirasi publik.</p>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Cari pelapor atau subjek...">
        </div>
        <div class="w-full md:w-48">
            <select wire:model.live="filterStatus" class="block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">Semua Status</option>
                <option value="Pending">Pending</option>
                <option value="Diproses">Diproses</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50 font-bold">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Pelapor</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Subjek</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-right text-xs text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($pengaduans as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-800 dark:text-white">{{ $p->nama_pelapor }}</div>
                                <div class="text-xs text-slate-500">{{ $p->no_telepon_pelapor }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200 truncate max-w-xs">{{ $p->subjek }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-widest
                                    @if($p->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($p->status == 'Diproses') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                {{ $p->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold space-x-3">
                                <a href="{{ route('admin.masyarakat.pengaduan.show', $p) }}" wire:navigate class="text-blue-600 hover:text-blue-900 uppercase">Detail & Proses</a>
                                <button onclick="confirm('Yakin hapus?') || event.stopImmediatePropagation()" wire:click="delete({{ $p->id }})" class="text-red-600 hover:text-red-900 uppercase">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 font-bold">Belum ada pengaduan masyarakat yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $pengaduans->links() }}
        </div>
    </div>
</div>