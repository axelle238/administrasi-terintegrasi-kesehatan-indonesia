<div class="space-y-6 animate-fade-in">
    
    <!-- Tab Navigation -->
    <div class="bg-white p-2 rounded-[2rem] border border-slate-100 shadow-sm inline-flex">
        <button wire:click="setTab('general')" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ $activeTab === 'general' ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-500 hover:text-slate-800' }}">
            Identitas & Tema
        </button>
        <button wire:click="setTab('sections')" class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ $activeTab === 'sections' ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-500 hover:text-slate-800' }}">
            Konten Halaman
        </button>
    </div>

    <!-- 1. GENERAL SETTINGS -->
    @if($activeTab === 'general')
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm animate-fade-in-up">
        <h3 class="text-lg font-black text-slate-800 mb-6">Konfigurasi Identitas Sistem</h3>
        
        <form wire:submit="saveGeneral">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Aplikasi</label>
                    <input wire:model="app_name" type="text" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-slate-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tagline</label>
                    <input wire:model="app_tagline" type="text" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-slate-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Deskripsi Meta</label>
                    <textarea wire:model="app_description" rows="2" class="w-full rounded-xl border-slate-200 text-sm focus:ring-slate-500"></textarea>
                </div>
                
                <!-- Color Theme -->
                <div class="md:col-span-2 border-t border-dashed border-slate-200 pt-6">
                    <h4 class="text-sm font-black text-slate-800 mb-4">Warna Tema Utama</h4>
                    <div class="flex gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="primary_color" value="#10b981" class="peer sr-only">
                            <div class="w-12 h-12 rounded-full bg-emerald-500 border-4 border-transparent peer-checked:border-slate-800 transition-all shadow-lg ring-2 ring-transparent peer-checked:ring-emerald-200"></div>
                            <span class="block text-[10px] text-center mt-1 font-bold text-emerald-600">Emerald</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="primary_color" value="#0ea5e9" class="peer sr-only">
                            <div class="w-12 h-12 rounded-full bg-sky-500 border-4 border-transparent peer-checked:border-slate-800 transition-all shadow-lg ring-2 ring-transparent peer-checked:ring-sky-200"></div>
                            <span class="block text-[10px] text-center mt-1 font-bold text-sky-600">Sky</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="primary_color" value="#6366f1" class="peer sr-only">
                            <div class="w-12 h-12 rounded-full bg-indigo-500 border-4 border-transparent peer-checked:border-slate-800 transition-all shadow-lg ring-2 ring-transparent peer-checked:ring-indigo-200"></div>
                            <span class="block text-[10px] text-center mt-1 font-bold text-indigo-600">Indigo</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="primary_color" value="#f43f5e" class="peer sr-only">
                            <div class="w-12 h-12 rounded-full bg-rose-500 border-4 border-transparent peer-checked:border-slate-800 transition-all shadow-lg ring-2 ring-transparent peer-checked:ring-rose-200"></div>
                            <span class="block text-[10px] text-center mt-1 font-bold text-rose-600">Rose</span>
                        </label>
                    </div>
                </div>

                <!-- Contact -->
                <div class="md:col-span-2 border-t border-dashed border-slate-200 pt-6 grid md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email Kontak</label>
                        <input wire:model="app_email" type="email" class="w-full rounded-xl border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">No. Telepon</label>
                        <input wire:model="app_phone" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Teks Footer</label>
                        <input wire:model="footer_text" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Alamat Fisik</label>
                        <input wire:model="app_address" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-8 py-3 bg-slate-800 text-white rounded-xl text-sm font-bold uppercase tracking-wider hover:bg-slate-900 shadow-lg transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- 2. SECTION EDITOR -->
    @if($activeTab === 'sections')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up">
        
        <!-- List Sections -->
        <div class="space-y-4">
            @foreach($sections as $sec)
            <div class="bg-white p-4 rounded-2xl border {{ $editingSectionId === $sec->id ? 'border-slate-800 ring-2 ring-slate-200' : 'border-slate-100' }} shadow-sm hover:shadow-md transition-all cursor-pointer" wire:click="editSection({{ $sec->id }})">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Bagian: {{ $sec->section_key }}</span>
                    <div class="flex items-center gap-2">
                        <button wire:click.stop="toggleSection({{ $sec->id }})" class="w-8 h-4 rounded-full {{ $sec->is_active ? 'bg-emerald-500' : 'bg-slate-200' }} relative transition-colors">
                            <span class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform {{ $sec->is_active ? 'translate-x-4' : '' }}"></span>
                        </button>
                    </div>
                </div>
                <h4 class="font-bold text-slate-800">{{ $sec->title ?? 'Tanpa Judul' }}</h4>
                <p class="text-xs text-slate-500 line-clamp-1 mt-1">{{ $sec->subtitle ?? '-' }}</p>
            </div>
            @endforeach
        </div>

        <!-- Editor Form -->
        <div class="lg:col-span-2">
            @if($editingSectionId)
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-lg sticky top-24">
                <h3 class="text-lg font-black text-slate-800 mb-6">Edit Konten: {{ $sections->find($editingSectionId)->section_key }}</h3>
                
                <form wire:submit="updateSection">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Judul Utama (Heading)</label>
                            <input wire:model="section_title" type="text" class="w-full rounded-xl border-slate-200 text-lg font-bold text-slate-800 focus:ring-slate-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sub-Judul (Subtitle)</label>
                            <input wire:model="section_subtitle" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-slate-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Konten / Deskripsi</label>
                            <textarea wire:model="section_content" rows="4" class="w-full rounded-xl border-slate-200 text-sm focus:ring-slate-500"></textarea>
                        </div>
                        
                        <!-- Metadata Fields (Dynamic based on key) -->
                        @if(isset($section_metadata) && count($section_metadata) > 0)
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <p class="text-xs font-black text-slate-400 uppercase mb-3">Metadata Tambahan</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($section_metadata as $key => $val)
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">{{ str_replace('_', ' ', $key) }}</label>
                                    <input wire:model="section_metadata.{{ $key }}" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Gambar Latar / Ilustrasi</label>
                            @if($current_section_image)
                                <img src="{{ Storage::url($current_section_image) }}" class="h-32 rounded-xl object-cover mb-2 border border-slate-200">
                            @endif
                            <input wire:model="section_image" type="file" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                        <button type="button" wire:click="resetSectionEditor" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs hover:bg-slate-50">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold uppercase text-xs shadow-lg hover:bg-emerald-700">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
            @else
            <div class="flex flex-col items-center justify-center h-64 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200 text-slate-400">
                <svg class="w-12 h-12 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                <p class="font-bold">Pilih bagian di sebelah kiri untuk mengedit.</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
