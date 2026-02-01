<div class="space-y-8 animate-fade-in">
    
    <!-- Header -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Manajemen Halaman Depan</h2>
            <p class="text-sm text-slate-500 mt-1">Atur konten, urutan, dan tampilan website publik secara dinamis.</p>
        </div>
        <div class="flex gap-2">
            <button wire:click="setTab('general')" class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all {{ $activeTab === 'general' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">Pengaturan Umum</button>
            <button wire:click="setTab('sections')" class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider transition-all {{ $activeTab === 'sections' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">Seksi & Konten</button>
        </div>
    </div>

    @if($activeTab === 'general')
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-200 p-8 relative overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <h3 class="font-black text-lg text-slate-800 mb-4 border-b border-slate-100 pb-2">Identitas Aplikasi</h3>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Aplikasi</label>
                <input wire:model="app_name" type="text" class="w-full rounded-xl border-slate-200 text-sm font-bold">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tagline</label>
                <input wire:model="app_tagline" type="text" class="w-full rounded-xl border-slate-200 text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi Meta (SEO)</label>
                <textarea wire:model="app_description" rows="3" class="w-full rounded-xl border-slate-200 text-sm"></textarea>
            </div>
            
            <div class="md:col-span-2 mt-4">
                <h3 class="font-black text-lg text-slate-800 mb-4 border-b border-slate-100 pb-2">Kontak & Footer</h3>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Email Resmi</label>
                <input wire:model="app_email" type="email" class="w-full rounded-xl border-slate-200 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">No. Telepon / Hotline</label>
                <input wire:model="app_phone" type="text" class="w-full rounded-xl border-slate-200 text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Alamat Lengkap</label>
                <input wire:model="app_address" type="text" class="w-full rounded-xl border-slate-200 text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Teks Footer</label>
                <input wire:model="footer_text" type="text" class="w-full rounded-xl border-slate-200 text-sm">
            </div>
            
            <div class="md:col-span-2 pt-6 border-t border-slate-100 flex justify-end">
                <button wire:click="saveGeneral" class="px-8 py-3 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg hover:bg-emerald-700 transition-all">Simpan Pengaturan</button>
            </div>
        </div>
    </div>
    @endif

    @if($activeTab === 'sections')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: List & Order -->
        <div class="space-y-4">
            @foreach($sections as $section)
            <div class="bg-white p-4 rounded-2xl border {{ $editingSectionId === $section->id ? 'border-indigo-500 ring-2 ring-indigo-500/20' : 'border-slate-200' }} shadow-sm flex items-center gap-4 group transition-all">
                <div class="flex flex-col gap-1">
                    <button wire:click="moveUp({{ $section->id }})" class="p-1 rounded hover:bg-slate-100 text-slate-400 hover:text-indigo-600 disabled:opacity-30"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg></button>
                    <button wire:click="moveDown({{ $section->id }})" class="p-1 rounded hover:bg-slate-100 text-slate-400 hover:text-indigo-600 disabled:opacity-30"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 7" /></svg></button>
                </div>
                
                <div class="flex-1 cursor-pointer" wire:click="editSection({{ $section->id }})">
                    <h4 class="font-bold text-slate-800 text-sm">{{ ucfirst(str_replace('_', ' ', $section->section_key)) }}</h4>
                    <p class="text-[10px] text-slate-500 truncate">{{ $section->title }}</p>
                </div>

                <div class="flex items-center gap-2">
                    <button wire:click="toggleSection({{ $section->id }})" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none {{ $section->is_active ? 'bg-emerald-500' : 'bg-slate-200' }}">
                        <span class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform {{ $section->is_active ? 'translate-x-5' : 'translate-x-1' }}"/>
                    </button>
                    <button wire:click="editSection({{ $section->id }})" class="p-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Right: Editor -->
        <div class="lg:col-span-2">
            @if($editingSectionId)
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-indigo-100 p-8 relative overflow-hidden animate-fade-in-up">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                
                <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                    <h3 class="font-black text-xl text-slate-800">Edit Seksi</h3>
                    <button wire:click="resetSectionEditor" class="text-slate-400 hover:text-rose-500 transition-colors"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Judul Utama</label>
                        <input wire:model="section_title" type="text" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Sub-Judul / Label</label>
                        <input wire:model="section_subtitle" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi / Konten</label>
                        <textarea wire:model="section_content" rows="4" class="w-full rounded-xl border-slate-200 text-sm focus:ring-indigo-500"></textarea>
                    </div>

                    <!-- Dynamic Metadata based on Section Key -->
                    @php $key = LandingComponent::find($editingSectionId)->section_key; @endphp
                    
                    @if($key === 'hero')
                    <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Teks Tombol Utama</label>
                            <input wire:model="section_metadata.cta_primary_text" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">URL Tombol Utama</label>
                            <input wire:model="section_metadata.cta_primary_url" type="text" class="w-full rounded-lg border-slate-200 text-xs">
                        </div>
                    </div>
                    @endif

                    @if($key === 'why_us')
                    <div class="space-y-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <label class="block text-xs font-bold text-slate-500 uppercase">Poin Keunggulan (3 Kolom)</label>
                        
                        <!-- Card 1 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pb-4 border-b border-slate-200">
                            <span class="md:col-span-2 text-[10px] font-black text-indigo-400 uppercase tracking-widest">Kartu 1</span>
                            <div>
                                <input wire:model="section_metadata.card_1_title" type="text" placeholder="Judul Kartu 1" class="w-full rounded-lg border-slate-200 text-xs font-bold">
                            </div>
                            <div>
                                <input wire:model="section_metadata.card_1_desc" type="text" placeholder="Deskripsi Singkat" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pb-4 border-b border-slate-200">
                            <span class="md:col-span-2 text-[10px] font-black text-purple-400 uppercase tracking-widest">Kartu 2</span>
                            <div>
                                <input wire:model="section_metadata.card_2_title" type="text" placeholder="Judul Kartu 2" class="w-full rounded-lg border-slate-200 text-xs font-bold">
                            </div>
                            <div>
                                <input wire:model="section_metadata.card_2_desc" type="text" placeholder="Deskripsi Singkat" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <span class="md:col-span-2 text-[10px] font-black text-emerald-400 uppercase tracking-widest">Kartu 3</span>
                            <div>
                                <input wire:model="section_metadata.card_3_title" type="text" placeholder="Judul Kartu 3" class="w-full rounded-lg border-slate-200 text-xs font-bold">
                            </div>
                            <div>
                                <input wire:model="section_metadata.card_3_desc" type="text" placeholder="Deskripsi Singkat" class="w-full rounded-lg border-slate-200 text-xs">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Gambar / Ilustrasi</label>
                        <div class="flex items-center gap-6">
                            @if ($section_image)
                                <img src="{{ $section_image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-xl shadow-md">
                            @elseif ($current_section_image)
                                <img src="{{ asset('storage/'.$current_section_image) }}" class="w-32 h-32 object-cover rounded-xl shadow-md">
                            @else
                                <div class="w-32 h-32 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-xs text-center p-2 border-2 border-dashed border-slate-300">No Image</div>
                            @endif
                            
                            <div class="flex-1">
                                <input type="file" wire:model="section_image" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                                <p class="text-[10px] text-slate-400 mt-2">Format: JPG, PNG, WEBP. Max: 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex justify-end">
                        <button wire:click="updateSection" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
            @else
            <div class="h-full min-h-[400px] flex flex-col items-center justify-center bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200 text-slate-400">
                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                <p class="font-bold">Pilih seksi di sebelah kiri untuk mengedit konten.</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>