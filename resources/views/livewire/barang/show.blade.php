<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Detail Aset & Inventaris</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi lengkap, riwayat stok, dan pemeliharaan.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('barang.edit', $barang->id) }}" wire:navigate class="px-4 py-2 bg-yellow-500 text-white font-bold rounded-xl hover:bg-yellow-600 transition shadow-lg shadow-yellow-500/20 text-xs uppercase tracking-widest">
                Edit Data
            </a>
            <a href="{{ route('barang.index') }}" wire:navigate class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 transition text-xs uppercase tracking-widest">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info Utama -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 dark:bg-blue-900/20 rounded-bl-full -mr-8 -mt-8"></div>
                
                <div class="flex items-start gap-6 relative z-10">
                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-700 rounded-2xl flex items-center justify-center text-4xl font-black text-slate-300">
                        {{ substr($barang->nama_barang, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-black text-slate-900 dark:text-white">{{ $barang->nama_barang }}</h1>
                                <p class="text-sm font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $barang->kode_barang }}</p>
                            </div>
                            <span class="px-3 py-1 bg-{{ $barang->kondisi == 'Baik' ? 'green' : 'red' }}-100 text-{{ $barang->kondisi == 'Baik' ? 'green' : 'red' }}-800 text-xs font-black rounded-full uppercase tracking-widest">
                                {{ $barang->kondisi }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Kategori</p>
                                <p class="text-sm font-bold text-slate-700 dark:text-gray-300">{{ $barang->kategori->nama_kategori ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Merk / Brand</p>
                                <p class="text-sm font-bold text-slate-700 dark:text-gray-300">{{ $barang->merk ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Lokasi</p>
                                <p class="text-sm font-bold text-slate-700 dark:text-gray-300">{{ $barang->ruangan->nama_ruangan ?? $barang->lokasi_penyimpanan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Stok Saat Ini</p>
                                <p class="text-xl font-black text-blue-600">{{ $barang->stok }} <span class="text-xs text-slate-400 font-bold">{{ $barang->satuan }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Jejak Aset -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="font-black text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Jejak Aktivitas Aset
                </h3>

                <div class="relative border-l-2 border-slate-100 ml-3 space-y-8">
                    @forelse($timeline as $event)
                        <div class="relative pl-8">
                            <!-- Icon Dot -->
                            <div class="absolute -left-[11px] top-0 h-6 w-6 rounded-full border-2 border-white bg-{{ $event['color'] }}-100 flex items-center justify-center text-{{ $event['color'] }}-600">
                                @if($event['icon'] == 'archive-box')
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                @elseif($event['icon'] == 'wrench-screwdriver')
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                @elseif($event['icon'] == 'truck')
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" /></svg>
                                @elseif($event['icon'] == 'hand-raised')
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" /></svg>
                                @elseif($event['icon'] == 'clipboard-document-check')
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                                @endif
                            </div>

                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                                <div>
                                    <span class="text-xs font-black uppercase text-{{ $event['color'] }}-600 bg-{{ $event['color'] }}-50 px-2 py-0.5 rounded tracking-wider">
                                        {{ $event['type'] }}
                                    </span>
                                    <h4 class="text-sm font-bold text-slate-800 mt-1">{{ $event['description'] }}</h4>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $event['details'] }}</p>
                                    
                                    @if($event['type'] == 'Maintenance' && isset($event['original']->file_sertifikat))
                                        <a href="{{ Storage::url($event['original']->file_sertifikat) }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-[10px] font-bold text-blue-600 hover:underline">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                            Lihat Dokumen
                                        </a>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold text-slate-600">{{ \Carbon\Carbon::parse($event['date'])->translatedFormat('d M Y') }}</p>
                                    <p class="text-[10px] text-slate-400">Oleh: {{ $event['user'] }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-slate-400 text-sm">Belum ada riwayat aktivitas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Kanan: Form Transaksi Cepat & Detail Aset -->
        <div class="space-y-6">
            <!-- Form Stok Cepat -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 border-indigo-500 p-6">
                <h3 class="text-sm font-black text-indigo-600 uppercase tracking-widest mb-4">Catat Transaksi Stok</h3>
                
                <form wire:submit="saveTransaksi" class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-slate-500">Jenis</label>
                        <div class="grid grid-cols-2 gap-2 mt-1">
                            <button type="button" wire:click="$set('jenis_transaksi', 'Masuk')" class="px-3 py-2 rounded-lg text-xs font-bold border transition {{ $jenis_transaksi == 'Masuk' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-white border-slate-200 text-slate-500' }}">
                                Masuk (+)
                            </button>
                            <button type="button" wire:click="$set('jenis_transaksi', 'Keluar')" class="px-3 py-2 rounded-lg text-xs font-bold border transition {{ $jenis_transaksi == 'Keluar' ? 'bg-red-100 border-red-500 text-red-700' : 'bg-white border-slate-200 text-slate-500' }}">
                                Keluar (-)
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500">Jumlah</label>
                        <input type="number" wire:model="jumlah" class="w-full mt-1 border-slate-200 rounded-xl text-sm font-bold focus:ring-indigo-500 focus:border-indigo-500" placeholder="0">
                        <x-input-error :messages="$errors->get('jumlah')" class="mt-1" />
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500">Tanggal</label>
                        <input type="date" wire:model="tanggal_transaksi" class="w-full mt-1 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500">Keterangan</label>
                        <input type="text" wire:model="keterangan" class="w-full mt-1 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Pengadaan baru / Rusak">
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                        Simpan Transaksi
                    </button>
                </form>
            </div>

            @if($barang->is_asset)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Nilai Aset</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Harga Perolehan</span>
                        <span class="font-bold text-slate-800 dark:text-white">Rp {{ number_format($barang->harga_perolehan, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Masa Manfaat</span>
                        <span class="font-bold text-slate-800 dark:text-white">{{ $barang->masa_manfaat }} Tahun</span>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex justify-between">
                        <span class="text-slate-500 font-bold">Nilai Buku (Saat Ini)</span>
                        <span class="font-black text-blue-600">Rp {{ number_format($barang->nilai_buku, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>