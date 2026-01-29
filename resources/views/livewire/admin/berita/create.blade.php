<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form wire:submit="save" class="space-y-6">
            
            <!-- Judul -->
            <div class="space-y-1">
                <label for="judul" class="block text-sm font-bold text-slate-700">Judul Berita</label>
                <input wire:model="judul" type="text" id="judul" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all font-bold text-slate-800" placeholder="Masukkan judul berita menarik...">
                @error('judul') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kategori -->
                <div class="space-y-1">
                    <label for="kategori" class="block text-sm font-bold text-slate-700">Kategori</label>
                    <select wire:model="kategori" id="kategori" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all">
                        <option value="Umum">Umum</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Imunisasi">Imunisasi</option>
                        <option value="Tips Sehat">Tips Sehat</option>
                        <option value="Pengumuman">Pengumuman</option>
                        <option value="Kegiatan">Kegiatan</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="space-y-1">
                    <label for="status" class="block text-sm font-bold text-slate-700">Status Publikasi</label>
                    <select wire:model="status" id="status" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all">
                        <option value="published">Published (Tayang)</option>
                        <option value="draft">Draft (Simpan Sementara)</option>
                    </select>
                </div>
            </div>

            <!-- Konten -->
            <div class="space-y-1">
                <label for="konten" class="block text-sm font-bold text-slate-700">Isi Berita</label>
                <textarea wire:model="konten" id="konten" rows="10" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all text-sm leading-relaxed" placeholder="Tulis konten berita lengkap di sini..."></textarea>
                @error('konten') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Thumbnail -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-slate-700">Gambar Sampul (Thumbnail)</label>
                
                @if ($thumbnail)
                    <div class="relative w-full md:w-1/2 aspect-video rounded-xl overflow-hidden border border-slate-200 mb-4">
                        <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                            <p class="text-sm text-slate-500"><span class="font-bold text-blue-600">Klik untuk upload</span> atau drag and drop</p>
                            <p class="text-xs text-slate-400">PNG, JPG or GIF (MAX. 2MB)</p>
                        </div>
                        <input wire:model="thumbnail" id="dropzone-file" type="file" class="hidden" accept="image/*" />
                    </label>
                </div> 
                @error('thumbnail') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.berita.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-bold text-sm rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/20">
                    <svg wire:loading.remove class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    <svg wire:loading class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Publikasikan
                </button>
            </div>

        </form>
    </div>
</div>