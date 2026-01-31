<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Manajemen Lembur</h2>
            <p class="text-sm text-slate-500">Approval pengajuan lembur pegawai.</p>
        </div>
        <select wire:model.live="filterStatus" class="rounded-xl border-slate-200 font-bold text-sm bg-slate-50">
            <option value="Menunggu">Menunggu</option>
            <option value="Disetujui">Disetujui</option>
            <option value="Ditolak">Ditolak</option>
        </select>
    </div>

    <div class="space-y-4">
        @forelse($lemburs as $l)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 relative group hover:shadow-md transition-all">
            <div class="flex justify-between items-start gap-4">
                <div>
                    <h4 class="font-bold text-slate-800">{{ $l->user->name }}</h4>
                    <p class="text-xs text-slate-500 mb-2">{{ $l->user->pegawai->jabatan ?? '-' }}</p>
                    <div class="text-sm text-slate-600 mb-2">
                        <strong>{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</strong> 
                        ({{ $l->jam_mulai }} - {{ $l->jam_selesai }})
                    </div>
                    <p class="text-xs text-slate-500 italic bg-slate-50 p-2 rounded-lg border border-slate-100">"{{ $l->alasan_lembur }}"</p>
                    
                    @if($l->output_kerja)
                    <div class="mt-2 text-xs text-indigo-600 font-bold">Output: {{ $l->output_kerja }}</div>
                    @endif
                </div>

                <div class="flex flex-col items-end gap-2">
                    <span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-wider 
                        {{ $l->status == 'Menunggu' ? 'bg-amber-100 text-amber-700' : ($l->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                        {{ $l->status }}
                    </span>

                    @if($l->status == 'Menunggu')
                    <div class="flex gap-2 mt-2">
                        <button wire:click="approve({{ $l->id }})" class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700">Approve</button>
                        <button wire:click="reject({{ $l->id }})" class="px-3 py-1.5 bg-white border border-red-200 text-red-600 rounded-lg text-xs font-bold hover:bg-red-50">Reject</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-slate-400 font-bold bg-white rounded-[2.5rem]">Tidak ada data lembur.</div>
        @endforelse
    </div>
    
    <div class="mt-4">
        {{ $lemburs->links() }}
    </div>
</div>
