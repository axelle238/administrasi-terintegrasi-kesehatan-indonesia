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

    <!-- Detail Modal (Slip) -->
    @if($showDetail && $selectedGaji)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="closeDetail"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative">
                <!-- Receipt Header -->
                <div class="bg-slate-800 p-6 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
                    <div class="w-16 h-16 bg-white rounded-full mx-auto flex items-center justify-center mb-3 shadow-lg">
                        <svg class="w-8 h-8 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-white font-bold text-xl">Pembayaran Gaji Sukses</h3>
                    <p class="text-slate-400 text-sm">{{ $selectedGaji->bulan }} {{ $selectedGaji->tahun }}</p>
                </div>

                <!-- Receipt Body -->
                <div class="p-8 space-y-6">
                    <div class="text-center">
                        <p class="text-sm text-slate-500 font-bold uppercase tracking-widest">Total Diterima (Take Home Pay)</p>
                        <h2 class="text-4xl font-black text-slate-800 mt-2">Rp {{ number_format($selectedGaji->total_gaji, 0, ',', '.') }}</h2>
                    </div>

                    <div class="border-t border-dashed border-slate-200 my-6"></div>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Gaji Pokok</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($selectedGaji->gaji_pokok, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tunjangan</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($selectedGaji->tunjangan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Lembur</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($selectedGaji->lembur ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-red-500">
                            <span>Potongan</span>
                            <span class="font-bold">- Rp {{ number_format($selectedGaji->potongan, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl text-center">
                        <p class="text-xs text-slate-400">Dana ditransfer ke rekening:</p>
                        <p class="font-mono font-bold text-slate-700 mt-1">{{ $selectedGaji->user->pegawai->no_rekening ?? 'XXXXXXXX' }} ({{ $selectedGaji->user->pegawai->bank ?? 'BANK' }})</p>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="bg-slate-50 p-4 flex gap-3">
                    <button wire:click="closeDetail" class="flex-1 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-100">Tutup</button>
                    <a href="{{ route('kepegawaian.gaji.print', $selectedGaji->id) }}" target="_blank" class="flex-1 py-3 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
