<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Sidebar Profil -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 text-center">
                <div class="relative w-32 h-32 mx-auto mb-4 group">
                    @if ($new_foto_profil)
                        <img src="{{ $new_foto_profil->temporaryUrl() }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg">
                    @elseif ($foto_profil)
                        <img src="{{ Storage::url($foto_profil) }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <div class="w-full h-full rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 text-4xl font-bold border-4 border-white shadow-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    
                    <label for="foto-upload" class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition transform hover:scale-110">
                        <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <input type="file" id="foto-upload" wire:model="new_foto_profil" class="hidden">
                    </label>
                </div>
                
                <h3 class="text-xl font-bold text-slate-800">{{ Auth::user()->name }}</h3>
                <p class="text-sm text-slate-500">{{ Auth::user()->email }}</p>
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Jabatan</p>
                    <p class="text-sm font-bold text-indigo-600">{{ $pegawai->jabatan ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Informasi Akun & Pribadi -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Informasi Pribadi
                </h3>
                
                <form wire:submit.prevent="updateProfileInformation" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" value="Nama Lengkap" />
                            <x-text-input wire:model="name" id="name" class="w-full mt-1" />
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input wire:model="email" id="email" type="email" class="w-full mt-1" />
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-input-label for="no_telepon" value="Nomor Telepon / WA" />
                            <x-text-input wire:model="no_telepon" id="no_telepon" class="w-full mt-1" placeholder="08..." />
                            @error('no_telepon') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="alamat" value="Alamat Domisili" />
                            <textarea wire:model="alamat" id="alamat" rows="2" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            @error('alamat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-700 mb-4">Kontak Darurat</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kontak_darurat_nama" value="Nama Kontak" />
                                <x-text-input wire:model="kontak_darurat_nama" id="kontak_darurat_nama" class="w-full mt-1" />
                            </div>
                            <div>
                                <x-input-label for="kontak_darurat_telp" value="Nomor Telepon" />
                                <x-text-input wire:model="kontak_darurat_telp" id="kontak_darurat_telp" class="w-full mt-1" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 flex items-center gap-2">
                            <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <svg wire:loading class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Update Password -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Keamanan Akun
                </h3>

                <form wire:submit.prevent="updatePassword" class="space-y-6">
                    <div>
                        <x-input-label for="current_password" value="Password Saat Ini" />
                        <x-text-input wire:model="current_password" id="current_password" type="password" class="w-full mt-1" />
                        @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="password" value="Password Baru" />
                            <x-text-input wire:model="password" id="password" type="password" class="w-full mt-1" />
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />
                            <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" class="w-full mt-1" />
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg font-bold hover:bg-gray-900 transition flex items-center gap-2">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
