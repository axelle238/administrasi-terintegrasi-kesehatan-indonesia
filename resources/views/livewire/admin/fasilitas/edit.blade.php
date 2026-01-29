<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form wire:submit="save" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Fasilitas -->
                <div class="space-y-1">
                    <label for="nama_fasilitas" class="block text-sm font-bold text-slate-700">Nama Fasilitas</label>
                    <input wire:model="nama_fasilitas" type="text" id="nama_fasilitas" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all font-bold text-slate-800">
                    @error('nama_fasilitas') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis -->
                <div class="space-y-1">
                    <label for="jenis" class="block text-sm font-bold text-slate-700">Jenis Fasilitas</label>
                    <select wire:model="jenis" id="jenis" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all">
                        <option value="medis">Medis</option>
                        <option value="non-medis">Non-Medis (Umum)</option>
                        <option value="unggulan">Layanan Unggulan</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="space-y-1">
                <label for="deskripsi" class="block text-sm font-bold text-slate-700">Deskripsi Singkat</label>
                <textarea wire:model="deskripsi" id="deskripsi" rows="4" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all text-sm leading-relaxed"></textarea>
                @error('deskripsi') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div class="flex items-center gap-3">
                <input wire:model="is_active" type="checkbox" id="is_active" class="rounded text-blue-600 focus:ring-blue-500 border-gray-300 shadow-sm h-5 w-5">
                <label for="is_active" class="text-sm font-bold text-slate-700 select-none cursor-pointer">Tampilkan di Halaman Depan</label>
            </div>

            <!-- Gambar -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700">Gambar Fasilitas</label>
                
                @if ($gambar)
                    <div class="relative w-full md:w-1/2 aspect-video rounded-xl overflow-hidden border border-slate-200 mb-4">
                        <img src="{{ $gambar->temporaryUrl() }}" class="w-full h-full object-cover">
                    </div>
                @elseif($oldGambar)
                    <div class="relative w-full md:w-1/2 aspect-video rounded-xl overflow-hidden border border-slate-200 mb-4">
                        <img src="{{ asset('storage/' . $oldGambar) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white text-xs font-bold opacity-0 hover:opacity-100 transition-opacity">
                            Gambar Saat Ini
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                            <p class="text-sm text-slate-500"><span class="font-bold text-blue-600">Klik untuk ganti</span></p>
                        </div>
                        <input wire:model="gambar" id="dropzone-file" type="file" class="hidden" accept="image/*" />
                    </label>
                </div> 
                @error('gambar') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.fasilitas.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/20">
                    <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>