<div class="max-w-5xl mx-auto space-y-6 animate-fade-in">
    <!-- Header Info -->
    <div class="bg-blue-600 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl">
        <div class="absolute right-0 top-0 opacity-10 p-4">
            <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
        </div>
        <h2 class="text-3xl font-black relative z-10">Registrasi Aset Baru</h2>
        <p class="text-blue-100 relative z-10 mt-2 max-w-xl">
            Lengkapi formulir di bawah ini untuk mendaftarkan aset baru. Sistem akan otomatis mendeteksi kebutuhan data spesifik (Medis/Non-Medis) berdasarkan kategori yang dipilih.
        </p>
    </div>

    <!-- Main Form -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <form wire:submit.prevent="save" class="p-8 space-y-8">
            
            <!-- Section 1: Identitas Barang -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold">1</div>
                    <h3 class="text-lg font-bold text-slate-800">Identitas & Klasifikasi</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Upload Foto (New Feature) -->
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Galeri Foto Aset (Upload Multiple)</label>
                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 transition relative"
                             x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            
                            <input type="file" wire:model="photos" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            
                            <div class="space-y-2" x-show="!isUploading">
                                <svg class="w-10 h-10 text-slate-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-sm font-bold text-slate-600">Klik atau Drag foto ke sini</p>
                                <p class="text-xs text-slate-400">Bisa upload banyak foto sekaligus (Max 2MB/foto)</p>
                            </div>

                            <!-- Progress Bar -->
                            <div x-show="isUploading">
                                <div class="w-full bg-slate-200 rounded-full h-2.5 mb-2">
                                    <div class="bg-blue-600 h-2.5 rounded-full" :style="'width: ' + progress + '%'"></div>
                                </div>
                                <p class="text-xs text-blue-600 font-bold">Mengupload...</p>
                            </div>
                        </div>

                        <!-- Preview Grid -->
                        @if($photos)
                        <div class="grid grid-cols-4 md:grid-cols-6 gap-4 mt-4">
                            @foreach($photos as $photo)
                            <div class="relative group aspect-square rounded-lg overflow-hidden border border-slate-200">
                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    <span class="text-white text-xs font-bold">New</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @error('photos.*') <span class="text-xs text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kategori (Trigger) -->
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kategori Aset <span class="text-red-500">*</span></label>
                        <select wire:model.live="kategori_barang_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_barang_id') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                        
                        @if($is_medis)
                            <div class="mt-2 flex items-center gap-2 text-emerald-600 bg-emerald-50 px-3 py-2 rounded-lg text-xs font-bold w-fit animate-fade-in-up">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Terdeteksi sebagai Aset Medis. Form detail tambahan diaktifkan.
                            </div>
                        @endif
                    </div>

                    <!-- Kode Barang -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kode Barang <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="kode_barang" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-mono text-slate-600">
                        @error('kode_barang') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nama Barang -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nama_barang" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl" placeholder="Contoh: USG 4 Dimensi">
                        @error('nama_barang') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Merk -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Merk / Brand</label>
                        <input type="text" wire:model="merk" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl" placeholder="Contoh: GE Healthcare">
                    </div>

                    <!-- Stok & Satuan -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                            <input type="number" wire:model="stok" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                            @error('stok') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="satuan" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl" placeholder="Unit, Pcs, Set">
                            @error('satuan') <span class="text-xs text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Detail Aset Medis (Conditional) -->
            @if($is_medis)
            <div class="space-y-6 bg-emerald-50/50 p-6 rounded-3xl border border-emerald-100 animate-fade-in">
                <div class="flex items-center gap-3 pb-2 border-b border-emerald-200">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">2</div>
                    <h3 class="text-lg font-bold text-emerald-800">Spesifikasi Medis & Regulasi</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Izin Edar -->
                    <div>
                        <label class="block text-sm font-bold text-emerald-800 mb-2">Nomor Izin Edar (AKL/AKD)</label>
                        <input type="text" wire:model="nomor_izin_edar" class="w-full px-4 py-3 bg-white border border-emerald-200 rounded-xl focus:ring-2 focus:ring-emerald-500" placeholder="KEMENKES RI AKL...">
                    </div>

                    <!-- Distributor -->
                    <div>
                        <label class="block text-sm font-bold text-emerald-800 mb-2">Distributor Resmi</label>
                        <input type="text" wire:model="distributor_resmi" class="w-full px-4 py-3 bg-white border border-emerald-200 rounded-xl">
                    </div>

                    <!-- Kalibrasi -->
                    <div>
                        <label class="block text-sm font-bold text-emerald-800 mb-2">Frekuensi Kalibrasi (Bulan)</label>
                        <input type="number" wire:model="frekuensi_kalibrasi_bulan" class="w-full px-4 py-3 bg-white border border-emerald-200 rounded-xl" placeholder="Contoh: 12">
                        <p class="text-[10px] text-emerald-600 mt-1">Isi 0 jika tidak perlu kalibrasi.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-emerald-800 mb-2">Kalibrasi Terakhir</label>
                        <input type="date" wire:model="kalibrasi_terakhir" class="w-full px-4 py-3 bg-white border border-emerald-200 rounded-xl">
                    </div>

                    <!-- Suhu -->
                    <div>
                        <label class="block text-sm font-bold text-emerald-800 mb-2">Suhu Penyimpanan</label>
                        <input type="text" wire:model="suhu_penyimpanan" class="w-full px-4 py-3 bg-white border border-emerald-200 rounded-xl" placeholder="Contoh: 2-8 °C">
                    </div>
                </div>
            </div>
            @endif

            <!-- Section 3: Keuangan & Lokasi -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 pb-2 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold">{{ $is_medis ? '3' : '2' }}</div>
                    <h3 class="text-lg font-bold text-slate-800">Nilai Aset & Penempatan</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Harga Perolehan (Rp)</label>
                        <input type="number" wire:model.live="harga_perolehan" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl" placeholder="0">
                    </div>

                    <!-- Sumber Dana -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Sumber Dana</label>
                        <select wire:model="sumber_dana" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <option value="">-- Pilih Sumber --</option>
                            <option value="APBD">APBD</option>
                            <option value="APBN">APBN</option>
                            <option value="BLUD">BLUD</option>
                            <option value="Hibah">Hibah</option>
                        </select>
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Penempatan</label>
                        <select wire:model="ruangan_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangans as $r)
                                <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Supplier -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Supplier / Vendor</label>
                        <select wire:model="supplier_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 4: Jaminan & Garansi -->
            <div class="bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100 animate-fade-in">
                <div class="flex items-center gap-3 pb-2 border-b border-indigo-200">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">4</div>
                    <h3 class="text-lg font-bold text-indigo-900">Jaminan Purna Jual</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                    <div>
                        <label class="block text-sm font-bold text-indigo-900 mb-2">Penanggung Garansi / Principal</label>
                        <input type="text" wire:model="penanggung_garansi" class="w-full px-4 py-3 bg-white border border-indigo-200 rounded-xl" placeholder="Nama Perusahaan...">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-indigo-900 mb-2">Nomor Kontrak Servis / Kartu Garansi</label>
                        <input type="text" wire:model="nomor_kontrak_servis" class="w-full px-4 py-3 bg-white border border-indigo-200 rounded-xl">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-indigo-900 mb-2">Mulai Garansi</label>
                            <input type="date" wire:model="garansi_mulai" class="w-full px-4 py-3 bg-white border border-indigo-200 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-indigo-900 mb-2">Habis Garansi</label>
                            <input type="date" wire:model="garansi_selesai" class="w-full px-4 py-3 bg-white border border-indigo-200 rounded-xl">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-indigo-900 mb-2">Cakupan Garansi</label>
                        <select wire:model="cakupan_garansi" class="w-full px-4 py-3 bg-white border border-indigo-200 rounded-xl">
                            <option value="">-- Pilih Cakupan --</option>
                            <option value="Full Cover">Full Cover (Sparepart & Jasa)</option>
                            <option value="Service Only">Jasa Servis Saja</option>
                            <option value="Sparepart Only">Sparepart Saja</option>
                            <option value="Limited">Terbatas (Limited)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="{{ route('barang.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30 flex items-center gap-2">
                    <div wire:loading wire:target="save" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></div>
                    Simpan Data Aset
                </button>
            </div>
        </form>
    </div>
</div>
