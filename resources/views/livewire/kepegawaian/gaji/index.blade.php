<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Penggajian & Payroll</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan dan histori pembayaran gaji pegawai.</p>
        </div>
        <a href="{{ route('kepegawaian.gaji.create') }}" wire:navigate class="group relative inline-flex items-center justify-center px-6 py-2.5 overflow-hidden font-bold text-white transition-all duration-300 bg-blue-600 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20">
            <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
            <span class="relative flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Input Gaji Baru
            </span>
        </a>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="relative max-w-md w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Cari nama pegawai...">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50 font-bold">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Gaji Pokok</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Tunjangan</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Potongan</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Total Bersih</th>
                        <th class="px-6 py-4 text-right text-xs text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($gajis as $gaji)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 font-bold text-xs">
                                        {{ substr($gaji->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-800 dark:text-white">{{ $gaji->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300 font-medium">
                                {{ $gaji->bulan }} {{ $gaji->tahun }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 dark:text-slate-100">
                                Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-emerald-600 font-bold">
                                +{{ number_format($gaji->tunjangan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-bold">
                                -{{ number_format($gaji->potongan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-black text-blue-600">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold space-x-3">
                                <button class="text-blue-600 hover:text-blue-900">Slip</button>
                                <button onclick="confirm('Yakin hapus?') || event.stopImmediatePropagation()" wire:click="delete({{ $gaji->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 font-bold">Belum ada data histori penggajian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $gajis->links() }}
        </div>
    </div>
</div>