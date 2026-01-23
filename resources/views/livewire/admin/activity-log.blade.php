<div class="space-y-6">
    <!-- Filter -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-end">
        <div class="w-full md:w-1/4">
            <x-input-label value="Cari Aktivitas" />
            <x-text-input wire:model.live.debounce.300ms="search" placeholder="Deskripsi..." class="w-full mt-1" />
        </div>
        <div class="w-full md:w-1/4">
            <x-input-label value="User (Pelaku)" />
            <select wire:model.live="causer_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                <option value="">Semua User</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role }})</option>
                @endforeach
            </select>
        </div>
        <div class="w-full md:w-1/4">
            <x-input-label value="Jenis Event" />
            <select wire:model.live="event" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                <option value="">Semua</option>
                <option value="created">Created (Tambah)</option>
                <option value="updated">Updated (Ubah)</option>
                <option value="deleted">Deleted (Hapus)</option>
            </select>
        </div>
        <div class="w-full md:w-auto">
            <button wire:click="resetFilters" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">Reset</button>
        </div>
    </div>

    <!-- Timeline Log -->
    <div class="space-y-4">
        @forelse($activities as $log)
            <div class="bg-white p-4 rounded-lg shadow border-l-4 {{ $log->event == 'created' ? 'border-green-500' : ($log->event == 'updated' ? 'border-yellow-500' : 'border-red-500') }}">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-gray-800">
                                {{ $log->causer->name ?? 'System' }}
                            </span>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $log->event == 'created' ? 'bg-green-100 text-green-800' : ($log->event == 'updated' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ strtoupper($log->event) }}
                            </span>
                            <span class="text-sm text-gray-600">
                                {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $log->created_at->format('d M Y H:i:s') }} ({{ $log->created_at->diffForHumans() }})</p>
                    </div>
                </div>

                <!-- Changes Detail -->
                @if($log->event == 'updated' && isset($log->properties['old']) && isset($log->properties['attributes']))
                    <div class="mt-3 bg-gray-50 p-2 rounded text-xs font-mono overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left w-1/3 text-gray-500">Field</th>
                                    <th class="text-left w-1/3 text-red-600">Sebelum</th>
                                    <th class="text-left w-1/3 text-green-600">Sesudah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($log->properties['attributes'] as $key => $newVal)
                                    @if(isset($log->properties['old'][$key]) && $log->properties['old'][$key] != $newVal)
                                        <tr>
                                            <td class="font-bold">{{ $key }}</td>
                                            <td class="text-red-600">{{ is_array($log->properties['old'][$key]) ? json_encode($log->properties['old'][$key]) : $log->properties['old'][$key] }}</td>
                                            <td class="text-green-600">{{ is_array($newVal) ? json_encode($newVal) : $newVal }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @elseif($log->event == 'created')
                    <div class="mt-3 text-xs text-gray-600">
                        <span class="font-bold">Data Baru:</span> {{ Str::limit(json_encode($log->properties['attributes']), 150) }}
                    </div>
                @endif
            </div>
        @empty
            <div class="p-8 text-center text-gray-500">Belum ada aktivitas tercatat.</div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $activities->links() }}
    </div>
</div>