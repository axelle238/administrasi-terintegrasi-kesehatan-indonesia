<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Pusat Persetujuan Cuti</h2>
            <p class="text-sm text-slate-500">Kelola dan verifikasi permohonan cuti dari seluruh pegawai.</p>
        </div>
        <select wire:model.live="filterStatus" class="rounded-xl border-slate-200 font-bold text-sm bg-slate-50 focus:bg-white transition-all">
            <option value="">Semua Status</option>
            <option value="Pending">Menunggu (Pending)</option>
            <option value="Disetujui">Disetujui</option>
            <option value="Ditolak">Ditolak</option>
        </select>
    </div>

    <div class="space-y-4">
        @forelse($cutis as $cuti)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="flex flex-col md:flex-row justify-between gap-6 relative z-10">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-lg">
                        {{ substr($cuti->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-lg">{{ $cuti->user->name }}</h4>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-2">{{ $cuti->user->pegawai->jabatan ?? 'Pegawai' }}</p>
                        
                        <div class="flex flex-wrap gap-2 text-sm text-slate-600">
                            <span class="px-2 py-1 bg-slate-100 rounded-lg font-mono font-bold">{{ $cuti->durasi_hari }} Hari</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M Y') }}
                            </span>
                        </div>
                        
                        <div class="mt-3 p-3 bg-slate-50 rounded-xl border border-slate-100 text-sm italic text-slate-600">
                            "{{ $cuti->keterangan }}"
                        </div>
                        
                        @if($cuti->file_bukti)
                        <a href="{{ Storage::url($cuti->file_bukti) }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-xs font-bold text-blue-600 hover:underline">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            Lihat Lampiran
                        </a>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col items-end justify-between gap-4">
                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest 
                        {{ $cuti->status == 'Pending' ? 'bg-amber-100 text-amber-700' : ($cuti->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                        {{ $cuti->status }}
                    </span>

                    @if($cuti->status == 'Pending')
                    <div class="flex gap-2">
                        <button wire:click="approve({{ $cuti->id }})" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold text-xs hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-transform hover:-translate-y-0.5">
                            Setujui
                        </button>
                        <button wire:click="reject({{ $cuti->id }})" class="px-4 py-2 bg-white border border-red-200 text-red-600 rounded-xl font-bold text-xs hover:bg-red-50 transition-colors">
                            Tolak
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-white rounded-[3rem] border border-slate-100">
            <p class="text-slate-400 font-bold">Tidak ada data permohonan cuti.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $cutis->links() }}
    </div>
</div>
