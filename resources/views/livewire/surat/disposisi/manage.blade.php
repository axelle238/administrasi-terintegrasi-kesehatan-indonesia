<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Detail Surat & Form -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Detail Surat -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Informasi Surat</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <label class="text-xs text-slate-400 uppercase font-bold">Nomor Surat</label>
                    <p class="font-mono font-bold text-slate-800">{{ $surat->nomor_surat }}</p>
                </div>
                <div>
                    <label class="text-xs text-slate-400 uppercase font-bold">Perihal</label>
                    <p class="font-medium text-slate-700">{{ $surat->perihal }}</p>
                </div>
                <div>
                    <label class="text-xs text-slate-400 uppercase font-bold">Pengirim</label>
                    <p class="text-slate-600">{{ $surat->pengirim }}</p>
                </div>
                <div>
                    <label class="text-xs text-slate-400 uppercase font-bold">Tanggal Surat</label>
                    <p class="text-slate-600">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') }}</p>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('surat.index') }}" class="w-full btn-secondary flex justify-center">Kembali ke Arsip</a>
            </div>
        </div>

        <!-- Form Tambah Disposisi -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Buat Disposisi Baru
            </h3>
            <form wire:submit="save" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-sm font-bold text-slate-700">Tujuan Disposisi</label>
                    <select wire:model="penerima_id" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200 text-sm">
                        <option value="">Pilih Pegawai/User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->role }}</option>
                        @endforeach
                    </select>
                    @error('penerima_id') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-sm font-bold text-slate-700">Sifat</label>
                        <select wire:model="sifat" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200 text-sm">
                            <option value="Biasa">Biasa</option>
                            <option value="Penting">Penting</option>
                            <option value="Segera">Segera</option>
                            <option value="Rahasia">Rahasia</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-bold text-slate-700">Batas Waktu</label>
                        <input wire:model="batas_waktu" type="date" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200 text-sm">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-sm font-bold text-slate-700">Instruksi / Catatan</label>
                    <textarea wire:model="catatan" rows="3" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-200 text-sm" placeholder="Tulis instruksi disposisi..."></textarea>
                    @error('catatan') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full btn-primary flex justify-center items-center gap-2">
                    Kirim Disposisi
                </button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Riwayat Disposisi -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="font-bold text-slate-800 mb-6 text-lg">Riwayat & Alur Disposisi</h3>
        
        <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
            @forelse($disposisiList as $disposisi)
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                    </div>
                    
                    <!-- Card -->
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between space-x-2 mb-1">
                            <div class="font-bold text-slate-800 text-sm">{{ $disposisi->pengirim->name }} <span class="text-slate-400 font-normal">kepada</span> {{ $disposisi->penerima->name }}</div>
                            <time class="font-mono text-xs text-slate-400">{{ $disposisi->created_at->format('d/m/Y H:i') }}</time>
                        </div>
                        <div class="mb-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                {{ $disposisi->sifat == 'Segera' ? 'bg-red-100 text-red-600' : ($disposisi->sifat == 'Penting' ? 'bg-amber-100 text-amber-600' : 'bg-slate-100 text-slate-600') }}">
                                {{ $disposisi->sifat }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mb-3 bg-slate-50 p-2 rounded-lg italic">"{{ $disposisi->catatan }}"</p>
                        
                        <div class="flex justify-between items-center border-t border-slate-50 pt-2">
                            <div class="text-xs text-slate-400">
                                @if($disposisi->batas_waktu)
                                    Batas: <span class="text-red-500 font-bold">{{ \Carbon\Carbon::parse($disposisi->batas_waktu)->format('d M Y') }}</span>
                                @endif
                            </div>
                            <button wire:click="delete({{ $disposisi->id }})" wire:confirm="Hapus disposisi ini?" class="text-red-500 hover:text-red-700 text-xs font-bold">Hapus</button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 relative z-10 bg-white">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3 text-slate-300">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    </div>
                    <p class="text-slate-500 font-medium text-sm">Belum ada riwayat disposisi untuk surat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>