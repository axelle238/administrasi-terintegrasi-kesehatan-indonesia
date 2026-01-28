<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Audit Trail & Log Sistem</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Rekam jejak aktivitas pengguna dan perubahan data.</p>
        </div>
        <button wire:click="resetFilters" class="text-sm text-slate-500 hover:text-slate-700 underline">Reset Filter</button>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input wire:model.live.debounce.300ms="search" type="text" class="block w-full rounded-xl border-gray-200 dark:border-gray-600 bg-gray-50 text-sm" placeholder="Cari deskripsi...">
        
        <select wire:model.live="causer_id" class="block w-full rounded-xl border-gray-200 bg-gray-50 text-sm">
            <option value="">Semua User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="event" class="block w-full rounded-xl border-gray-200 bg-gray-50 text-sm">
            <option value="">Semua Event</option>
            <option value="created">Created (Tambah)</option>
            <option value="updated">Updated (Ubah)</option>
            <option value="deleted">Deleted (Hapus)</option>
            <option value="login">Login</option>
        </select>

        <div class="flex gap-2">
            <input wire:model.live="date_start" type="date" class="block w-full rounded-xl border-gray-200 bg-gray-50 text-sm">
            <input wire:model.live="date_end" type="date" class="block w-full rounded-xl border-gray-200 bg-gray-50 text-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50 font-bold">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Aktor</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-4 text-left text-xs text-gray-500 uppercase tracking-wider">Subjek</th>
                        <th class="px-6 py-4 text-right text-xs text-gray-500 uppercase tracking-wider">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                    @forelse($activities as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-slate-700 dark:text-white">{{ $log->causer->name ?? 'System' }}</span>
                                <span class="block text-xs text-slate-400">{{ $log->causer->role ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($log->event == 'created') bg-green-100 text-green-800
                                    @elseif($log->event == 'updated') bg-blue-100 text-blue-800
                                    @elseif($log->event == 'deleted') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($log->event) }}
                                </span>
                                <p class="text-xs text-slate-500 mt-1 truncate max-w-xs">{{ $log->description }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-mono text-xs">
                                {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('activity-log.show', $log->id) }}" wire:navigate class="text-blue-600 hover:text-blue-900 font-bold text-xs uppercase tracking-widest">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada log aktivitas yang terekam.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6">
            {{ $activities->links() }}
        </div>
    </div>
</div>
