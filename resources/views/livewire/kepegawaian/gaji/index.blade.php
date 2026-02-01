<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-6 rounded-3xl text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
            <p class="text-xs font-bold text-emerald-100 uppercase tracking-widest mb-1">Total Pendapatan (YTD)</p>
            <h3 class="text-3xl font-black">Rp {{ number_format($riwayatGaji->sum('total_gaji'), 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-200 mt-2">Tahun {{ date('Y') }}</p>
        </div>
    </div>

    <!-- History List -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <h3 class="text-xl font-black text-slate-800 mb-6">Riwayat Pembayaran</h3>
        
        <div class="space-y-4">
            @forelse($riwayatGaji as $gaji)
            <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:border-emerald-200 transition-all cursor-pointer group" wire:click="show({{ $gaji->id }})">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-black text-lg group-hover:scale-110 transition-transform">
                        {{ substr($gaji->bulan, 0, 3) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-lg">{{ $gaji->bulan }} {{ $gaji->tahun }}</h4>
                        <p class="text-xs text-slate-500 font-mono">ID: #PAY-{{ str_pad($gaji->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-black text-emerald-600 text-lg">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</p>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Dibayarkan {{ $gaji->updated_at->format('d M') }}</span>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-slate-400">Belum ada riwayat gaji.</div>
            @endforelse
        </div>
        
        <div class="mt-6">
            {{ $riwayatGaji->links() }}
        </div>
    </div>

    <!-- Detail Section (Inline - No Modal) -->
    @if($showDetail && $selectedGaji)
    <div class="bg-white rounded-[2.5rem] border border-blue-100 shadow-xl overflow-hidden animate-fade-in-up mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <!-- Receipt Side -->
            <div class="bg-slate-800 p-10 text-center relative overflow-hidden flex flex-col justify-center">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
                <div class="w-20 h-20 bg-white/10 rounded-full mx-auto flex items-center justify-center mb-6 backdrop-blur-sm border border-white/10">
                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-white font-black text-2xl mb-2">Slip Gaji Digital</h3>
                <p class="text-slate-400 font-mono tracking-widest uppercase text-xs">{{ $selectedGaji->bulan }} {{ $selectedGaji->tahun }}</p>
                
                <div class="mt-8">
                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.2em] mb-2">Total Diterima</p>
                    <h2 class="text-4xl font-black text-white">Rp {{ number_format($selectedGaji->total_gaji, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- Info Side -->
            <div class="p-10 space-y-8 bg-white">
                <div class="flex justify-between items-center">
                    <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs">Rincian Komponen</h4>
                    <button wire:click="closeDetail" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500 font-bold uppercase tracking-tighter">Gaji Pokok</span>
                        <span class="font-black text-slate-800">Rp {{ number_format($selectedGaji->gaji_pokok, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500 font-bold uppercase tracking-tighter">Tunjangan</span>
                        <span class="font-black text-slate-800">Rp {{ number_format($selectedGaji->tunjangan, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500 font-bold uppercase tracking-tighter">Lembur</span>
                        <span class="font-black text-slate-800">Rp {{ number_format($selectedGaji->lembur ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-4 border-t border-dashed border-slate-100 flex justify-between items-center text-sm text-rose-600">
                        <span class="font-bold uppercase tracking-tighter">Total Potongan</span>
                        <span class="font-black">- Rp {{ number_format($selectedGaji->potongan, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100">
                    <p class="text-[10px] text-blue-400 font-black uppercase tracking-wider mb-1 text-center">Rekening Tujuan</p>
                    <p class="font-mono font-bold text-blue-800 text-center text-sm">{{ $selectedGaji->user->pegawai->no_rekening ?? 'XXXXXXXX' }} ({{ $selectedGaji->user->pegawai->bank ?? 'BANK' }})</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('kepegawaian.gaji.print', $selectedGaji->id) }}" target="_blank" class="flex-1 py-3 bg-slate-800 text-white rounded-xl text-xs font-black hover:bg-slate-900 text-center flex items-center justify-center gap-2 uppercase tracking-widest shadow-lg shadow-slate-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- History List -->
</div>
