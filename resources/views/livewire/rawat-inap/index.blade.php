<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Rawat Inap</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Monitoring pasien dan okupansi kamar.</p>
        </div>
        <a href="{{ route('rawat-inap.create') }}" wire:navigate class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-500/20 transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Registrasi Pasien Masuk
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
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Cari pasien...">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50 font-bold">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Kamar</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Waktu Masuk</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($admissions as $a)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-800 dark:text-white">{{ $a->pasien->nama_lengkap }}</div>
                                <div class="text-xs text-slate-500">{{ $a->jenis_pembayaran }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $a->kamar->nama_kamar }}</div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kelas {{ $a->kamar->kelas }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($a->waktu_masuk)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-widest
                                    @if($a->status == 'Aktif') bg-blue-100 text-blue-800 animate-pulse
                                    @elseif($a->status == 'Pulang') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $a->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold space-x-3">
                                @if($a->status == 'Aktif')
                                    <a href="{{ route('rawat-inap.checkout', $a->id) }}" wire:navigate class="text-red-600 hover:text-red-900 uppercase">Checkout / Pulang</a>
                                @else
                                    <span class="text-gray-400 uppercase">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 font-bold">Belum ada pasien rawat inap.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $admissions->links() }}
        </div>
    </div>
</div>
