<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up">
    <!-- Form Mutasi -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm sticky top-24">
            <h3 class="font-black text-slate-800 text-lg mb-6">Input Riwayat Karir</h3>
            
            @if (session()->has('message'))
                <div class="bg-emerald-50 text-emerald-600 p-3 rounded-xl text-xs font-bold mb-4">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis Perubahan</label>
                    <select wire:model="jenis_perubahan" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-700 py-3">
                        <option value="Mutasi">Mutasi (Pindah Unit)</option>
                        <option value="Promosi">Promosi (Naik Jabatan)</option>
                        <option value="Demosi">Demosi (Turun Jabatan)</option>
                        <option value="Perekrutan">Awal Masuk</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jabatan Baru</label>
                    <input type="text" wire:model="jabatan_baru" class="w-full rounded-xl border-slate-200 text-sm font-bold py-3" placeholder="Contoh: Kepala Ruangan">
                    @error('jabatan_baru') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Unit Kerja Baru</label>
                    <input type="text" wire:model="unit_kerja_baru" class="w-full rounded-xl border-slate-200 text-sm font-bold py-3" placeholder="Contoh: Poli Umum">
                    @error('unit_kerja_baru') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nomor SK</label>
                    <input type="text" wire:model="nomor_sk" class="w-full rounded-xl border-slate-200 text-sm font-bold py-3" placeholder="Nomor Surat Keputusan">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Berlaku</label>
                    <input type="date" wire:model="tanggal_mulai" class="w-full rounded-xl border-slate-200 text-sm font-bold py-3 text-slate-700">
                    @error('tanggal_mulai') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold uppercase tracking-wider shadow-lg shadow-blue-600/20 transition-all">
                    Simpan Riwayat
                </button>
            </form>
        </div>
    </div>

    <!-- Timeline History -->
    <div class="lg:col-span-2">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm h-full">
            <h3 class="font-black text-slate-800 text-lg mb-8">Jejak Karir Pegawai</h3>
            
            <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                @forelse($riwayat as $item)
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                        @if($item->jenis_perubahan == 'Promosi')
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        @elseif($item->jenis_perubahan == 'Demosi')
                            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                        @else
                            <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 rounded-2xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition-all group-hover:border-blue-200">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $item->jenis_perubahan == 'Promosi' ? 'bg-emerald-100 text-emerald-700' : ($item->jenis_perubahan == 'Demosi' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ $item->jenis_perubahan }}
                            </span>
                            <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus riwayat ini?" class="text-slate-300 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                        
                        <h4 class="font-bold text-slate-800 text-lg">{{ $item->jabatan_baru }}</h4>
                        <p class="text-slate-500 font-medium text-sm mb-4">{{ $item->unit_kerja_baru }}</p>
                        
                        <div class="flex items-center gap-4 text-xs text-slate-400 font-mono pt-4 border-t border-slate-50">
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                            </span>
                            @if($item->nomor_sk)
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                SK: {{ $item->nomor_sk }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <p class="text-slate-400 italic">Belum ada riwayat jabatan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>