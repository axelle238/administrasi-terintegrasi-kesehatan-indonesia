<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Sirkulasi Peminjaman</h2>
            <p class="text-sm text-slate-500">Monitoring peminjaman inventaris kantor dan alat medis.</p>
        </div>
        <button wire:click="$toggle('isModalOpen')" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Catat Peminjaman
        </button>
    </div>

    <!-- Create Modal (Inline) -->
    <div x-show="$wire.isModalOpen" x-transition class="bg-white p-8 rounded-[2.5rem] shadow-lg border border-blue-100 mb-8">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Form Peminjaman Baru</h3>
        <form wire:submit.prevent="store" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Barang -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Barang</label>
                    <select wire:model="barang_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}">{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                        @endforeach
                    </select>
                    @error('barang_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Peminjam -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pegawai Peminjam</label>
                    <select wire:model="pegawai_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($pegawais as $p)
                            <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->user->name ?? 'Tanpa Nama' }}</option>
                        @endforeach
                    </select>
                    @error('pegawai_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pinjam</label>
                    <input type="date" wire:model="tanggal_pinjam" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                    @error('tanggal_pinjam') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Rencana Kembali</label>
                    <input type="date" wire:model="tanggal_kembali_rencana" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Kondisi Saat Keluar</label>
                <textarea wire:model="kondisi_keluar" rows="2" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl" placeholder="Contoh: Baik, Lecet sedikit..."></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" wire:click="$set('isModalOpen', false)" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>

    <!-- Return Modal (Inline) -->
    <div x-show="$wire.isReturnModalOpen" x-transition class="bg-amber-50 p-8 rounded-[2.5rem] shadow-lg border border-amber-100 mb-8">
        <h3 class="text-xl font-bold text-amber-800 mb-6">Form Pengembalian Barang</h3>
        <form wire:submit.prevent="processReturn" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-amber-800 mb-2">Tanggal Kembali Realisasi</label>
                    <input type="date" wire:model="tanggal_kembali_realisasi" class="w-full px-4 py-3 bg-white border border-amber-200 rounded-xl">
                    @error('tanggal_kembali_realisasi') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-amber-800 mb-2">Kondisi Akhir</label>
                    <input type="text" wire:model="kondisi_kembali" class="w-full px-4 py-3 bg-white border border-amber-200 rounded-xl" placeholder="Baik / Rusak">
                    @error('kondisi_kembali') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" wire:click="$set('isReturnModalOpen', false)" class="px-6 py-3 bg-white text-slate-600 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-6 py-3 bg-amber-600 text-white rounded-xl font-bold hover:bg-amber-700">Proses Pengembalian</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between gap-4 items-center">
            <div class="relative w-full md:w-64">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari No Transaksi..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            
            <div class="flex gap-2">
                <select wire:model.live="filterStatus" class="bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-600 py-2 pl-4 pr-8 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="Dipinjam">Sedang Dipinjam</option>
                    <option value="Dikembalikan">Sudah Kembali</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-bold">No Transaksi</th>
                        <th class="px-6 py-4 font-bold">Peminjam</th>
                        <th class="px-6 py-4 font-bold">Barang</th>
                        <th class="px-6 py-4 font-bold">Tgl Pinjam</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($peminjaman as $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-slate-600 font-bold">{{ $p->no_transaksi }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $p->pegawai->user->name ?? '-' }}</div>
                            <div class="text-xs text-slate-400">{{ $p->pegawai->nip ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $p->barang->nama_barang ?? '-' }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y') }}
                            @if($p->tanggal_kembali_rencana)
                                <br><span class="text-[10px] text-slate-400">Exp: {{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d/m/Y') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($p->status == 'Dipinjam')
                                <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs font-bold">Dipinjam</span>
                            @else
                                <span class="px-2 py-1 rounded bg-emerald-100 text-emerald-700 text-xs font-bold">Dikembalikan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->status == 'Dipinjam')
                                <button wire:click="openReturnModal({{ $p->id }})" class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg hover:bg-amber-100 transition-colors">
                                    Kembalikan
                                </button>
                            @else
                                <span class="text-slate-300">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $peminjaman->links() }}
        </div>
    </div>
</div>