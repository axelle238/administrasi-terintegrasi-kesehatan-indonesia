<div class="space-y-8 animate-fade-in">
    <!-- Header Navigation -->
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex justify-between items-center">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-wider">{{ $jenisPelayanan->poli->nama_poli ?? 'Unit' }}</span>
                <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $jenisPelayanan->nama_layanan }}</span>
            </div>
            <h2 class="text-2xl font-black text-slate-800">Editor Alur Layanan</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('alur-pelayanan.index', ['poli' => $jenisPelayanan->poli_id, 'layanan' => $jenisPelayanan->id]) }}" target="_blank" class="px-5 py-2.5 rounded-xl border border-slate-200 text-emerald-600 text-xs font-bold uppercase tracking-wider hover:bg-emerald-50 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                Preview Publik
            </a>
            <a href="{{ route('system.alur.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider hover:bg-slate-50 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
            @if(!$isFormOpen)
            <button wire:click="create" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-all flex items-center gap-2 transform hover:-translate-y-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Langkah
            </button>
            @endif
        </div>
    </div>

    <!-- Form Section -->
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
                <button wire:click="setTabForm('details')" class="px-4 py-2 rounded-t-lg text-sm font-bold border-b-2 transition-colors {{ $activeTabForm === 'details' ? 'border-emerald-500 text-emerald-600 bg-emerald-50/50' : 'border-transparent text-slate-500 hover:text-emerald-500' }}">Detail & Biaya</button>
                <button wire:click="setTabForm('media')" class="px-4 py-2 rounded-t-lg text-sm font-bold border-b-2 transition-colors {{ $activeTabForm === 'media' ? 'border-emerald-500 text-emerald-600 bg-emerald-50/50' : 'border-transparent text-slate-500 hover:text-emerald-500' }}">Multimedia</button>
                <button wire:click="setTabForm('advanced')" class="px-4 py-2 rounded-t-lg text-sm font-bold border-b-2 transition-colors {{ $activeTabForm === 'advanced' ? 'border-emerald-500 text-emerald-600 bg-emerald-50/50' : 'border-transparent text-slate-500 hover:text-emerald-500' }}">Advanced</button>
            </div>

            <!-- Tab Content: General -->
            @if($activeTabForm === 'general')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Judul Langkah</label>
                    <input wire:model="judul" type="text" placeholder="Contoh: Pendaftaran Loket" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 py-3">
                    @error('judul') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Urutan</label>
                    <input wire:model="urutan" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold focus:ring-emerald-500 py-3 text-center">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Icon (Heroicon)</label>
                    <input wire:model="icon" type="text" class="w-full rounded-xl border-slate-200 text-sm font-mono py-3">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi Proses</label>
                    <textarea wire:model="deskripsi" rows="4" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 p-4" placeholder="Jelaskan detail prosedur di langkah ini..."></textarea>
                </div>
            </div>
            @endif

            <!-- Tab Content: Details -->
            @if($activeTabForm === 'details')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in">
                <!-- Time Estimation -->
                <div class="md:col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Estimasi Waktu (Menit)</label>
                    <div class="flex gap-4 items-center">
                        <div class="flex-1">
                            <label class="text-[10px] text-slate-400 font-bold uppercase mb-1 block">Minimal</label>
                            <input wire:model="waktu_min" type="number" placeholder="Min" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                        </div>
                        <div class="flex-1">
                            <label class="text-[10px] text-slate-400 font-bold uppercase mb-1 block">Maksimal</label>
                            <input wire:model="waktu_max" type="number" placeholder="Max" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                        </div>
                        <div class="flex-1">
                            <label class="text-[10px] text-slate-400 font-bold uppercase mb-1 block">Label Display</label>
                            <input wire:model="estimasi_waktu" type="text" placeholder="e.g. 10-15 Menit" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Cost Estimation -->
                <div class="md:col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Komponen Biaya (Rp)</label>
                    <div class="flex gap-4 items-center">
                        <div class="flex-1">
                            <label class="text-[10px] text-slate-400 font-bold uppercase mb-1 block">Jasa Sarana</label>
                            <input wire:model="biaya_sarana" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold text-right">
                        </div>
                        <div class="flex-1">
                            <label class="text-[10px] text-slate-400 font-bold uppercase mb-1 block">Jasa Pelayanan</label>
                            <input wire:model="biaya_pelayanan" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold text-right">
                        </div>
                        <div class="flex-1">
                            <label class="text-[10px] text-slate-400 font-bold uppercase mb-1 block">Biaya Lainnya</label>
                            <input wire:model="estimasi_biaya" type="number" class="w-full rounded-xl border-slate-200 text-sm font-bold text-right">
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2 text-right">*Total biaya akan dikalkulasi otomatis.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Target Pasien</label>
                    <select wire:model="target_pasien" class="w-full rounded-xl border-slate-200 text-sm font-bold">
                        <option value="Umum">Umum (Semua)</option>
                        <option value="BPJS">Pasien BPJS</option>
                        <option value="Umum/Tunai">Pasien Umum/Tunai</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Lokasi / Ruangan</label>
                    <input wire:model="lokasi" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Dokumen Persyaratan</label>
                    <input wire:model="dokumen_syarat" type="text" class="w-full rounded-xl border-slate-200 text-sm" placeholder="KTP, KK, Kartu BPJS (Pisahkan koma)">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Output Layanan (Yang didapat)</label>
                    <input wire:model="output_langkah" type="text" class="w-full rounded-xl border-slate-200 text-sm" placeholder="Resep Obat, Kwitansi Pembayaran">
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

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Link Video Tutorial</label>
                        <input wire:model="video_url" type="text" placeholder="https://youtube.com/..." class="w-full rounded-xl border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">File Template (Download)</label>
                        <input type="file" wire:model="file_template" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700"/>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tab Content: Advanced -->
            @if($activeTabForm === 'advanced')
            <div class="space-y-6 animate-fade-in">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Penanggung Jawab (Nama)</label>
                        <input wire:model="penanggung_jawab" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Role/Jabatan Terkait</label>
                        <select wire:model="required_role_id" class="w-full rounded-xl border-slate-200 text-sm">
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200 cursor-pointer">
                        <input wire:model="is_active" type="checkbox" class="rounded text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm font-bold text-slate-700">Status Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200 cursor-pointer">
                        <input wire:model="is_critical" type="checkbox" class="rounded text-rose-600 focus:ring-rose-500">
                        <span class="text-sm font-bold text-slate-700">Langkah Kritis (Wajib)</span>
                    </label>
                </div>
            </div>
            @endif

            <!-- Footer -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
                <button wire:click="cancel" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs tracking-wider hover:bg-slate-50">Batal</button>
                <button wire:click="store" class="px-8 py-3 rounded-xl bg-emerald-600 text-white font-bold uppercase text-xs tracking-wider shadow-lg hover:bg-emerald-700 transform hover:-translate-y-0.5 transition-all">Simpan Langkah</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Timeline Flow Visualization -->
    <div class="relative pl-8 md:pl-16 border-l-4 border-slate-200 space-y-12 py-8 ml-4 md:ml-8">
        @forelse($alurs as $alur)
        <div class="relative group">
            <!-- Timeline Dot -->
            <div class="absolute -left-[45px] md:-left-[77px] top-8 flex flex-col items-center">
                <div class="w-10 h-10 md:w-14 md:h-14 rounded-full bg-white border-4 {{ $alur->is_critical ? 'border-rose-200 text-rose-600' : 'border-indigo-100 text-indigo-600' }} flex items-center justify-center font-black text-lg shadow-md group-hover:scale-110 transition-transform z-10">
                    {{ $alur->urutan }}
                </div>
            </div>

            <!-- Content Card -->
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-300 relative overflow-hidden group-hover:-translate-y-1">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Image -->
                    @if($alur->gambar)
                    <div class="w-full md:w-48 h-48 rounded-2xl bg-slate-100 overflow-hidden shrink-0 shadow-inner">
                        <img src="{{ asset('storage/'.$alur->gambar) }}" class="w-full h-full object-cover">
                    </div>
                    @endif

                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-black text-slate-800 mb-2">{{ $alur->judul }}</h3>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $alur->waktu_range ?? $alur->estimasi_waktu }}
                                    </span>
                                    @if($alur->total_biaya > 0)
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase flex items-center gap-1">
                                        Rp {{ number_format($alur->total_biaya) }}
                                    </span>
                                    @endif
                                    @if($alur->is_critical)
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-black uppercase">Wajib</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="duplicate({{ $alur->id }})" class="p-2 bg-slate-50 text-slate-400 hover:text-teal-600 rounded-xl transition-colors" title="Duplikat"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg></button>
                                <button wire:click="edit({{ $alur->id }})" class="p-2 bg-slate-50 text-slate-400 hover:text-indigo-600 rounded-xl transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></button>
                                <button wire:click="delete({{ $alur->id }})" onclick="confirm('Hapus langkah ini?') || event.stopImmediatePropagation()" class="p-2 bg-slate-50 text-slate-400 hover:text-rose-600 rounded-xl transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                            </div>
                        </div>
                        
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">{{ $alur->deskripsi }}</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-50 text-xs">
                            @if($alur->dokumen_syarat)
                            <div>
                                <span class="block font-bold text-slate-400 uppercase text-[9px] mb-1">Dokumen Diperlukan</span>
                                <span class="font-bold text-slate-700">{{ $alur->dokumen_syarat }}</span>
                            </div>
                            @endif
                            @if($alur->output_langkah)
                            <div>
                                <span class="block font-bold text-slate-400 uppercase text-[9px] mb-1">Output (Hasil)</span>
                                <span class="font-bold text-emerald-600">{{ $alur->output_langkah }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <p class="text-slate-400 italic">Belum ada langkah alur untuk layanan ini.</p>
        </div>
        @endforelse
    </div>
</div>