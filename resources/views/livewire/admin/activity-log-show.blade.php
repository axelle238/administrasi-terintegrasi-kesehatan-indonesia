<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Detail Aktivitas</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Rincian perubahan data dan jejak audit sistem.</p>
        </div>
        <a href="{{ route('activity-log') }}" wire:navigate class="px-4 py-2 bg-slate-100 dark:bg-gray-700 text-slate-700 dark:text-gray-300 font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Meta Data -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Informasi Dasar</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-500 font-bold mb-1">Waktu Kejadian</p>
                        <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $activity->created_at->format('d F Y H:i:s') }}</p>
                        <p class="text-xs text-slate-400">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-slate-500 font-bold mb-1">Aktor (Pelaku)</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold text-xs">
                                {{ substr($activity->causer->name ?? 'S', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $activity->causer->name ?? 'System/Bot' }}</p>
                                <p class="text-xs text-slate-400">{{ $activity->causer->role ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500 font-bold mb-1">Jenis Aktivitas</p>
                        <span class="px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest
                            @if($activity->event == 'created') bg-green-100 text-green-700
                            @elseif($activity->event == 'updated') bg-blue-100 text-blue-700
                            @elseif($activity->event == 'deleted') bg-red-100 text-red-700
                            @else bg-slate-100 text-slate-700 @endif">
                            {{ $activity->event }}
                        </span>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500 font-bold mb-1">Subjek Data</p>
                        <p class="text-sm font-mono bg-slate-50 p-2 rounded border border-slate-200 text-slate-700">
                            {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Changes Data -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">Perubahan Data (Old vs New)</h3>

                @if($activity->event == 'updated' && isset($activity->properties['old']) && isset($activity->properties['attributes']))
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 rounded-l-lg">Atribut</th>
                                    <th class="px-4 py-3 bg-red-50 text-red-600">Sebelumnya (Old)</th>
                                    <th class="px-4 py-3 bg-green-50 text-green-600 rounded-r-lg">Sesudahnya (New)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                                @foreach($activity->properties['attributes'] as $key => $newValue)
                                    @php 
                                        $oldValue = $activity->properties['old'][$key] ?? '-';
                                        if($oldValue == $newValue) continue; // Skip if no change (just in case)
                                    @endphp
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 font-mono text-slate-600 font-bold">{{ $key }}</td>
                                        <td class="px-4 py-3 bg-red-50/30 text-red-600 break-words max-w-xs">{{ is_array($oldValue) ? json_encode($oldValue) : $oldValue }}</td>
                                        <td class="px-4 py-3 bg-green-50/30 text-green-600 break-words max-w-xs">{{ is_array($newValue) ? json_encode($newValue) : $newValue }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @elseif($activity->event == 'created' || isset($activity->properties['attributes']))
                    <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                        <h4 class="text-green-800 font-bold mb-2">Data Baru Ditambahkan:</h4>
                        <pre class="text-xs text-green-700 whitespace-pre-wrap font-mono">{{ json_encode($activity->properties['attributes'], JSON_PRETTY_PRINT) }}</pre>
                    </div>
                @elseif($activity->event == 'deleted' || isset($activity->properties['old']))
                    <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                        <h4 class="text-red-800 font-bold mb-2">Data Dihapus:</h4>
                        <pre class="text-xs text-red-700 whitespace-pre-wrap font-mono">{{ json_encode($activity->properties['old'], JSON_PRETTY_PRINT) }}</pre>
                    </div>
                @else
                    <div class="text-center py-10 text-slate-400 italic">
                        Tidak ada detail properti yang terekam.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
