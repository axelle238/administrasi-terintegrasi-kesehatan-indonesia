<div class="space-y-6">
    <!-- Header & Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 text-white shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-indigo-200 uppercase tracking-widest mb-1">Pasien Dirawat</p>
                    <h3 class="text-3xl font-black">{{ $admissions->total() }}</h3>
                </div>
                <div class="p-3 bg-white/10 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs font-medium text-indigo-100">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                Data Real-time
            </div>
        </div>

        <div class="md:col-span-2 bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Manajemen Rawat Inap</h3>
                <p class="text-slate-500 text-sm mt-1">Kelola pendaftaran, pemindahan kamar, dan kepulangan pasien.</p>
            </div>
            <a href="{{ route('rawat-inap.create') }}" wire:navigate class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-indigo-500/20 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Daftarkan Pasien
            </a>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Cari nama pasien...">
        </div>
    </div>

    <!-- Data List -->
    <div class="space-y-4">
        @forelse($admissions as $admit)
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-lg">
                    {{ substr($admit->pasien->nama_lengkap, 0, 1) }}
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">{{ $admit->pasien->nama_lengkap }}</h4>
                    <p class="text-xs text-slate-500 font-mono">RM: {{ $admit->pasien->no_rm ?? '-' }}</p>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded text-[10px] font-bold uppercase">{{ $admit->jenis_pembayaran }}</span>
                        <span class="text-[10px] text-slate-400">Masuk: {{ \Carbon\Carbon::parse($admit->waktu_masuk)->format('d M H:i') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Lokasi</p>
                    <p class="font-bold text-slate-800">{{ $admit->kamar->nama_kamar ?? 'Unassigned' }}</p>
                    <p class="text-xs text-slate-500">{{ $admit->kamar->nama_bangsal ?? '-' }}</p>
                </div>

                <div class="flex items-center gap-2">
                    <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors" title="Pindah Kamar">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    </button>
                    <a href="{{ route('rawat-inap.checkout', $admit->id) }}" wire:navigate class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition-all">
                        Checkout
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
            <p class="text-slate-400 font-medium">Tidak ada pasien rawat inap aktif.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $admissions->links() }}
    </div>
</div>