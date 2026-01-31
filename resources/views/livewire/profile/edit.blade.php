<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Sidebar Profil & Navigasi -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                <div class="relative w-32 h-32 mx-auto mb-4 group mt-8">
                    @if ($new_foto_profil)
                        <img src="{{ $new_foto_profil->temporaryUrl() }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg bg-white">
                    @elseif ($foto_profil)
                        <img src="{{ Storage::url($foto_profil) }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg bg-white">
                    @else
                        <div class="w-full h-full rounded-full bg-white flex items-center justify-center text-indigo-500 text-4xl font-bold border-4 border-white shadow-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    
                    <label for="foto-upload" class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition transform hover:scale-110 border border-slate-200">
                        <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <input type="file" id="foto-upload" wire:model="new_foto_profil" class="hidden">
                    </label>
                </div>
                
                <h3 class="text-xl font-black text-slate-800">{{ Auth::user()->name }}</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $pegawai->jabatan ?? 'Pegawai' }}</p>
                <div class="mt-4 flex justify-center gap-2">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-indigo-100">{{ $pegawai->nip ?? 'NIP -' }}</span>
                </div>
            </div>

            <!-- Menu Navigasi (Visual Only for now, scrolling) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <nav class="flex flex-col">
                    <a href="#personal" class="px-6 py-4 border-b border-slate-50 hover:bg-slate-50 flex items-center gap-3 text-sm font-bold text-slate-700 transition-colors">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Informasi Pribadi
                    </a>
                    <a href="#documents" class="px-6 py-4 border-b border-slate-50 hover:bg-slate-50 flex items-center gap-3 text-sm font-bold text-slate-700 transition-colors">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Dokumen Digital
                    </a>
                    <a href="#security" class="px-6 py-4 hover:bg-slate-50 flex items-center gap-3 text-sm font-bold text-slate-700 transition-colors">
                        <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Keamanan Akun
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:col-span-2 space-y-8">
            
            <!-- SECTION 1: PERSONAL INFO -->
            <div id="personal" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 scroll-mt-24">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-indigo-500 rounded-full"></span>
                        Informasi Pribadi
                    </h3>
                </div>
                
                <form wire:submit.prevent="updateProfileInformation" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" value="Nama Lengkap" />
                            <x-text-input wire:model="name" id="name" class="w-full mt-1 bg-slate-50 border-slate-200 focus:bg-white transition-all" />
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <x-input-label for="email" value="Email Kantor" />
                            <x-text-input wire:model="email" id="email" type="email" class="w-full mt-1 bg-slate-50 border-slate-200 focus:bg-white transition-all" />
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-input-label for="no_telepon" value="Nomor WhatsApp" />
                            <x-text-input wire:model="no_telepon" id="no_telepon" class="w-full mt-1 bg-slate-50 border-slate-200 focus:bg-white transition-all" placeholder="08..." />
                            @error('no_telepon') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="alamat" value="Alamat Domisili" />
                            <textarea wire:model="alamat" id="alamat" rows="2" class="w-full mt-1 border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-slate-50 focus:bg-white transition-all"></textarea>
                            @error('alamat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-dashed border-slate-200">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Kontak Darurat</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kontak_darurat_nama" value="Nama Kerabat" />
                                <x-text-input wire:model="kontak_darurat_nama" id="kontak_darurat_nama" class="w-full mt-1 bg-slate-50 border-slate-200" />
                            </div>
                            <div>
                                <x-input-label for="kontak_darurat_telp" value="Nomor Telepon" />
                                <x-text-input wire:model="kontak_darurat_telp" id="kontak_darurat_telp" class="w-full mt-1 bg-slate-50 border-slate-200" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 transition shadow-lg flex items-center gap-2">
                            <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- SECTION 2: DOCUMENTS -->
            <div id="documents" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 scroll-mt-24">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-black text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-emerald-500 rounded-full"></span>
                        Arsip Dokumen Digital
                    </h3>
                    <button onclick="document.getElementById('doc-upload-modal').showModal()" class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 hover:bg-emerald-100 transition-colors">
                        + Upload Dokumen
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Placeholder List (Nanti di-bind ke collection) -->
                    @if(isset($documents) && count($documents) > 0)
                        @foreach($documents as $doc)
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100 group hover:border-emerald-200 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-white rounded-lg border border-slate-100 text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">{{ $doc->nama_dokumen }}</h4>
                                    <p class="text-xs text-slate-500">{{ $doc->jenis_dokumen }} • Uploaded {{ $doc->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Lihat">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                                <button wire:click="deleteDocument({{ $doc->id }})" class="p-2 text-slate-400 hover:text-red-600 transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                            <p class="text-sm font-bold text-slate-400">Belum ada dokumen diunggah.</p>
                            <p class="text-xs text-slate-400 mt-1">Upload SK, Ijazah, atau Sertifikat Anda.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SECTION 3: SECURITY -->
            <div id="security" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 scroll-mt-24">
                <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-rose-500 rounded-full"></span>
                    Keamanan Akun
                </h3>

                <form wire:submit.prevent="updatePassword" class="space-y-6">
                    <div>
                        <x-input-label for="current_password" value="Password Saat Ini" />
                        <x-text-input wire:model="current_password" id="current_password" type="password" class="w-full mt-1 bg-slate-50 border-slate-200" />
                        @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="password" value="Password Baru" />
                            <x-text-input wire:model="password" id="password" type="password" class="w-full mt-1 bg-slate-50 border-slate-200" />
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                            <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" class="w-full mt-1 bg-slate-50 border-slate-200" />
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-50 hover:text-rose-600 transition shadow-sm flex items-center gap-2">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Upload Modal (Native Dialog) -->
    <dialog id="doc-upload-modal" class="rounded-2xl p-0 backdrop:bg-slate-900/50 open:animate-fade-in shadow-2xl w-full max-w-md">
        <div class="bg-white p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-black text-lg text-slate-800">Upload Dokumen</h3>
                <button onclick="this.closest('dialog').close()" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
            
            <form wire:submit.prevent="uploadDocument" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Jenis Dokumen</label>
                    <select wire:model="doc_type" class="w-full rounded-xl border-slate-200 text-sm font-bold text-slate-600 bg-slate-50 focus:bg-white">
                        <option value="">Pilih Jenis...</option>
                        <option value="KTP">KTP / Identitas</option>
                        <option value="Ijazah">Ijazah Pendidikan</option>
                        <option value="SK">SK Kepegawaian</option>
                        <option value="Sertifikat">Sertifikat Pelatihan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('doc_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nama Dokumen</label>
                    <input type="text" wire:model="doc_name" class="w-full rounded-xl border-slate-200 text-sm font-bold bg-slate-50 focus:bg-white" placeholder="Contoh: Ijazah S1 Teknik">
                    @error('doc_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">File (PDF/JPG, Max 2MB)</label>
                    <input type="file" wire:model="doc_file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all">
                    @error('doc_file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex justify-end gap-2">
                    <button type="button" onclick="this.closest('dialog').close()" class="px-4 py-2 text-xs font-bold text-slate-500 hover:bg-slate-50 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-500/30">
                        <span wire:loading.remove>Upload Sekarang</span>
                        <span wire:loading>Uploading...</span>
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</div>