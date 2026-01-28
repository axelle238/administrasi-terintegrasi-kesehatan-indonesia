<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Pemeriksaan Medis</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm font-bold text-blue-600">{{ $pasien->nama_lengkap }}</span>
                    <span class="text-xs text-slate-400 font-medium">| NIK: {{ $pasien->nik }}</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right hidden md:block">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Kunjungan</p>
                <p class="text-sm font-bold text-slate-700 dark:text-gray-300">{{ now()->translatedFormat('d F Y') }}</p>
            </div>
            <a href="{{ route('rekam-medis.index') }}" wire:navigate class="px-5 py-2.5 bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-gray-300 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                Batal
            </a>
        </div>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri & Tengah: Medis -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Vitals & Keluhan -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6 md:p-8">
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600">1</span>
                    Anamnesa & Tanda Vital
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">TD (mmHg)</label>
                        <input type="text" wire:model="tekanan_darah" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm font-bold" placeholder="120/80">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Suhu (°C)</label>
                        <input type="number" step="0.1" wire:model="suhu_tubuh" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm font-bold" placeholder="36.5">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">BB (Kg)</label>
                        <input type="number" step="0.1" wire:model="berat_badan" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm font-bold" placeholder="60">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">TB (Cm)</label>
                        <input type="number" wire:model="tinggi_badan" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm font-bold" placeholder="165">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nadi (x/m)</label>
                        <input type="number" wire:model="nadi" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm font-bold" placeholder="80">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Napas (x/m)</label>
                        <input type="number" wire:model="pernapasan" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm font-bold" placeholder="20">
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-bold text-slate-700 dark:text-gray-300">Keluhan Pasien (Subjective)</label>
                        <textarea wire:model="keluhan" rows="3" class="mt-1 block w-full rounded-2xl border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Tuliskan keluhan utama dan riwayat penyakit saat ini..."></textarea>
                        <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Diagnosa ICD-10 -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6 md:p-8">
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600">2</span>
                    Diagnosa (ICD-10)
                </h3>

                <div class="relative mb-4">
                    <x-input-label value="Cari Kode atau Nama Penyakit" />
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="icd10Query" 
                        placeholder="Ketik min. 2 karakter (contoh: A00 atau Cholera)..." 
                        class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm mt-1 focus:ring-blue-500"
                    >
                    @if(!empty($icd10Results))
                        <div class="absolute z-50 w-full bg-white dark:bg-gray-800 shadow-2xl rounded-2xl mt-2 border border-slate-100 dark:border-gray-700 overflow-hidden">
                            @foreach($icd10Results as $res)
                                <button 
                                    type="button"
                                    wire:click="selectIcd10('{{ $res->code }}', '{{ $res->name_id ?? $res->name_en }}')"
                                    class="w-full text-left px-6 py-3 hover:bg-blue-50 dark:hover:bg-blue-900/30 border-b border-slate-50 dark:border-gray-700 last:border-0"
                                >
                                    <span class="font-black text-blue-600 mr-2">{{ $res->code }}</span>
                                    <span class="text-sm font-bold text-slate-700 dark:text-gray-200">{{ $res->name_id ?? $res->name_en }}</span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-100 dark:border-blue-800">
                    <label class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Diagnosa Terpilih</label>
                    <div class="text-lg font-black text-blue-700 dark:text-blue-300 mt-1">
                        {{ $diagnosa ?: 'Belum dipilih' }}
                    </div>
                    <x-input-error :messages="$errors->get('diagnosa')" class="mt-2" />
                </div>
            </div>

            <!-- Tindakan Medis (Inline List) -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6 md:p-8">
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600">3</span>
                    Tindakan & Prosedur Medis
                </h3>

                <div class="mb-6">
                    <input type="text" wire:model.live="searchTindakan" placeholder="Filter tindakan..." class="w-full md:w-64 border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-64 overflow-y-auto p-1 custom-scrollbar">
                        @foreach($tindakans as $t)
                            <label class="flex items-center p-4 rounded-2xl border-2 cursor-pointer transition-all {{ in_array($t->id, $selectedTindakans) ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-slate-50 dark:border-gray-700 hover:border-slate-200' }}">
                                <input type="checkbox" wire:click="selectTindakan({{ $t->id }})" {{ in_array($t->id, $selectedTindakans) ? 'checked' : '' }} class="hidden">
                                <div class="flex-1">
                                    <div class="text-sm font-bold text-slate-800 dark:text-gray-200">{{ $t->nama_tindakan }}</div>
                                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rp {{ number_format($t->harga, 0, ',', '.') }}</div>
                                </div>
                                @if(in_array($t->id, $selectedTindakans))
                                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                @endif
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Resep Obat -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6 md:p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-3">
                        <span class="w-8 h-8 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600">4</span>
                        Resep Obat / Terapi
                    </h3>
                    <button type="button" wire:click="addResepRow" class="text-xs font-black text-blue-600 uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 p-2 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                        Tambah Baris
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach($resep as $index => $item)
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-gray-700 relative group">
                            <div class="md:col-span-5">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Obat</label>
                                <select wire:model="resep.{{ $index }}.obat_id" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm font-bold">
                                    <option value="">-- Pilih Obat --</option>
                                    @foreach($obats as $o)
                                        <option value="{{ $o->id }}">{{ $o->nama_obat }} (Stok: {{ $o->stok }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Jumlah</label>
                                <input type="number" wire:model="resep.{{ $index }}.jumlah" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm font-bold">
                            </div>
                            <div class="md:col-span-4">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Aturan Pakai</label>
                                <input type="text" wire:model="resep.{{ $index }}.aturan_pakai" placeholder="3 x 1 hari sesudah makan" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm">
                            </div>
                            <div class="md:col-span-1 flex items-end justify-center">
                                <button type="button" wire:click="removeResepRow({{ $index }})" class="p-2 text-red-400 hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Penunjang & Submit -->
        <div class="space-y-6">
            
            <!-- Dokumen Penunjang -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-md font-black text-slate-900 dark:text-white">File Penunjang</h3>
                    <button type="button" wire:click="addUploadRow" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">+ Tambah</button>
                </div>
                
                <div class="space-y-4">
                    @foreach($uploads as $key => $up)
                        <div class="p-4 rounded-2xl border border-dashed border-slate-200 dark:border-gray-600 space-y-3 relative">
                            <select wire:model="uploadTypes.{{ $key }}" class="w-full border-none bg-transparent p-0 text-[10px] font-black text-slate-400 uppercase tracking-widest focus:ring-0">
                                <option value="Lab">Hasil Lab</option>
                                <option value="Radiologi">Rontgen/Radiologi</option>
                                <option value="EKG">EKG</option>
                                <option value="Lainnya">Dokumen Lainnya</option>
                            </select>
                            <input type="file" wire:model="uploads.{{ $key }}" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all" />
                            <input type="text" wire:model="uploadNotes.{{ $key }}" placeholder="Catatan singkat file..." class="w-full border-none bg-slate-50 dark:bg-gray-700 rounded-lg text-xs focus:ring-0">
                            
                            @if($key > 0)
                                <button type="button" wire:click="removeUploadRow({{ $key }})" class="absolute top-2 right-2 text-red-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Catatan Akhir -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
                <h3 class="text-md font-black text-slate-900 dark:text-white mb-4">Catatan Dokter</h3>
                <textarea wire:model="catatan_tambahan" rows="4" class="w-full border-slate-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-2xl text-sm" placeholder="Instruksi perawatan, saran kontrol, atau catatan medis lainnya..."></textarea>
            </div>

            <!-- Submit -->
            <div class="bg-slate-900 rounded-3xl p-6 shadow-2xl shadow-slate-900/30 sticky top-6">
                <div class="text-white mb-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Billing Terdeteksi</p>
                    <div class="flex items-baseline gap-1 mt-1">
                        <span class="text-xs font-bold text-slate-400">Rp</span>
                        <span class="text-3xl font-black tracking-tighter">Otomatis</span>
                    </div>
                    <p class="text-[10px] text-slate-500 mt-2 font-medium italic">Kalkulasi akhir akan diproses di bagian Kasir.</p>
                </div>
                
                <div class="space-y-3">
                    <button type="submit" wire:loading.attr="disabled" class="w-full inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition shadow-xl shadow-blue-600/20 group">
                        <svg wire:loading.remove class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        <svg wire:loading class="animate-spin w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Simpan & Selesaikan
                    </button>
                    <div class="text-center">
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Verifikasi Data Sebelum Simpan</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
