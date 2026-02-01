<div class="space-y-6 animate-fade-in">
    <!-- Filter Tabs -->
    <div class="flex space-x-1 bg-slate-100 p-1 rounded-xl w-fit">
        @foreach(['Pending', 'Disetujui', 'Ditolak'] as $status)
            <button wire:click="$set('filterStatus', '{{ $status }}')" 
                class="px-4 py-2 text-xs font-bold rounded-lg transition-all {{ $filterStatus === $status ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                {{ $status }}
            </button>
        @endforeach
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider">
                    <tr>
                        <th class="p-6">Pegawai</th>
                        <th class="p-6">Waktu Lembur</th>
                        <th class="p-6">Output Kerja</th>
                        <th class="p-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($data as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-6">
                            <div class="font-bold text-slate-800">{{ $item->user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $item->user->pegawai->jabatan ?? '-' }}</div>
                        </td>
                        <td class="p-6">
                            <div class="font-mono text-xs font-bold text-slate-700">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                            </div>
                            @php
                                $durasi = \Carbon\Carbon::parse($item->jam_mulai)->diffInHours(\Carbon\Carbon::parse($item->jam_selesai));
                            @endphp
                            <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 rounded text-[10px] font-bold text-slate-600">{{ $durasi }} Jam</span>
                        </td>
                        <td class="p-6">
                            <p class="font-bold text-slate-700 text-xs mb-1">Alasan: {{ $item->alasan_lembur }}</p>
                            <p class="text-slate-500 italic text-xs">"{{ $item->output_kerja }}"</p>
                        </td>
                        <td class="p-6 text-right">
                            @if($item->status == 'Pending')
                                <div class="flex justify-end gap-2">
                                    <button wire:click="approve({{ $item->id }})" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-500/20 transition-all">
                                        Setujui
                                    </button>
                                    <button wire:click="reject({{ $item->id }})" wire:confirm="Tolak lembur ini?" class="px-4 py-2 bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 rounded-xl text-xs font-bold transition-all">
                                        Tolak
                                    </button>
                                </div>
                            @else
                                <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ $item->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $item->status }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-400 italic">Tidak ada data lembur {{ strtolower($filterStatus) }}.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">
            {{ $data->links() }}
        </div>
    </div>
</div>