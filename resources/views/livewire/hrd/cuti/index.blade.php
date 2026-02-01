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

    <!-- Rejection Panel (Inline - No Modal) -->
    @if($confirmingReject)
    <div class="bg-white p-8 rounded-[2rem] border border-rose-100 shadow-xl shadow-rose-500/5 animate-fade-in-up mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="font-black text-slate-800 text-lg">Alasan Penolakan Pengajuan Cuti</h3>
                <p class="text-sm text-slate-500 mt-1">Berikan penjelasan detail mengapa pengajuan cuti <span class="font-bold text-rose-600">{{ $data->find($confirmingReject)->user->name ?? 'Pegawai' }}</span> ditolak.</p>
            </div>
            <button wire:click="$set('confirmingReject', null)" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <textarea wire:model="rejectReason" class="w-full rounded-2xl border-slate-200 text-sm focus:ring-rose-500 focus:border-rose-500 bg-slate-50" rows="4" placeholder="Tuliskan alasan penolakan di sini..."></textarea>
        @error('rejectReason') <p class="text-xs text-rose-600 font-bold mt-2">{{ $message }}</p> @enderror

        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-50">
            <button wire:click="$set('confirmingReject', null)" class="px-6 py-2.5 bg-slate-100 text-slate-600 font-bold text-xs rounded-xl uppercase tracking-widest transition-all">Batal</button>
            <button wire:click="reject" class="px-8 py-2.5 bg-rose-600 text-white font-bold text-xs rounded-xl shadow-lg shadow-rose-600/20 hover:bg-rose-700 transition-all uppercase tracking-widest">Konfirmasi Penolakan</button>
        </div>
    </div>
    @endif

    <!-- Table -->
</div>