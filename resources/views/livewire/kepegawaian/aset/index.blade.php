<div class="space-y-8 animate-fade-in">
    <!-- Header & Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Aset Dipinjamkan</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $asets->total() }} <span class="text-sm text-slate-400 font-medium">Unit</span></h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            </div>
        </div>
        
        <div class="md:col-span-2 bg-gradient-to-r from-slate-800 to-slate-900 p-6 rounded-[2rem] text-white shadow-lg flex items-center justify-between relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="font-black text-xl mb-2">Manajemen Inventaris Pegawai</h3>
                <p class="text-slate-400 text-sm max-w-md">Kelola serah terima fasilitas kantor (Laptop, Kendaraan, Alat Kerja) kepada pegawai secara transparan.</p>
            </div>
            <div class="relative z-10 flex gap-3">
                <button wire:click="openHandover" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all shadow-lg shadow-blue-600/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Serah Terima Baru
                </button>
            </div>
            <!-- Decor -->
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-10 -mt-10"></div>
        </div>
    </div>

    <!-- Handover Form (Toggle) -->
    @if($isHandoverOpen)
    <div class="bg-white p-8 rounded-[2.5rem] shadow-lg border border-blue-100 animate-fade-in-up relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-400"></div>
        
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-black text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg></span>
                Form Serah Terima Aset
            </h3>
            <button wire:click="cancel" class="text-slate-400 hover:text-rose-500 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form wire:submit="saveHandover">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Pegawai -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Penerima (Pegawai)</label>
                    <select wire:model="pegawai_id" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-700 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($pegawais as $p)
                            <option value="{{ $p->id }}">{{ $p->user->name }} ({{ $p->nip }})</option>
                        @endforeach
                    </select>
                    @error('pegawai_id') <span class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Barang -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Barang / Aset</label>
                    <select wire:model="barang_id" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-700 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}">{{ $b->nama_barang }} (Stok: {{ $b->stok }})</option>
                        @endforeach
                    </select>
                    @error('barang_id') <span class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Terima</label>
                    <input wire:model="tanggal_terima" type="date" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-700 focus:ring-blue-500 focus:border-blue-500">
                    @error('tanggal_terima') <span class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Kondisi -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kondisi Saat Terima</label>
                    <select wire:model="kondisi_saat_terima" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-700 focus:ring-blue-500 focus:border-blue-500">
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Bekas Pakai">Bekas Pakai</option>
                    </select>
                </div>

                <!-- Keterangan -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Keterangan Tambahan</label>
                    <textarea wire:model="keterangan" rows="2" class="w-full rounded-xl border-slate-200 text-sm font-medium text-slate-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Nomor seri, kelengkapan, dll..."></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                <button type="button" wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs hover:bg-slate-50 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold uppercase text-xs shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-colors">Simpan & Serahkan</button>
            </div>
        </form>
    </div>
    @endif

    <!-- Data List -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <!-- Toolbar -->
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between gap-4 items-center">
            <div class="flex items-center gap-4">
                <button wire:click="$set('filterStatus', 'Dipakai')" class="px-4 py-2 rounded-xl text-xs font-bold uppercase transition-colors {{ $filterStatus == 'Dipakai' ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-700' }}">Sedang Dipakai</button>
                <button wire:click="$set('filterStatus', 'Dikembalikan')" class="px-4 py-2 rounded-xl text-xs font-bold uppercase transition-colors {{ $filterStatus == 'Dikembalikan' ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-700' }}">Riwayat Kembali</button>
            </div>
            
            <div class="relative w-full md:w-64">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari aset atau pegawai..." class="w-full pl-10 pr-4 py-2 rounded-xl border-slate-200 text-sm font-medium focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Barang / Aset</th>
                        <th class="px-6 py-4">Peminjam</th>
                        <th class="px-6 py-4">Tanggal Terima</th>
                        <th class="px-6 py-4">Kondisi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($asets as $aset)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs shrink-0">
                                    {{ substr($aset->barang->nama_barang ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $aset->barang->nama_barang ?? 'Deleted Item' }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase font-bold">{{ $aset->barang->kode_barang ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @if($aset->pegawai->foto_profil ?? false)
                                    <img src="{{ Storage::url($aset->pegawai->foto_profil) }}" class="w-6 h-6 rounded-full object-cover">
                                @else
                                    <div class="w-6 h-6 rounded-full bg-slate-200"></div>
                                @endif
                                <span class="font-bold text-slate-700">{{ $aset->pegawai->user->name ?? 'Deleted User' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-600">
                            {{ $aset->tanggal_terima ? $aset->tanggal_terima->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-[10px] font-black uppercase {{ $aset->kondisi_saat_terima == 'Baik' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                {{ $aset->kondisi_saat_terima }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($aset->status == 'Dipakai')
                            <button wire:click="processReturn({{ $aset->id }})" 
                                    onclick="return confirm('Konfirmasi pengembalian aset ini?') || event.stopImmediatePropagation()"
                                    class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 text-xs font-bold uppercase hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-colors">
                                Kembalikan
                            </button>
                            @else
                            <span class="text-[10px] font-bold text-slate-400 uppercase">
                                Dikembalikan: {{ $aset->tanggal_kembali ? $aset->tanggal_kembali->format('d/m/y') : '-' }}
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">
                            Tidak ada data aset ditemukan.
                        </td>
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