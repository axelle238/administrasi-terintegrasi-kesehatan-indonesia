<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800 font-display">Pendaftaran Pasien Baru</h2>
            <p class="text-sm text-slate-500">Isi formulir lengkap untuk mendaftarkan pasien manual.</p>
        </div>
        <a href="{{ route('pasien.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
    </div>

    <!-- Form Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Pencarian BPJS -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-600/20 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                
                <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    Cek Kepesertaan BPJS
                </h3>
                
                <div class="space-y-4 relative z-10">
                    <div>
                        <label class="text-xs font-bold text-blue-100 uppercase tracking-wider mb-1 block">Nomor Kartu BPJS / NIK</label>
                        <input type="text" wire:model="no_bpjs" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white placeholder-blue-200 focus:outline-none focus:bg-white/20 focus:border-white transition-colors" placeholder="0000000000000">
                    </div>
                    
                    <button wire:click="checkBpjs" wire:loading.attr="disabled" class="w-full py-3 bg-white text-blue-600 rounded-xl font-bold hover:bg-blue-50 transition-colors flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="checkBpjs">Cek Data Peserta</span>
                        <span wire:loading wire:target="checkBpjs">
                            <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                    </button>
                </div>

                <!-- Hasil Cek -->
                @if($bpjsStatus)
                <div class="mt-6 pt-6 border-t border-white/20 animate-fade-in">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            @if($bpjsStatus == 'active') <span class="text-emerald-300 text-lg">✔</span>
                            @elseif($bpjsStatus == 'inactive') <span class="text-red-300 text-lg">✖</span>
                            @else <span class="text-yellow-300 text-lg">!</span> @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold leading-tight">{{ $bpjsMessage }}</p>
                            @if($is_prb)
                                <span class="inline-block mt-2 px-2 py-1 bg-yellow-500 text-white text-[10px] font-bold rounded uppercase">Peserta PRB</span>
                                <p class="text-xs mt-1 text-blue-100">{{ $catatan_prb }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Info Tambahan -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h4 class="font-bold text-slate-800 mb-2">Catatan Penting</h4>
                <ul class="list-disc list-inside text-sm text-slate-500 space-y-1">
                    <li>Pastikan NIK terdiri dari 16 digit.</li>
                    <li>Data bertanda (*) wajib diisi.</li>
                    <li>Jika pasien darurat, isi data seminimal mungkin dan lengkapi kemudian.</li>
                </ul>
            </div>
        </div>

        <!-- Kolom Kanan: Form Data -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <form wire:submit.prevent="save" class="space-y-6">
                
                <!-- Identitas Utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-sm font-bold text-slate-700">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nik" class="form-input w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500" maxlength="16">
                        @error('nik') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-bold text-slate-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nama_lengkap" class="form-input w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 uppercase">
                        @error('nama_lengkap') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-bold text-slate-700">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="tempat_lahir" class="form-input w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 uppercase">
                        @error('tempat_lahir') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-bold text-slate-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" wire:model="tanggal_lahir" class="form-input w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                        @error('tanggal_lahir') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-bold text-slate-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select wire:model="jenis_kelamin" class="form-select w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih...</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-sm font-bold text-slate-700">Golongan Darah</label>
                        <select wire:model="golongan_darah" class="form-select w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tidak Tahu</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                </div>

                <!-- Kontak & Alamat -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Kontak & Alamat</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-sm font-bold text-slate-700">Nomor Telepon / HP <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="no_telepon" class="form-input w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500" placeholder="08...">
                            @error('no_telepon') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1 md:col-span-2">
                            <label class="text-sm font-bold text-slate-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea wire:model="alamat" rows="3" class="form-textarea w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan..."></textarea>
                            @error('alamat') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Medis Tambahan -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Penjamin & Faskes</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="space-y-1">
                            <label class="text-sm font-bold text-slate-700">Jenis Penjamin / Asuransi <span class="text-red-500">*</span></label>
                            <select wire:model="asuransi" class="form-select w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="Umum">Umum / Mandiri</option>
                                <option value="BPJS">BPJS Kesehatan</option>
                                <option value="Asuransi Lain">Asuransi Lainnya</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-bold text-slate-700">Faskes Tingkat 1 (Asal)</label>
                            <input type="text" wire:model="faskes_asal" class="form-input w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: Puskesmas Sukamaju">
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="pt-8 flex items-center justify-end gap-4 border-t border-slate-100">
                    <button type="button" onclick="history.back()" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/30 transition-all transform hover:-translate-y-0.5">
                        Simpan Data Pasien
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>