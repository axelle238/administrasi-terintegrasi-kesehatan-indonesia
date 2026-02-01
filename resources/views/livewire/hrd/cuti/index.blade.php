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
                        <th class="p-6">Jenis & Durasi</th>
                        <th class="p-6">Tanggal</th>
                        <th class="p-6">Keterangan</th>
                        <th class="p-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($data as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-6">
                            <div class="font-bold text-slate-800">{{ $item->user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $item->user->pegawai->jabatan ?? '-' }}</div>
                            
                            @if($item->jenis_cuti == 'Cuti Tahunan')
                                <div class="mt-2 inline-flex items-center gap-1 bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-[10px] font-bold">
                                    Sisa Cuti: {{ $item->user->pegawai->sisa_cuti ?? 0 }} Hari
                                </div>
                            @endif
                        </td>
                        <td class="p-6">
                            <span class="block font-bold text-slate-700">{{ $item->jenis_cuti }}</span>
                            <span class="text-xs text-slate-500">{{ $item->durasi_hari }} Hari Kerja</span>
                        </td>
                        <td class="p-6 font-mono text-xs text-slate-600">
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} <br>
                            s/d <br>
                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                        </td>
                        <td class="p-6 text-slate-600 max-w-xs italic">
                            "{{ $item->keterangan }}"
                            @if($item->file_bukti)
                                <a href="{{ Storage::url($item->file_bukti) }}" target="_blank" class="block mt-1 text-[10px] font-bold text-blue-500 hover:underline">Lihat Lampiran</a>
                            @endif
                        </td>
                        <td class="p-6 text-right">
                            @if($item->status == 'Pending')
                                <div class="flex justify-end gap-2">
                                    <button wire:click="approve({{ $item->id }})" wire:confirm="Setujui pengajuan cuti ini?" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-emerald-500/20 transition-all">
                                        Setujui
                                    </button>
                                    <button wire:click="confirmReject({{ $item->id }})" class="px-4 py-2 bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 rounded-xl text-xs font-bold transition-all">
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
                        <td colspan="5" class="p-12 text-center text-slate-400 italic">Tidak ada pengajuan cuti {{ strtolower($filterStatus) }}.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">
            {{ $data->links() }}
        </div>
    </div>

    <!-- Reject Modal (Simple) -->
    @if($confirmingReject)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-2xl w-full max-w-md shadow-2xl animate-fade-in-up">
            <h3 class="font-bold text-lg text-slate-800 mb-4">Alasan Penolakan</h3>
            <textarea wire:model="rejectReason" class="w-full rounded-xl border-slate-200 text-sm mb-4" rows="3" placeholder="Jelaskan alasan penolakan..."></textarea>
            <div class="flex justify-end gap-2">
                <button wire:click="$set('confirmingReject', null)" class="px-4 py-2 text-slate-500 text-xs font-bold">Batal</button>
                <button wire:click="reject" class="px-4 py-2 bg-red-600 text-white rounded-xl text-xs font-bold hover:bg-red-700">Tolak Pengajuan</button>
            </div>
        </div>
    </div>
    @endif
</div>