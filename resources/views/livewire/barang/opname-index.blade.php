<div class="space-y-6">
    @if($isOpen)
        <!-- Form Section -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 animate-fade-in" wire:key="view-form">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-2xl font-black text-slate-800">Mulai Sesi Opname</h3>
                    <p class="text-sm text-slate-500">Isi detail sesi audit aset baru.</p>
                </div>
                <button type="button" wire:click="$set('isOpen', false)" class="p-2 bg-slate-100 rounded-full text-slate-500 hover:bg-slate-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form wire:submit.prevent="store" class="space-y-6 max-w-3xl">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Audit</label>
                    <input type="date" wire:model="tanggal" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi / Ruangan (Opsional)</label>
                    <select wire:model="ruangan_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
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
                            <div class="text-center p-3 rounded-xl border border-slate-200 peer-checked:bg-purple-50 peer-checked:border-purple-500 peer-checked:text-purple-700 transition-all hover:bg-slate-50">
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
                    <textarea wire:model="keterangan" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all" placeholder="Contoh: Audit Tahunan 2026..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                    <button type="button" wire:click="$set('isOpen', false)" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-700 shadow-lg shadow-purple-500/30">Buat Sesi</button>
                </div>
            </form>
        </div>
    @else
        <!-- List Section -->
        <div class="space-y-6" wire:key="view-list">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <div>
                    <h2 class="text-2xl font-black text-slate-800">Stok Opname & Audit</h2>
                    <p class="text-sm text-slate-500">Lakukan perhitungan fisik aset secara berkala untuk akurasi data.</p>
                </div>
                <button type="button" wire:click="create" class="px-6 py-3 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-700 transition-all shadow-lg shadow-purple-500/30 flex items-center gap-2 relative overflow-hidden">
                    <span wire:loading.remove wire:target="create" class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        Mulai Audit Baru
                    </span>
                    <span wire:loading wire:target="create" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Memuat...
                    </span>
                </button>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold">Lokasi Audit</th>
                                <th class="px-6 py-4 font-bold">Petugas</th>
                                <th class="px-6 py-4 font-bold text-center">Status</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($opnames as $op)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($op->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($op->ruangan)
                                        <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold">{{ $op->ruangan->nama_ruangan }}</span>
                                    @else
                                        <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold">Global / Gudang</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $op->user->name ?? 'Admin' }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($op->status == 'Draft')
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">Draft (Proses)</span>
                                    @else
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Final (Selesai)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('barang.opname.input', $op->id) }}" wire:navigate class="text-xs font-bold text-purple-600 hover:underline">
                                        {{ $op->status == 'Draft' ? 'Input Hasil Hitung' : 'Lihat Laporan' }} &rarr;
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada sesi stok opname.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $opnames->links() }}
                </div>
            </div>
        </div>
    @endif
</div>