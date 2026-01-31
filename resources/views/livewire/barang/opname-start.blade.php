<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Mulai Sesi Opname Baru</h2>
            <p class="text-sm text-slate-500">Tentukan cakupan dan tanggal audit stok.</p>
        </div>
        <a href="{{ route('barang.opname.index') }}" wire:navigate class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition-colors">
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 animate-fade-in">
        <form wire:submit.prevent="store" class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Audit</label>
                <input type="date" wire:model="tanggal" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                @error('tanggal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi / Ruangan (Opsional)</label>
                <select wire:model="ruangan_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    <option value="">-- Semua Lokasi (Global) --</option>
                    @foreach($ruangans as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-400 mt-1">Pilih "Semua Lokasi" untuk audit gudang utama.</p>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Cakupan Audit (Scope)</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="scope" value="all" class="sr-only peer">
                        <div class="text-center p-3 rounded-xl border border-slate-200 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 transition-all hover:bg-slate-50">
                            <span class="block text-xs font-bold">Semua</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="scope" value="medis" class="sr-only peer">
                        <div class="text-center p-3 rounded-xl border border-slate-200 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all hover:bg-slate-50">
                            <span class="block text-xs font-bold">Aset Medis</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" wire:model="scope" value="umum" class="sr-only peer">
                        <div class="text-center p-3 rounded-xl border border-slate-200 peer-checked:bg-amber-50 peer-checked:border-amber-500 peer-checked:text-amber-700 transition-all hover:bg-slate-50">
                            <span class="block text-xs font-bold">Aset Umum</span>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Catatan</label>
                <textarea wire:model="keterangan" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Contoh: Audit Tahunan 2026..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('barang.opname.index') }}" wire:navigate class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-transform transform hover:-translate-y-0.5">
                    Mulai Sesi Audit
                </button>
            </div>
        </form>
    </div>
</div>
