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
                    <button wire:click="viewDetail({{ $log->id }})" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 px-3 py-1 rounded-full transition">Lihat Detail</button>
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

    <!-- Detail Modal -->
    @if($detailOpen && $selectedLog)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeDetail"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full {{ $selectedLog->event == 'created' ? 'bg-green-100 text-green-600' : ($selectedLog->event == 'updated' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }} sm:mx-0 sm:h-10 sm:w-10">
                            @if($selectedLog->event == 'created')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            @elseif($selectedLog->event == 'updated')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            @endif
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Detail Aktivitas</h3>
                            
                            <div class="mt-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <p class="text-sm text-slate-700 font-medium leading-relaxed">
                                    {{ $this->generateNarrative($selectedLog) }}
                                </p>
                                <p class="text-xs text-slate-500 mt-2">
                                    Waktu: {{ $selectedLog->created_at->translatedFormat('l, d F Y H:i:s') }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Data Teknis (Raw)</h4>
                                <div class="bg-gray-900 rounded-lg p-3 overflow-x-auto max-h-60 custom-scrollbar">
                                    <pre class="text-xs text-green-400 font-mono">{{ json_encode($selectedLog->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="closeDetail" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>