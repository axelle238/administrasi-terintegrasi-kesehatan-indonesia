<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 pb-20">
    
    <!-- Page Header & Breadcrumb -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editor Aset Digital
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Pembaruan data inventaris, spesifikasi teknis, dan galeri foto aset.
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('barang.show', $barang->id) }}" wire:navigate class="px-4 py-2 bg-white border border-gray-300 rounded-xl font-bold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" form="editForm" wire:loading.attr="disabled" class="px-6 py-2 bg-amber-500 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-amber-600 transition shadow-lg shadow-amber-500/30 flex items-center gap-2">
                <span wire:loading.remove>Simpan Perubahan</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        </div>
    </div>

    <form id="editForm" wire:submit="update" class="space-y-8">
        
        <!-- SECTION 1: IDENTITAS & FISIK -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Main Identity -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs">1</span>
                            Identitas Barang
                        </h3>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="is_asset" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-bold text-gray-700">Aset Tetap</span>
                        </label>
                    </div>
                    
                    <div class="p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                                <select wire:model.live="kategori_barang_id" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-amber-500">
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Kode Aset</label>
                                <input type="text" wire:model="kode_barang" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl font-mono">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Barang</label>
                            <input type="text" wire:model="nama_barang" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl text-lg font-bold">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Merk / Brand</label>
                                <input type="text" wire:model="merk" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Seri (SN)</label>
                                <input type="text" wire:model="nomor_seri" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl">
                            </div>
                        </div>

                        @if($is_asset)
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Spesifikasi Detail</label>
                            <textarea wire:model="spesifikasi" rows="3" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl"></textarea>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Medical Section -->
                @if($is_medis)
                <div class="bg-white rounded-[2rem] shadow-sm border border-emerald-100 overflow-hidden animate-fade-in">
                    <div class="px-8 py-6 border-b border-emerald-100 bg-emerald-50/50">
                        <h3 class="text-lg font-black text-emerald-800 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">2</span>
                            Data Medis & Regulasi
                        </h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-emerald-800 mb-2">Nomor Izin Edar</label>
                            <input type="text" wire:model="nomor_izin_edar" class="w-full px-4 py-3 bg-white border-emerald-200 rounded-xl focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-emerald-800 mb-2">Distributor</label>
                            <input type="text" wire:model="distributor_resmi" class="w-full px-4 py-3 bg-white border-emerald-200 rounded-xl focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-emerald-800 mb-2">Frekuensi Kalibrasi (Bulan)</label>
                            <input type="number" wire:model="frekuensi_kalibrasi_bulan" class="w-full px-4 py-3 bg-white border-emerald-200 rounded-xl focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-emerald-800 mb-2">Kalibrasi Terakhir</label>
                            <input type="date" wire:model="kalibrasi_terakhir" class="w-full px-4 py-3 bg-white border-emerald-200 rounded-xl focus:ring-emerald-500">
                        </div>
                    </div>
                </div>
                @endif

                <!-- Gallery Section (NEW) -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">3</span>
                            Galeri Foto Aset
                        </h3>
                    </div>
                    
                    <div class="p-8 space-y-6">
                        <!-- Existing Photos -->
                        @if(count($existingPhotos) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($existingPhotos as $photo)
                            <div class="group relative aspect-square rounded-xl overflow-hidden border border-slate-200">
                                <img src="{{ Storage::url($photo->image_path) }}" class="w-full h-full object-cover">
                                
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                                    @if(!$photo->is_primary)
                                        <button type="button" wire:click="setPrimaryImage({{ $photo->id }})" class="px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-full hover:bg-blue-700">Jadikan Utama</button>
                                        <button type="button" wire:click="deleteImage({{ $photo->id }})" wire:confirm="Hapus foto ini?" class="px-3 py-1 bg-red-600 text-white text-[10px] font-bold rounded-full hover:bg-red-700">Hapus</button>
                                    @else
                                        <span class="px-3 py-1 bg-green-500 text-white text-[10px] font-bold rounded-full">Foto Utama</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Upload Area -->
                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:bg-slate-50 transition relative"
                             x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            
                            <input type="file" wire:model="newPhotos" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            
                            <div class="space-y-2" x-show="!isUploading">
                                <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="font-bold text-slate-600">Tambah Foto Baru</p>
                                <p class="text-xs text-slate-400">Klik atau Drag foto ke sini</p>
                            </div>

                            <div x-show="isUploading" class="space-y-2">
                                <div class="w-full bg-slate-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                                </div>
                                <p class="text-xs text-indigo-600 font-bold">Mengupload...</p>
                            </div>
                        </div>

                        <!-- Preview New Photos -->
                        @if($newPhotos)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($newPhotos as $photo)
                            <div class="aspect-square rounded-xl overflow-hidden border border-indigo-200 relative">
                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                <div class="absolute top-1 right-1 w-3 h-3 bg-green-500 rounded-full border border-white"></div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Panel: Side Settings -->
            <div class="space-y-6">
                <!-- Location & Status -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 space-y-6">
                    <h4 class="font-bold text-gray-800 border-b border-gray-100 pb-2">Status & Lokasi</h4>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Penempatan</label>
                        <select wire:model="ruangan_id" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl">
                            @foreach($ruangans as $r)
                                <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kondisi Fisik</label>
                        <select wire:model="kondisi" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl">
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ketersediaan</label>
                        <select wire:model="status_ketersediaan" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Dipinjam">Dipinjam</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Dihapuskan">Dihapuskan</option>
                        </select>
                    </div>
                </div>

                <!-- Financials -->
                @if($is_asset)
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 space-y-6">
                    <h4 class="font-bold text-gray-800 border-b border-gray-100 pb-2">Keuangan</h4>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Harga Perolehan</label>
                        <input type="number" wire:model="harga_perolehan" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nilai Residu</label>
                        <input type="number" wire:model="nilai_residu" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Masa Manfaat (Tahun)</label>
                        <input type="number" wire:model="masa_manfaat" class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>