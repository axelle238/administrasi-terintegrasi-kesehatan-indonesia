<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Form Perpindahan Aset (Mutasi)</h2>
        <a href="{{ route('barang.mutasi.index') }}" wire:navigate class="text-gray-600 hover:text-gray-900 font-bold text-sm">Kembali</a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 animate-fade-in relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <svg class="w-64 h-64 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 17a2 2 0 11-4 0 2 2 0 014 0zM9 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" /></svg>
        </div>

        <form wire:submit.prevent="save" class="relative z-10 space-y-8">
            
            <!-- Asset Selection -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs">1</div>
                    Pilih Aset
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Cari Barang / Aset</label>
                        <select wire:model.live="barang_id" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $b)
                                <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                            @endforeach
                        </select>
                        @error('barang_id') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    
                    @if($barang_id)
                    <div class="md:col-span-2 flex items-center gap-4 bg-white p-4 rounded-xl border border-slate-200">
                        <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase">Lokasi Saat Ini</p>
                            <p class="font-black text-slate-800 text-lg">{{ $nama_ruangan_asal }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Destination Selection -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">2</div>
                    Tujuan Mutasi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ruangan Baru</label>
                        <select wire:model="ruangan_id_tujuan" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 transition-all">
                            <option value="">-- Pilih Ruangan Tujuan --</option>
                            @foreach($ruangans as $r)
                                <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @error('ruangan_id_tujuan') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pindah</label>
                        <input type="date" wire:model="tanggal_mutasi" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Penanggung Jawab</label>
                        <input type="text" wire:model="penanggung_jawab" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Keterangan / Alasan</label>
                        <input type="text" wire:model="keterangan" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: Pemenuhan kebutuhan poli...">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('barang.mutasi.index') }}" wire:navigate class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 relative">
                    <span wire:loading.remove wire:target="save">Proses Mutasi</span>
                    <span wire:loading wire:target="save">Memproses...</span>
                </button>
            </div>
        </form>
    </div>
</div>