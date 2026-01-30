<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-800 flex items-center gap-4">
                <div class="p-3 bg-slate-100 rounded-2xl text-slate-600 shadow-sm">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                Jejak Audit & Log Sistem
            </h2>
            <p class="text-slate-500 font-medium mt-2 ml-16 leading-relaxed">
                Rekam jejak forensik seluruh aktivitas pengguna dan perubahan data dalam sistem.
            </p>
        </div>
        <div class="flex items-center gap-3 ml-16 lg:ml-0">
            <button wire:click="resetFilters" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                Reset Filter
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="relative">
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 rounded-xl border-slate-200 bg-slate-50 text-sm focus:ring-slate-500 focus:border-slate-500 font-medium" placeholder="Cari deskripsi, ID, atau properti...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
        </div>
        
        <select wire:model.live="causer_id" class="block w-full rounded-xl border-slate-200 bg-slate-50 text-sm focus:ring-slate-500 focus:border-slate-500 font-medium text-slate-600">
            <option value="">Semua Aktor (User)</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="event" class="block w-full rounded-xl border-slate-200 bg-slate-50 text-sm focus:ring-slate-500 focus:border-slate-500 font-medium text-slate-600">
            <option value="">Semua Jenis Event</option>
            <option value="created">Created (Tambah Data)</option>
            <option value="updated">Updated (Ubah Data)</option>
            <option value="deleted">Deleted (Hapus Data)</option>
            <option value="login">Login (Akses Masuk)</option>
            <option value="logout">Logout (Akses Keluar)</option>
        </select>

        <div class="flex gap-2">
            <input wire:model.live="date_start" type="date" class="block w-full rounded-xl border-slate-200 bg-slate-50 text-sm focus:ring-slate-500 focus:border-slate-500 font-medium text-slate-600">
            <span class="self-center text-slate-400">-</span>
            <input wire:model.live="date_end" type="date" class="block w-full rounded-xl border-slate-200 bg-slate-50 text-sm focus:ring-slate-500 focus:border-slate-500 font-medium text-slate-600">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50/80 font-black text-slate-400 uppercase text-[10px] tracking-widest">
                    <tr>
                        <th class="px-8 py-5 text-left">Timestamp</th>
                        <th class="px-8 py-5 text-left">Aktor</th>
                        <th class="px-8 py-5 text-left">Event & Deskripsi</th>
                        <th class="px-8 py-5 text-left">Target Objek</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($activities as $log)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-8 py-5 whitespace-nowrap text-slate-500 font-mono text-xs">
                                {{ $log->created_at->format('d M Y') }} <br>
                                <span class="font-bold text-slate-700">{{ $log->created_at->format('H:i:s') }}</span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-black text-slate-500">
                                        {{ substr($log->causer->name ?? 'S', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700">{{ $log->causer->name ?? 'System Bot' }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase">{{ $log->causer->role ?? 'System' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col items-start gap-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider
                                        @if($log->event == 'created') bg-emerald-100 text-emerald-700
                                        @elseif($log->event == 'updated') bg-blue-100 text-blue-700
                                        @elseif($log->event == 'deleted') bg-rose-100 text-rose-700
                                        @elseif($log->event == 'login') bg-indigo-100 text-indigo-700
                                        @else bg-slate-100 text-slate-700 @endif">
                                        {{ $log->event }}
                                    </span>
                                    <p class="text-xs text-slate-600 font-medium truncate max-w-xs" title="{{ $log->description }}">{{ $log->description }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700">{{ class_basename($log->subject_type) }}</span>
                                    <span class="text-[10px] font-mono text-slate-400">ID: {{ $log->subject_id }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-right">
                                <a href="{{ route('activity-log.show', $log->id) }}" wire:navigate class="inline-flex items-center px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-[10px] font-black uppercase tracking-wider text-slate-600 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <span class="font-medium">Tidak ada log aktivitas yang ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 border-t border-slate-50">
            {{ $activities->links() }}
        </div>
    </div>
</div>