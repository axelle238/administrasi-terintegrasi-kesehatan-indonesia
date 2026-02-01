<div class="space-y-8 animate-fade-in">
    <!-- Header with Action -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-4 bg-white p-6 rounded-[2rem] shadow-sm border border-emerald-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Manajemen Alur Pelayanan</h2>
            <p class="text-sm text-slate-500 mt-1">Sistem manajemen alur layanan terpadu (v2.0 Enterprise).</p>
        </div>
        @if(!$isFormOpen)
        <button wire:click="create" class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-all flex items-center gap-2 transform hover:-translate-y-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Langkah Baru
        </button>
        @endif
    </div>

    <!-- Form Section (Tabbed Interface, No Modal) -->
    @if($isFormOpen)
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-emerald-200 relative overflow-hidden ring-4 ring-emerald-50/50">
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-400 via-teal-500 to-cyan-500"></div>
        
        <div class="p-8">
            <div class="flex justify-between items-center mb-6 pb-6 border-b border-slate-100">
                <h3 class="text-xl font-black text-slate-800 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    {{ $alurId ? 'Edit Data Langkah' : 'Buat Langkah Baru' }}
                </h3>
                <button wire:click="cancel" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Tabs Navigation -->
            <div class="flex gap-2 border-b border-slate-100 mb-6 overflow-x-auto no-scrollbar pb-1">
                <button wire:click="setTabForm('general')" class="px-4 py-2 rounded-t-lg text-sm font-bold border-b-2 transition-colors {{ $activeTabForm === 'general' ? 'border-emerald-500 text-emerald-600 bg-emerald-50/50' : 'border-transparent text-slate-500 hover:text-emerald-500' }}">Informasi Utama</button>
                <button wire:click="setTabForm('details')" class="px-4 py-2 rounded-t-lg text-sm font-bold border-b-2 transition-colors {{ $activeTabForm === 'details' ? 'border-emerald-500 text-emerald-600 bg-emerald-50/50' : 'border-transparent text-slate-500 hover:text-emerald-500' }}">Detail Operasional</button>
                <button wire:click="setTabForm('media')" class="px-4 py-2 rounded-t-lg text-sm font-bold border-b-2 transition-colors {{ $activeTabForm === 'media' ? 'border-emerald-500 text-emerald-600 bg-emerald-50/50' : 'border-transparent text-slate-500 hover:text-emerald-500' }}">Multimedia & Dokumen</button>
                <button wire:click="setTabForm('advanced')" class="px-4 py-2 rounded-t-lg text-sm font-bold border-b-2 transition-colors {{ $activeTabForm === 'advanced' ? 'border-emerald-500 text-emerald-600 bg-emerald-50/50' : 'border-transparent text-slate-500 hover:text-emerald-500' }}">FAQ & Advanced</button>
            </div>

            <!-- Tab Content: General -->
            @if($activeTabForm === 'general')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kategori Layanan</label>
                    <select wire:model="jenis_pelayanan_id" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 py-3 bg-slate-50 focus:bg-white transition-colors">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($jenisPelayanans as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Judul Langkah</label>
                    <input wire:model="judul" type="text" placeholder="Contoh: Pendaftaran Loket" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 py-3">
                    @error('judul') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Urutan Tampil</label>
                    <input wire:model="urutan" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 focus:border-emerald-500 py-3 text-center">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi Lengkap</label>
                    <textarea wire:model="deskripsi" rows="4" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 p-4" placeholder="Jelaskan detail prosedur di langkah ini..."></textarea>
                </div>
            </div>
            @endif

            <!-- Tab Content: Details -->
            @if($activeTabForm === 'details')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Mode Layanan</label>
                    <select wire:model="tipe_alur" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500">
                        <option value="Offline">Offline (Tatap Muka)</option>
                        <option value="Online">Online (Daring)</option>
                        <option value="Hybrid">Hybrid (Campuran)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Target Pasien</label>
                    <select wire:model="target_pasien" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500">
                        <option value="Umum">Umum (Semua)</option>
                        <option value="BPJS">Pasien BPJS</option>
                        <option value="Umum/Tunai">Pasien Umum/Tunai</option>
                        <option value="Baru">Pasien Baru</option>
                        <option value="Lama">Pasien Lama</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Estimasi Waktu</label>
                    <input wire:model="estimasi_waktu" type="text" placeholder="10-15 Menit" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jam Operasional (Opsional)</label>
                    <input wire:model="jam_operasional" type="text" placeholder="08:00 - 14:00" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Lokasi / Ruangan</label>
                    <input wire:model="lokasi" type="text" placeholder="Gedung A, Lt. 1" class="w-full rounded-xl border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Penanggung Jawab</label>
                    <input wire:model="penanggung_jawab" type="text" placeholder="Petugas Admisi" class="w-full rounded-xl border-slate-200 text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Dokumen Persyaratan</label>
                    <input wire:model="dokumen_syarat" type="text" placeholder="KTP, Kartu BPJS (Pisahkan dengan koma)" class="w-full rounded-xl border-slate-200 text-sm">
                </div>
            </div>
            @endif

            <!-- Tab Content: Media -->
            @if($activeTabForm === 'media')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in">
                <!-- Image -->
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-center">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Foto Ilustrasi</label>
                    @if ($gambar)
                        <img src="{{ $gambar->temporaryUrl() }}" class="w-full h-40 object-cover rounded-xl mb-3 shadow-md">
                    @elseif ($existingGambar)
                        <img src="{{ asset('storage/'.$existingGambar) }}" class="w-full h-40 object-cover rounded-xl mb-3 shadow-md">
                    @else
                        <div class="w-full h-40 bg-white rounded-xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center mb-3">
                            <span class="text-slate-400 text-xs">Belum ada foto</span>
                        </div>
                    @endif
                    <input type="file" wire:model="gambar" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"/>
                </div>

                <!-- Document -->
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Template Dokumen (Download)</label>
                    <input type="file" wire:model="file_template" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                    @if($existingFileTemplate)
                        <div class="mt-2 text-xs flex items-center gap-2 text-emerald-600 font-bold bg-white p-2 rounded border border-slate-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            File Tersedia
                        </div>
                    @endif
                    <p class="text-[10px] text-slate-400 mt-1">PDF, Docx, Xlsx (Max 5MB)</p>
                </div>

                <!-- Video -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Link Video (YouTube Embed)</label>
                    <input wire:model="video_url" type="text" placeholder="https://www.youtube.com/embed/..." class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500">
                </div>

                <!-- Action Link -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Link Aksi (CTA)</label>
                    <div class="flex gap-2">
                        <input wire:model="action_label" type="text" placeholder="Label (e.g. Daftar)" class="w-1/3 rounded-xl border-slate-200 text-sm focus:ring-emerald-500">
                        <input wire:model="action_url" type="text" placeholder="URL Tujuan" class="w-2/3 rounded-xl border-slate-200 text-sm focus:ring-emerald-500">
                    </div>
                </div>
                
                <!-- Icon -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Icon (Heroicon)</label>
                    <input wire:model="icon" type="text" class="w-full rounded-xl border-slate-200 text-sm font-mono">
                </div>
            </div>
            @endif

            <!-- Tab Content: Advanced -->
            @if($activeTabForm === 'advanced')
            <div class="space-y-6 animate-fade-in">
                <!-- Tags -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kata Kunci (Tags)</label>
                    <input wire:model="tagsInput" type="text" placeholder="BPJS, Lansia, Prioritas (Pisahkan dengan koma)" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500">
                    <p class="text-[10px] text-slate-400 mt-1">Digunakan untuk fitur pencarian cerdas.</p>
                </div>

                <!-- Internal Notes -->
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Catatan Internal (Admin Only)</label>
                    <textarea wire:model="internal_notes" rows="2" class="w-full rounded-xl border-slate-200 text-sm bg-yellow-50 focus:ring-yellow-500 focus:border-yellow-500" placeholder="Catatan khusus untuk staf admin..."></textarea>
                </div>

                <!-- FAQ Repeater -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/60">
                    <div class="flex justify-between items-center mb-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase">FAQ (Tanya Jawab)</label>
                        <button wire:click="addFaq" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg> Tambah
                        </button>
                    </div>
                    <div class="space-y-3">
                        @foreach($faqs as $index => $faq)
                        <div class="flex gap-3 items-start animate-fade-in-up">
                            <div class="flex-1 space-y-2">
                                <input wire:model="faqs.{{ $index }}.q" type="text" placeholder="Pertanyaan (Q)" class="w-full rounded-lg border-slate-200 text-xs font-bold focus:border-emerald-500 focus:ring-emerald-500">
                                <input wire:model="faqs.{{ $index }}.a" type="text" placeholder="Jawaban (A)" class="w-full rounded-lg border-slate-200 text-xs text-slate-600 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <button wire:click="removeFaq({{ $index }})" class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg mt-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Toggles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                    <label class="flex items-center justify-between cursor-pointer group p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="text-sm font-bold text-slate-700 group-hover:text-emerald-600">Status Aktif</span>
                        <input wire:model="is_active" type="checkbox" class="rounded text-emerald-600 focus:ring-emerald-500 w-5 h-5 border-slate-300">
                    </label>
                    <label class="flex items-center justify-between cursor-pointer group p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="text-sm font-bold text-slate-700 group-hover:text-rose-600">Langkah Kritis (Wajib)</span>
                        <input wire:model="is_critical" type="checkbox" class="rounded text-rose-600 focus:ring-rose-500 w-5 h-5 border-slate-300">
                    </label>
                </div>
            </div>
            @endif

            <!-- Footer Actions -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
                <button wire:click="cancel" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs tracking-wider hover:bg-slate-50 transition-colors">Batalkan</button>
                <button wire:click="store" class="px-8 py-3 rounded-xl bg-emerald-600 text-white font-bold uppercase text-xs tracking-wider shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- List Section -->
    @if(!$isFormOpen)
    <div class="relative pl-4 md:pl-8 border-l-2 border-slate-200 space-y-8 pb-12">
        @forelse($alurs as $alur)
        <div class="relative group animate-fade-in-up" style="animation-delay: {{ $loop->index * 100 }}ms">
            <!-- Dot Connector -->
            <div class="absolute -left-[25px] md:-left-[41px] top-6 flex flex-col items-center">
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-white border-4 {{ $alur->is_critical ? 'border-rose-200 text-rose-600' : 'border-emerald-100 text-emerald-600' }} flex items-center justify-center font-black shadow-sm group-hover:scale-110 transition-all z-10">
                    {{ $alur->urutan }}
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-emerald-100 transition-all duration-300 relative overflow-hidden group-hover:-translate-y-1">
                @if($alur->is_critical)
                    <div class="absolute top-0 right-0 bg-rose-500 text-white text-[9px] font-black uppercase px-3 py-1 rounded-bl-xl">Penting</div>
                @endif

                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Thumbnail -->
                    <div class="w-full md:w-32 h-32 rounded-2xl bg-slate-100 overflow-hidden shrink-0">
                        @if($alur->gambar)
                            <img src="{{ asset('storage/'.$alur->gambar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-wider">{{ $alur->jenisPelayanan->nama_layanan ?? 'Umum' }}</span>
                            <span class="px-2.5 py-1 rounded-lg {{ $alur->tipe_alur == 'Online' ? 'bg-sky-50 text-sky-600' : 'bg-orange-50 text-orange-600' }} text-[10px] font-black uppercase tracking-wider">{{ $alur->tipe_alur }}</span>
                            @if($alur->jam_operasional)
                                <span class="px-2.5 py-1 rounded-lg bg-purple-50 text-purple-600 text-[10px] font-bold uppercase flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $alur->jam_operasional }}
                                </span>
                            @endif
                        </div>
                        
                        <h4 class="text-xl font-black text-slate-800 mb-2">{{ $alur->judul }}</h4>
                        <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $alur->deskripsi }}</p>

                        <!-- Footer Info -->
                        <div class="flex flex-wrap gap-4 text-xs text-slate-400 font-medium border-t border-slate-50 pt-3">
                            @if($alur->penanggung_jawab)
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg> {{ $alur->penanggung_jawab }}</span>
                            @endif
                            @if($alur->file_template)
                                <span class="flex items-center gap-1 text-blue-500"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Dokumen</span>
                            @endif
                            @if(count($alur->faq ?? []))
                                <span class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> {{ count($alur->faq) }} FAQ</span>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex md:flex-col gap-2 shrink-0 border-l border-slate-50 pl-4 ml-2 justify-center">
                        <button wire:click="edit({{ $alur->id }})" class="p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors tooltip-left" title="Edit">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </button>
                        <button wire:click="delete({{ $alur->id }})" onclick="return confirm('Hapus data ini?') || event.stopImmediatePropagation()" class="p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-slate-50 p-12 text-center rounded-[2.5rem] border-2 border-dashed border-slate-200">
            <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300 shadow-sm transform rotate-3">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 mb-2">Belum Ada Data Alur</h3>
            <p class="text-slate-500 mb-6 max-w-md mx-auto">Silakan tambahkan langkah pertama untuk membangun panduan layanan yang informatif.</p>
            <button wire:click="create" class="px-6 py-3 bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-lg hover:bg-emerald-700 transition-colors">Buat Langkah Pertama</button>
        </div>
        @endforelse
    </div>
    @endif
</div>