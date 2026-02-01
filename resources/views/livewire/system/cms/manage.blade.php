<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-800">Manajemen Halaman Depan</h1>
            <p class="text-slate-500">Atur tampilan, konten, dan urutan website publik secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ url('/') }}" target="_blank" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                Lihat Website
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- LEFT: Section List -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="font-bold text-slate-700 uppercase text-xs tracking-wider">Urutan Tampilan</h3>
            </div>

            @foreach($sections as $section)
            <div class="group bg-white p-4 rounded-xl border transition-all duration-200 flex items-center gap-4 {{ $activeSectionId === $section->id ? 'border-indigo-500 shadow-md ring-1 ring-indigo-500/20' : 'border-slate-200 hover:border-slate-300' }}">
                
                <!-- Reorder Controls -->
                <div class="flex flex-col gap-1 text-slate-400">
                    <button wire:click="moveUp({{ $section->id }})" class="p-1 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors" title="Naik">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                    </button>
                    <button wire:click="moveDown({{ $section->id }})" class="p-1 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors" title="Turun">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 7" /></svg>
                    </button>
                </div>

                <!-- Info -->
                <div class="flex-1 cursor-pointer" wire:click="editSection({{ $section->id }})">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-wider {{ $section->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $section->section_key }}
                        </span>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm truncate">{{ $section->title }}</h4>
                    <p class="text-xs text-slate-500 truncate">{{ $section->subtitle ?? 'No subtitle' }}</p>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <!-- Toggle Switch -->
                    <button wire:click="toggleActive({{ $section->id }})" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none {{ $section->is_active ? 'bg-emerald-500' : 'bg-slate-200' }}" title="Toggle Visibility">
                        <span class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform {{ $section->is_active ? 'translate-x-5' : 'translate-x-1' }}"/>
                    </button>
                    
                    <!-- Edit Button -->
                    <button wire:click="editSection({{ $section->id }})" class="p-2 rounded-lg bg-slate-50 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- RIGHT: Editor -->
        <div class="lg:col-span-2">
            @if($activeSectionId)
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden animate-fade-in-up">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="font-black text-lg text-slate-800">Edit Seksi: <span class="text-indigo-600">{{ $sections->find($activeSectionId)->section_key }}</span></h3>
                    <button wire:click="$set('activeSectionId', null)" class="text-slate-400 hover:text-rose-500 text-xs font-bold uppercase">Tutup Editor</button>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Judul Utama</label>
                            <input wire:model="title" type="text" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-indigo-500 focus:border-indigo-500">
                            @error('title') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Sub-Judul / Label</label>
                            <input wire:model="subtitle" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi / Konten</label>
                            <textarea wire:model="content" rows="3" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                    </div>

                    <!-- Image Handling -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Gambar / Background</label>
                        <div class="flex items-center gap-6 p-4 bg-slate-50 rounded-xl border border-slate-100">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-lg shadow-sm">
                            @elseif ($existingImage)
                                <img src="{{ Storage::url($existingImage) }}" class="w-24 h-24 object-cover rounded-lg shadow-sm">
                            @else
                                <div class="w-24 h-24 bg-slate-200 rounded-lg flex items-center justify-center text-slate-400">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <input type="file" wire:model="image" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200"/>
                                <p class="text-[10px] text-slate-400 mt-2">Format: JPG, PNG, WEBP. Max: 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Metadata Fields based on Section Key -->
                    @php $key = $sections->find($activeSectionId)->section_key; @endphp
                    
                    @if($key === 'hero')
                    <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100 space-y-4">
                        <h4 class="text-xs font-black text-indigo-600 uppercase tracking-wide">Pengaturan Tombol (CTA)</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Teks Tombol Utama</label>
                                <input wire:model="metadata.cta_primary_text" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Link Tombol Utama</label>
                                <input wire:model="metadata.cta_primary_url" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Teks Tombol Sekunder</label>
                                <input wire:model="metadata.cta_secondary_text" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Link Tombol Sekunder</label>
                                <input wire:model="metadata.cta_secondary_url" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($key === 'why_us')
                    <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100 space-y-4">
                        <h4 class="text-xs font-black text-indigo-600 uppercase tracking-wide">Konten 3 Kartu Keunggulan</h4>
                        
                        <!-- Card 1 -->
                        <div class="border-b border-indigo-100 pb-3">
                            <span class="text-[10px] font-bold text-slate-400 block mb-2">Kartu #1</span>
                            <div class="grid grid-cols-1 gap-2">
                                <input wire:model="metadata.card_1_title" placeholder="Judul" type="text" class="w-full rounded-lg border-slate-200 text-xs font-bold">
                                <input wire:model="metadata.card_1_desc" placeholder="Deskripsi" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="border-b border-indigo-100 pb-3">
                            <span class="text-[10px] font-bold text-slate-400 block mb-2">Kartu #2</span>
                            <div class="grid grid-cols-1 gap-2">
                                <input wire:model="metadata.card_2_title" placeholder="Judul" type="text" class="w-full rounded-lg border-slate-200 text-xs font-bold">
                                <input wire:model="metadata.card_2_desc" placeholder="Deskripsi" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 block mb-2">Kartu #3</span>
                            <div class="grid grid-cols-1 gap-2">
                                <input wire:model="metadata.card_3_title" placeholder="Judul" type="text" class="w-full rounded-lg border-slate-200 text-xs font-bold">
                                <input wire:model="metadata.card_3_desc" placeholder="Deskripsi" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                        <button wire:click="$set('activeSectionId', null)" class="px-5 py-2.5 rounded-xl text-slate-500 font-bold hover:bg-slate-100 transition-colors">Batal</button>
                        <button wire:click="updateSection" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
            @else
            <div class="h-full min-h-[400px] flex flex-col items-center justify-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 text-center p-8">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Pilih Seksi untuk Diedit</h3>
                <p class="text-slate-500 max-w-sm mx-auto mt-2">Klik salah satu bagian di kolom sebelah kiri untuk mengubah konten, gambar, atau pengaturan lainnya.</p>
            </div>
            @endif
        </div>
    </div>
</div>
