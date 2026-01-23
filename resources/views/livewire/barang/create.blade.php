<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
    
    <!-- Page Header & Breadcrumb -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tambah Aset Baru
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Isi formulir di bawah ini untuk mendaftarkan aset atau barang inventaris baru ke dalam sistem SATRIA.
            </p>
        </div>
        <a href="{{ route('barang.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <form wire:submit="save" class="space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Panel: Identitas Barang -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Identitas Barang</h3>
                        </div>
                        
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="is_asset" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900">Aset Tetap?</span>
                        </label>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Kategori & Kode -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kategori_barang_id" value="Kategori Barang" class="mb-2" />
                                <div class="relative">
                                    <select wire:model="kategori_barang_id" id="kategori_barang_id" class="appearance-none w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block p-3 pr-8 transition duration-150 ease-in-out hover:bg-white" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('kategori_barang_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="kode_barang" value="Kode Barang / Barcode" class="mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h-4v-4H8m13-4V4a1 1 0 00-1-1H4a1 1 0 00-1 1v12a1 1 0 001 1h3m10-3a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2a1 1 0 01-1-1v-4z" />
                                        </svg>
                                    </div>
                                    <x-text-input wire:model="kode_barang" id="kode_barang" class="pl-10 block w-full bg-gray-50 focus:bg-white transition-colors" type="text" placeholder="Auto-generated or Manual" required />
                                </div>
                                <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Nama Barang -->
                        <div>
                            <x-input-label for="nama_barang" value="Nama Barang" class="mb-2" />
                            <x-text-input wire:model="nama_barang" id="nama_barang" class="block w-full text-lg font-medium" type="text" placeholder="Contoh: Kursi Roda Standard, Stetoskop, Laptop Dell..." required />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <!-- Merk & Spesifikasi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="merk" value="Merk / Brand" class="mb-2" />
                                <x-text-input wire:model="merk" id="merk" class="block w-full" type="text" placeholder="Contoh: Yamaha, Samsung, OneMed" />
                                <x-input-error :messages="$errors->get('merk')" class="mt-2" />
                            </div>
                            
                            <div>
                                <x-input-label for="nomor_seri" value="Nomor Seri / SN" class="mb-2" />
                                <x-text-input wire:model="nomor_seri" id="nomor_seri" class="block w-full" type="text" placeholder="SN12345678" />
                                <x-input-error :messages="$errors->get('nomor_seri')" class="mt-2" />
                            </div>
                        </div>

                        @if($is_asset)
                        <div class="grid grid-cols-1 gap-6" x-transition>
                             <div>
                                <x-input-label for="spesifikasi" value="Spesifikasi Detail" class="mb-2" />
                                <textarea wire:model="spesifikasi" id="spesifikasi" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" rows="3" placeholder="Warna, Ukuran, Bahan, Processor, RAM, dll."></textarea>
                                <x-input-error :messages="$errors->get('spesifikasi')" class="mt-2" />
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Lokasi & Fisik -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                         <div class="p-2 bg-purple-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Lokasi & Kondisi</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="ruangan_id" value="Lokasi Ruangan" class="mb-2" />
                             <div class="relative">
                                <select wire:model="ruangan_id" id="ruangan_id" class="appearance-none w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block p-3 pr-8 transition duration-150 ease-in-out hover:bg-white">
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('ruangan_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="kondisi" value="Kondisi Saat Ini" class="mb-2" />
                            <div class="grid grid-cols-3 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="kondisi" value="Baik" class="peer sr-only">
                                    <div class="text-center p-3 rounded-lg border border-gray-200 peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:text-green-700 hover:bg-gray-50 transition-all">
                                        <span class="block text-sm font-semibold">Baik</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="kondisi" value="Rusak Ringan" class="peer sr-only">
                                    <div class="text-center p-3 rounded-lg border border-gray-200 peer-checked:bg-yellow-50 peer-checked:border-yellow-500 peer-checked:text-yellow-700 hover:bg-gray-50 transition-all">
                                        <span class="block text-sm font-semibold">R. Ringan</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="kondisi" value="Rusak Berat" class="peer sr-only">
                                    <div class="text-center p-3 rounded-lg border border-gray-200 peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-700 hover:bg-gray-50 transition-all">
                                        <span class="block text-sm font-semibold">R. Berat</span>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Asset Financials (If Is Asset) -->
                @if($is_asset)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-transition>
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                         <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Nilai Aset</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="sumber_dana" value="Sumber Dana" class="mb-2" />
                            <select wire:model="sumber_dana" id="sumber_dana" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                <option value="">-- Pilih Sumber --</option>
                                <option value="APBD">APBD</option>
                                <option value="BLUD">BLUD</option>
                                <option value="DAK">DAK</option>
                                <option value="Hibah">Hibah</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="harga_perolehan" value="Harga Perolehan (Rp)" class="mb-2" />
                            <x-text-input wire:model.live="harga_perolehan" id="harga_perolehan" class="block w-full" type="number" min="0" placeholder="0" />
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Panel: Stok & Pengadaan -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-8">
                     <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Stok & Pengadaan</h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <div>
                            <x-input-label for="stok" value="Jumlah Stok Awal" class="mb-2" />
                            <div class="flex items-center">
                                <button type="button" onclick="document.getElementById('stok').stepDown()" class="p-3 bg-gray-100 rounded-l-lg hover:bg-gray-200 border border-r-0 border-gray-300">
                                    -
                                </button>
                                <input wire:model="stok" id="stok" type="number" min="0" class="text-center w-full border-gray-300 border-x-0 focus:ring-teal-500 focus:border-teal-500" required>
                                <button type="button" onclick="document.getElementById('stok').stepUp()" class="p-3 bg-gray-100 rounded-r-lg hover:bg-gray-200 border border-l-0 border-gray-300">
                                    +
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="satuan" value="Satuan Unit" class="mb-2" />
                            <x-text-input wire:model="satuan" id="satuan" class="block w-full" type="text" placeholder="Pcs, Unit, Box, Lembar..." required />
                            <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="supplier_id" value="Supplier / Vendor" class="mb-2" />
                            <select wire:model="supplier_id" id="supplier_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->nama_supplier }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal_pengadaan" value="Tanggal Perolehan" class="mb-2" />
                            <x-text-input wire:model="tanggal_pengadaan" id="tanggal_pengadaan" class="block w-full" type="date" required />
                            <x-input-error :messages="$errors->get('tanggal_pengadaan')" class="mt-2" />
                        </div>
                        
                        <div class="pt-4 border-t border-gray-100">
                            <x-primary-button class="w-full justify-center py-3 text-base bg-teal-600 hover:bg-teal-700 active:bg-teal-800 focus:ring-teal-500" wire:loading.attr="disabled">
                                <span wire:loading.remove>Simpan Data Barang</span>
                                <span wire:loading class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Menyimpan...
                                </span>
                            </x-primary-button>
                            
                            <a href="{{ route('barang.index') }}" wire:navigate class="mt-3 block w-full text-center py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                Batalkan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>