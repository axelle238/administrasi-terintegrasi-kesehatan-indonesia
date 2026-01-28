<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Manajemen Pegawai & SDM</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pengelolaan data dokter, perawat, dan staf medis lainnya.</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="syncBpjs" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-green-700 shadow-lg shadow-green-500/20 transition-all">
                <svg wire:loading.remove class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                <svg wire:loading class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Sync BPJS
            </button>
            <a href="{{ route('pegawai.create') }}" wire:navigate class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Pegawai
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700">
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest block mb-1">Total</span>
            <span class="text-2xl font-black text-slate-800 dark:text-white">{{ $totalPegawai }}</span>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700">
            <span class="text-xs font-black text-blue-400 uppercase tracking-widest block mb-1">Dokter</span>
            <span class="text-2xl font-black text-blue-600">{{ $totalDokter }}</span>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700">
            <span class="text-xs font-black text-emerald-400 uppercase tracking-widest block mb-1">Perawat</span>
            <span class="text-2xl font-black text-emerald-600">{{ $totalPerawat }}</span>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700">
            <span class="text-xs font-black text-purple-400 uppercase tracking-widest block mb-1">Apoteker</span>
            <span class="text-2xl font-black text-purple-600">{{ $totalApoteker }}</span>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 cursor-pointer hover:bg-orange-50 transition-colors {{ $filterStatus == 'ews_str' ? 'ring-2 ring-orange-500' : '' }}" wire:click="$set('filterStatus', '{{ $filterStatus == 'ews_str' ? '' : 'ews_str' }}')">
            <span class="text-xs font-black text-orange-400 uppercase tracking-widest block mb-1">EWS STR</span>
            <span class="text-2xl font-black text-orange-600">{{ $ewsStr }}</span>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 cursor-pointer hover:bg-red-50 transition-colors {{ $filterStatus == 'ews_sip' ? 'ring-2 ring-red-500' : '' }}" wire:click="$set('filterStatus', '{{ $filterStatus == 'ews_sip' ? '' : 'ews_sip' }}')">
            <span class="text-xs font-black text-red-400 uppercase tracking-widest block mb-1">EWS SIP</span>
            <span class="text-2xl font-black text-red-600">{{ $ewsSip }}</span>
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
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-shadow" placeholder="Cari nama pegawai, NIP, atau email...">
        </div>
        <div class="w-full md:w-48">
            <select wire:model.live="filterRole" class="block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <option value="">Semua Role</option>
                <option value="dokter">Dokter</option>
                <option value="perawat">Perawat</option>
                <option value="apoteker">Apoteker</option>
                <option value="staf">Staf Admin</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50 font-bold">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Jabatan / Role</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">SIP / STR</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($pegawais as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 font-bold text-sm">
                                        {{ substr($p->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800 dark:text-white">{{ $p->user->name ?? '-' }}</div>
                                        <div class="text-xs text-slate-500">NIP: {{ $p->nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $p->jabatan }}</div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->user->role ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs space-y-1">
                                    <div class="{{ $p->masa_berlaku_sip <= now()->addMonths(3) ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                                        SIP: {{ $p->masa_berlaku_sip ? \Carbon\Carbon::parse($p->masa_berlaku_sip)->format('d/m/Y') : '-' }}
                                    </div>
                                    <div class="{{ $p->masa_berlaku_str <= now()->addMonths(3) ? 'text-orange-600 font-bold' : 'text-slate-500' }}">
                                        STR: {{ $p->masa_berlaku_str ? \Carbon\Carbon::parse($p->masa_berlaku_str)->format('d/m/Y') : '-' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-widest
                                    @if(($p->status_kepegawaian ?? '') == 'Tetap') bg-green-100 text-green-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ $p->status_kepegawaian ?? 'Aktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold space-x-3">
                                <a href="{{ route('pegawai.edit', $p->id) }}" wire:navigate class="text-blue-600 hover:text-blue-900 uppercase">Edit</a>
                                <button onclick="confirm('Yakin hapus data pegawai?') || event.stopImmediatePropagation()" wire:click="delete({{ $p->id }})" class="text-red-600 hover:text-red-900 uppercase">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 font-bold">Belum ada data pegawai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $pegawais->links() }}
        </div>
    </div>
</div>
