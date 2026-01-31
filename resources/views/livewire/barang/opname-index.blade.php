<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Stok Opname & Audit</h2>
            <p class="text-sm text-slate-500">Lakukan perhitungan fisik aset secara berkala untuk akurasi data.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-700 transition-all shadow-lg shadow-purple-500/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
            Mulai Audit Baru
        </button>
    </div>

    <!-- Modal Create Sesi -->
    <div x-show="$wire.isOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg p-8">
            <h3 class="text-xl font-black text-slate-800 mb-6">Mulai Sesi Opname</h3>
            <form wire:submit.prevent="store" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Audit</label>
                    <input type="date" wire:model="tanggal" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi / Ruangan (Opsional)</label>
                    <select wire:model="ruangan_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <option value="">-- Semua Lokasi (Global) --</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-400 mt-1">Pilih "Semua Lokasi" untuk audit gudang utama.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Catatan</label>
                    <textarea wire:model="keterangan" rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl" placeholder="Contoh: Audit Tahunan 2026..."></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="$set('isOpen', false)" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold">Batal</button>
                    <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-700">Buat Sesi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table List Opname -->
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
                            <button class="text-xs font-bold text-purple-600 hover:underline">
                                {{ $op->status == 'Draft' ? 'Input Hasil Hitung' : 'Lihat Laporan' }} &rarr;
                            </button>
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
