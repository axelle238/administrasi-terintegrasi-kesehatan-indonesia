<div class="space-y-6 animate-fade-in pb-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-800">Inventaris Fasilitas Pegawai</h2>
            <p class="text-sm text-slate-500">Monitoring aset kantor yang dipinjamkan/dipegang oleh personal.</p>
        </div>
        <button wire:click="openHandover" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-600/20 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Serah Terima Aset
        </button>
    </div>

    <!-- Handover Form (Inline) -->
    @if($isHandoverOpen)
    <div class="bg-white p-8 rounded-[2.5rem] border border-blue-100 shadow-xl relative overflow-hidden animate-fade-in-up">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-cyan-500"></div>
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-widest">Formulir Peminjaman Aset</h3>
            <button wire:click="cancel" class="p-2 text-slate-400 hover:text-slate-600 bg-slate-50 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-3">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pegawai Penerima</label>
                <select wire:model="pegawai_id" class="w-full rounded-xl border-slate-200 font-bold text-slate-700 focus:ring-blue-500">
                    <option value="">Pilih Pegawai...</option>
                    @foreach($pegawais as $p)
                        <option value="{{ $p->id }}">{{ $p->user->name }} - {{ $p->jabatan }}</option>
                    @endforeach
                </select>
                @error('pegawai_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Barang / Aset</label>
                <select wire:model="barang_id" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                    <option value="">Pilih Aset...</option>
                    @foreach($barangs as $b)
                        <option value="{{ $b->id }}">{{ $b->nama_barang }} (Sisa: {{ $b->stok }})</option>
                    @endforeach
                </select>
                @error('barang_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Terima</label>
                <input type="date" wire:model="tanggal_terima" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                @error('tanggal_terima') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kondisi Awal</label>
                <select wire:model="kondisi_saat_terima" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Bekas Pakai">Bekas Pakai</option>
                </select>
            </div>

            <div class="lg:col-span-3">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Keterangan / Kelengkapan</label>
                <textarea wire:model="keterangan" class="w-full rounded-xl border-slate-200 font-bold text-slate-700" rows="2" placeholder="Contoh: Termasuk Charger & Tas Laptop"></textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50">Batal</button>
            <button wire:click="saveHandover" class="px-8 py-2.5 rounded-xl bg-blue-600 text-white font-bold shadow-lg hover:bg-blue-700">Serahkan Aset</button>
        </div>
    </div>
    @endif

    <!-- Data List -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex gap-4 overflow-x-auto">
            <button wire:click="$set('filterStatus', 'Dipakai')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $filterStatus == 'Dipakai' ? 'bg-blue-100 text-blue-700' : 'bg-slate-50 text-slate-500' }}">Sedang Dipakai</button>
            <button wire:click="$set('filterStatus', 'Dikembalikan')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $filterStatus == 'Dikembalikan' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-50 text-slate-500' }}">Riwayat Pengembalian</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Pegawai</th>
                        <th class="px-6 py-4">Aset</th>
                        <th class="px-6 py-4">Tanggal Terima</th>
                        <th class="px-6 py-4">Kondisi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($asets as $aset)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $aset->pegawai->user->name ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $aset->pegawai->jabatan ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-blue-600">{{ $aset->barang->nama_barang ?? '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $aset->keterangan }}</div>
                        </td>
                        <td class="px-6 py-4 font-mono text-slate-600">
                            {{ $aset->tanggal_terima->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-slate-100 rounded text-xs font-bold text-slate-600">{{ $aset->kondisi_saat_terima }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($aset->status == 'Dipakai')
                                <button wire:click="processReturn({{ $aset->id }})" wire:confirm="Proses pengembalian aset ini?" class="px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-lg text-xs font-bold transition-colors">
                                    Kembalikan
                                </button>
                            @else
                                <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Selesai ({{ $aset->tanggal_kembali ? $aset->tanggal_kembali->format('d/m/y') : '-' }})</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-slate-400 font-bold">Tidak ada data inventaris.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">
            {{ $asets->links() }}
        </div>
    </div>
</div>