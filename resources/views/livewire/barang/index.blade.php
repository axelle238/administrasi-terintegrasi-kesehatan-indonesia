<div class="space-y-6 animate-fade-in">
    <!-- Header & Actions -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Master Data Inventaris</h2>
            <p class="text-slate-500 font-medium">Pusat data aset tetap, alat kesehatan, dan barang habis pakai.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            @if($modeTampilan == 'aktif')
            <a href="{{ route('barang.print-labels-bulk') }}" class="px-5 py-3 bg-slate-100 text-slate-700 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                Cetak Label QR
            </a>
            <a href="{{ route('barang.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-bold text-sm hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/30 transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Registrasi Barang Baru
            </a>
            @endif
        </div>
    </div>

    <!-- Mode Switcher (Recycle Bin) -->
    <div class="flex gap-4 border-b border-slate-200">
        <button wire:click="gantiModeTampilan('aktif')" class="px-6 py-3 text-sm font-bold border-b-2 transition-colors {{ $modeTampilan == 'aktif' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            Data Aktif
        </button>
        <button wire:click="gantiModeTampilan('sampah')" class="px-6 py-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2 {{ $modeTampilan == 'sampah' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            Tong Sampah
            @if($jumlahSampah > 0)
                <span class="bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-[10px]">{{ $jumlahSampah }}</span>
            @endif
        </button>
    </div>

    <!-- Smart Filters -->
    <div class="bg-white p-2 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col lg:flex-row gap-2 mt-6">
        <!-- Search -->
        <div class="relative w-full lg:w-80">
            <input type="text" wire:model.live.debounce.300ms="cari" placeholder="Cari nama, kode, atau merk..." class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all">
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>

        <!-- Filter Groups -->
        <div class="flex flex-1 gap-2 overflow-x-auto pb-2 lg:pb-0 custom-scrollbar">
            <!-- Tipe Aset (Medis/Umum) -->
            <div class="flex bg-slate-50 p-1.5 rounded-2xl shrink-0">
                @foreach(['semua' => 'Semua', 'medis' => 'Medis (Alkes)', 'umum' => 'Non-Medis'] as $key => $label)
                <button wire:click="aturTipeAset('{{ $key }}')" 
                    class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all {{ $tipeAset === $key ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                    {{ $label }}
                </button>
                @endforeach
            </div>

            <!-- Jenis Barang (Aset/BHP) -->
            <div class="flex bg-slate-50 p-1.5 rounded-2xl shrink-0">
                @foreach(['semua' => 'Semua', 'aset_tetap' => 'Aset Tetap', 'habis_pakai' => 'Habis Pakai'] as $key => $label)
                <button wire:click="aturJenisBarang('{{ $key }}')" 
                    class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all {{ $jenisBarang === $key ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                    {{ $label }}
                </button>
                @endforeach
            </div>

            <select wire:model.live="filterKategori" class="bg-slate-50 border-none rounded-2xl text-xs font-bold text-slate-600 py-2 pl-4 pr-10 cursor-pointer focus:ring-2 focus:ring-blue-500 min-w-[150px]">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
        <!-- Trash Mode Indicator -->
        @if($modeTampilan == 'sampah')
        <div class="absolute top-0 left-0 right-0 h-1 bg-red-500 z-10"></div>
        <div class="bg-red-50 px-6 py-3 text-red-700 text-xs font-bold flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            MODE TONG SAMPAH - Data di sini telah dihapus sementara.
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/50 text-slate-400 font-black uppercase tracking-widest text-[10px]">
                    <tr>
                        <th class="px-8 py-5">Identitas Barang</th>
                        <th class="px-8 py-5">Klasifikasi</th>
                        <th class="px-8 py-5 text-center">Stok & Satuan</th>
                        <th class="px-8 py-5">Lokasi</th>
                        <th class="px-8 py-5 text-center">Kondisi</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($barangs as $barang)
                    <tr class="group hover:bg-slate-50/80 transition-all duration-200">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center p-1 overflow-hidden shadow-sm group-hover:scale-110 transition-transform">
                                    @if($barang->gambar)
                                        <img src="{{ Storage::url($barang->gambar) }}" class="w-full h-full object-cover rounded-xl">
                                    @else
                                        <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-black text-slate-800 text-sm group-hover:text-blue-600 transition-colors">{{ $barang->nama_barang }}</div>
                                    <div class="text-[10px] font-mono text-slate-400 mt-0.5 bg-slate-100 px-1.5 py-0.5 rounded-md inline-block">{{ $barang->kode_barang }}</div>
                                    @if($barang->merk)
                                        <span class="text-[10px] text-slate-500 font-bold ml-1">• {{ $barang->merk }}</span>
                                    @endif
                                    
                                    @if($modeTampilan == 'sampah')
                                        <p class="text-[9px] text-red-400 mt-1">Dihapus: {{ $barang->deleted_at->diffForHumans() }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] font-black uppercase tracking-wider {{ $barang->jenis_aset == 'Medis' ? 'text-rose-600' : 'text-slate-600' }}">
                                    {{ $barang->jenis_aset }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-lg w-fit">
                                    {{ $barang->kategori->nama_kategori ?? '-' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="inline-flex flex-col items-center">
                                <span class="text-lg font-black {{ $barang->stok <= ($barang->min_stok ?? 5) ? 'text-rose-600' : 'text-slate-800' }}">
                                    {{ $barang->stok }}
                                </span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase">{{ $barang->satuan }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                {{ $barang->ruangan->nama_ruangan ?? $barang->lokasi_penyimpanan ?? '-' }}
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @php
                                $kondisiClass = match($barang->kondisi) {
                                    'Baik' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'Rusak Ringan' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'Rusak Berat' => 'bg-rose-100 text-rose-700 border-rose-200',
                                    default => 'bg-slate-100 text-slate-600 border-slate-200'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider border {{ $kondisiClass }}">
                                {{ $barang->kondisi }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if($modeTampilan == 'aktif')
                                    <!-- Aksi Data Aktif -->
                                    <a href="{{ route('barang.show', $barang->id) }}" class="p-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm group/btn" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <a href="{{ route('barang.edit', $barang->id) }}" class="p-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm" title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <button wire:click="buangKeSampah({{ $barang->id }})" wire:confirm="Pindahkan aset ini ke tong sampah?" class="p-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-red-500 hover:text-white transition-all shadow-sm" title="Hapus Sementara">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                @else
                                    <!-- Aksi Tong Sampah -->
                                    <button wire:click="pulihkan({{ $barang->id }})" class="p-2 bg-green-50 text-green-600 rounded-xl hover:bg-green-600 hover:text-white transition-all shadow-sm" title="Pulihkan Data">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                    </button>
                                    <button wire:click="hapusPermanen({{ $barang->id }})" wire:confirm="PERINGATAN: Aset ini akan dihapus permanen dan tidak bisa dikembalikan. Lanjutkan?" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Hapus Permanen">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                </div>
                                <p class="text-slate-500 font-bold text-sm">Data tidak ditemukan.</p>
                                @if($modeTampilan == 'sampah')
                                    <p class="text-slate-400 text-xs mt-1">Tong sampah kosong.</p>
                                @else
                                    <p class="text-slate-400 text-xs mt-1">Coba ubah filter atau kata kunci pencarian.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 border-t border-slate-50">
            {{ $barangs->links() }}
        </div>
    </div>
</div>
