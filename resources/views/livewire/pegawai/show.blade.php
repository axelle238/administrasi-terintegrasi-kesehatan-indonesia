<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20 animate-fade-in">
    
    <!-- 1. HEADER PROFILE CARD -->
    <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden relative group">
        <!-- Banner/Cover -->
        <div class="h-48 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/50 to-transparent"></div>
        </div>

        <div class="px-8 pb-8 relative">
            <div class="flex flex-col md:flex-row items-end md:items-center gap-6 -mt-16">
                <!-- Avatar -->
                <div class="relative group cursor-pointer">
                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-2xl bg-white overflow-hidden flex items-center justify-center text-4xl font-black text-indigo-500">
                        @if($pegawai->foto_profil)
                            <img src="{{ Storage::url($pegawai->foto_profil) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($pegawai->user->name, 0, 1) }}
                        @endif
                    </div>
                    <span class="absolute bottom-2 right-2 w-6 h-6 bg-emerald-500 border-4 border-white rounded-full" title="Status Aktif"></span>
                </div>

                <!-- Identity -->
                <div class="flex-1 mb-2">
                    <h1 class="text-3xl font-black text-slate-800">{{ $pegawai->user->name }}</h1>
                    <div class="flex flex-wrap gap-3 mt-2 text-sm">
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg font-bold uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .854.509 1.5 1.5 1.5H13" /></svg>
                            {{ $pegawai->jabatan }}
                        </span>
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg font-bold uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            {{ $pegawai->poli->nama_poli ?? 'Non-Medis' }}
                        </span>
                        <span class="px-3 py-1 bg-slate-800 text-white rounded-lg font-mono font-bold tracking-widest">
                            NIP: {{ $pegawai->nip }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 mb-2">
                    <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                        Edit Profil
                    </button>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                        Cetak ID Card
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="px-8 border-t border-slate-100 flex overflow-x-auto gap-8">
            @foreach([
                'profil' => 'Biodata & Kontak',
                'karir' => 'Riwayat Karir',
                'pendidikan' => 'Pendidikan',
                'keluarga' => 'Data Keluarga',
                'dokumen' => 'Berkas Digital',
                'pelanggaran' => 'Catatan Disiplin'
            ] as $key => $label)
                <button wire:click="setTab('{{ $key }}')" 
                    class="py-4 text-sm font-bold border-b-2 transition-all whitespace-nowrap {{ $activeTab == $key ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- 2. CONTENT AREA -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT COLUMN: SUMMARY (Always Visible) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status Card -->
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-4">Status Kepegawaian</h3>
                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Status</span>
                        <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">{{ $pegawai->status_kepegawaian }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Tanggal Masuk</span>
                        <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Masa Kerja</span>
                        <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->diffForHumans(null, true) }}</span>
                    </div>
                    <div class="h-px bg-slate-100"></div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Sisa Cuti</span>
                        <span class="font-black text-indigo-600 text-lg">{{ $pegawai->sisa_cuti }} Hari</span>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-4">Kontak Darurat</h3>
                <div class="flex items-center gap-4 bg-rose-50 p-4 rounded-xl border border-rose-100">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-rose-500 shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm">{{ $pegawai->kontak_darurat_nama ?? '-' }}</p>
                        <p class="text-xs text-rose-600 font-mono">{{ $pegawai->kontak_darurat_telp ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: DYNAMIC TABS -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- TAB: PROFIL -->
            @if($activeTab == 'profil')
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 animate-fade-in-up">
                <h3 class="text-xl font-black text-slate-800 mb-6">Biodata Lengkap</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Email Kantor</p>
                        <p class="font-medium text-slate-800">{{ $pegawai->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Nomor Telepon</p>
                        <p class="font-medium text-slate-800">{{ $pegawai->no_telepon }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Lahir</p>
                        <p class="font-medium text-slate-800">{{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Jenis Kelamin</p>
                        <p class="font-medium text-slate-800">{{ $pegawai->jenis_kelamin ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Alamat Domisili</p>
                        <p class="font-medium text-slate-800">{{ $pegawai->alamat }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- TAB: KARIR (INLINE FORM) -->
            @if($activeTab == 'karir')
            <div class="space-y-6 animate-fade-in-up">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-black text-slate-800">Riwayat Karir & Jabatan</h3>
                    <button wire:click="$toggle('showKarirForm')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-lg shadow-indigo-500/20">
                        {{ $showKarirForm ? 'Batal' : '+ Mutasi / Promosi' }}
                    </button>
                </div>

                @if($showKarirForm)
                <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <select wire:model="karir_jenis" class="rounded-xl border-slate-200 text-sm font-bold">
                            <option value="">Pilih Jenis Perubahan...</option>
                            <option value="Promosi">Promosi</option>
                            <option value="Mutasi">Mutasi</option>
                            <option value="Demosi">Demosi</option>
                            <option value="Penugasan">Penugasan</option>
                        </select>
                        <input type="text" wire:model="karir_jabatan" placeholder="Jabatan Baru" class="rounded-xl border-slate-200 text-sm font-bold">
                        <input type="text" wire:model="karir_unit" placeholder="Unit Kerja Baru" class="rounded-xl border-slate-200 text-sm font-bold">
                        <input type="date" wire:model="karir_tgl" class="rounded-xl border-slate-200 text-sm font-bold">
                        <input type="text" wire:model="karir_sk" placeholder="Nomor SK" class="md:col-span-2 rounded-xl border-slate-200 text-sm font-bold">
                    </div>
                    <button wire:click="saveKarir" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-md hover:bg-indigo-700">Simpan Perubahan Karir</button>
                </div>
                @endif

                <div class="relative border-l-2 border-indigo-100 ml-3 space-y-8">
                    @foreach($pegawai->riwayatKarir as $karir)
                    <div class="relative pl-8 group">
                        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full border-2 border-white bg-indigo-500 shadow-sm group-hover:scale-125 transition-transform"></div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:border-indigo-200 transition-all">
                            <div class="flex justify-between items-start mb-2">
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase rounded-lg">{{ $karir->jenis_perubahan }}</span>
                                <span class="text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($karir->tanggal_efektif)->translatedFormat('d F Y') }}</span>
                            </div>
                            <h4 class="text-lg font-black text-slate-800">{{ $karir->jabatan_baru }}</h4>
                            <p class="text-sm text-slate-500">{{ $karir->unit_kerja_baru }}</p>
                            @if($karir->nomor_sk)
                                <p class="mt-2 text-xs font-mono text-slate-400">SK: {{ $karir->nomor_sk }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- TAB: KELUARGA (INLINE FORM) -->
            @if($activeTab == 'keluarga')
            <div class="space-y-6 animate-fade-in-up">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-black text-slate-800">Data Keluarga (Tunjangan & BPJS)</h3>
                    <button wire:click="$toggle('showKeluargaForm')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
                        {{ $showKeluargaForm ? 'Batal' : '+ Tambah Anggota' }}
                    </button>
                </div>

                @if($showKeluargaForm)
                <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text" wire:model="keluarga_nama" placeholder="Nama Lengkap" class="rounded-xl border-slate-200 text-sm font-bold">
                        <select wire:model="keluarga_hubungan" class="rounded-xl border-slate-200 text-sm font-bold">
                            <option value="">Hubungan...</option>
                            <option value="Suami">Suami</option>
                            <option value="Istri">Istri</option>
                            <option value="Anak">Anak</option>
                        </select>
                        <input type="text" wire:model="keluarga_nik" placeholder="NIK" class="rounded-xl border-slate-200 text-sm font-bold">
                        <input type="date" wire:model="keluarga_tgl_lahir" class="rounded-xl border-slate-200 text-sm font-bold">
                        <div class="md:col-span-2 flex items-center gap-2">
                            <input type="checkbox" wire:model="keluarga_bpjs" id="bpjs_check" class="rounded text-emerald-600 focus:ring-emerald-500">
                            <label for="bpjs_check" class="text-sm font-bold text-slate-600">Didaftarkan BPJS Kesehatan?</label>
                        </div>
                    </div>
                    <button wire:click="saveKeluarga" class="w-full py-3 bg-emerald-600 text-white rounded-xl font-bold shadow-md hover:bg-emerald-700">Simpan Data Keluarga</button>
                </div>
                @endif

                <div class="space-y-3">
                    @forelse($pegawai->keluarga as $fam)
                    <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-black">
                                {{ substr($fam->nama, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $fam->nama }}</h4>
                                <p class="text-xs text-slate-500 font-bold uppercase">{{ $fam->hubungan }} • {{ \Carbon\Carbon::parse($fam->tanggal_lahir)->age }} Tahun</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($fam->tertanggung_bpjs)
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-[10px] font-black uppercase">BPJS Aktif</span>
                            @endif
                            <button wire:click="deleteKeluarga({{ $fam->id }})" wire:confirm="Hapus data keluarga ini?" class="text-slate-400 hover:text-red-500">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <p class="text-slate-400 font-medium">Belum ada data keluarga.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif

            <!-- TAB: PELANGGARAN (INLINE FORM) -->
            @if($activeTab == 'pelanggaran')
            <div class="space-y-6 animate-fade-in-up">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-black text-slate-800">Rekam Jejak & Disiplin</h3>
                    <button wire:click="$toggle('showPelanggaranForm')" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
                        {{ $showPelanggaranForm ? 'Batal' : '+ Input Pelanggaran' }}
                    </button>
                </div>

                @if($showPelanggaranForm)
                <div class="bg-rose-50 p-6 rounded-2xl border border-rose-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <select wire:model="sanksi_jenis" class="rounded-xl border-slate-200 text-sm font-bold">
                            <option value="">Jenis Pelanggaran...</option>
                            <option value="Ringan">Ringan</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Berat">Berat</option>
                        </select>
                        <select wire:model="sanksi_tingkat" class="rounded-xl border-slate-200 text-sm font-bold">
                            <option value="">Tingkat Sanksi...</option>
                            <option value="Teguran Lisan">Teguran Lisan</option>
                            <option value="SP1">SP 1</option>
                            <option value="SP2">SP 2</option>
                            <option value="SP3">SP 3</option>
                            <option value="PHK">PHK</option>
                        </select>
                        <input type="date" wire:model="sanksi_tgl" class="rounded-xl border-slate-200 text-sm font-bold">
                        <textarea wire:model="sanksi_desc" placeholder="Deskripsi Kejadian..." class="md:col-span-2 rounded-xl border-slate-200 text-sm font-bold" rows="3"></textarea>
                    </div>
                    <button wire:click="savePelanggaran" class="w-full py-3 bg-rose-600 text-white rounded-xl font-bold shadow-md hover:bg-rose-700">Simpan Catatan Disiplin</button>
                </div>
                @endif

                <div class="space-y-4">
                    @forelse($pegawai->pelanggaran as $sp)
                    <div class="p-5 bg-white rounded-2xl border-l-4 border-rose-500 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-1 bg-rose-100 text-rose-700 text-[10px] font-black uppercase rounded-lg">{{ $sp->tingkat_sanksi }}</span>
                            <span class="text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($sp->tanggal_kejadian)->translatedFormat('d F Y') }}</span>
                        </div>
                        <p class="text-slate-800 font-bold text-sm">{{ $sp->deskripsi_kejadian }}</p>
                        <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-wider">Kategori: {{ $sp->jenis_pelanggaran }}</p>
                    </div>
                    @empty
                    <div class="p-12 text-center bg-emerald-50 rounded-2xl border border-emerald-100">
                        <svg class="w-12 h-12 text-emerald-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-emerald-700 font-bold">Pegawai Bersih</p>
                        <p class="text-emerald-600 text-xs">Tidak ada catatan pelanggaran disiplin.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif

            <!-- TAB: PENDIDIKAN (INLINE FORM) -->
            @if($activeTab == 'pendidikan')
            <div class="space-y-6 animate-fade-in-up">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-black text-slate-800">Riwayat Pendidikan Formal</h3>
                    <button wire:click="$toggle('showPendidikanForm')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
                        {{ $showPendidikanForm ? 'Batal' : '+ Tambah' }}
                    </button>
                </div>

                @if($showPendidikanForm)
                <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <select wire:model="pendidikan_jenjang" class="rounded-xl border-slate-200 text-sm font-bold">
                            <option value="">Jenjang...</option>
                            <option value="SMA/SMK">SMA/SMK</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                        <input type="text" wire:model="pendidikan_institusi" placeholder="Nama Institusi / Universitas" class="rounded-xl border-slate-200 text-sm font-bold">
                        <input type="text" wire:model="pendidikan_jurusan" placeholder="Jurusan" class="rounded-xl border-slate-200 text-sm font-bold">
                        <input type="number" wire:model="pendidikan_tahun" placeholder="Tahun Lulus" class="rounded-xl border-slate-200 text-sm font-bold">
                    </div>
                    <button wire:click="savePendidikan" class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold shadow-md hover:bg-blue-700">Simpan Riwayat Pendidikan</button>
                </div>
                @endif

                <div class="space-y-4">
                    @forelse($pegawai->pendidikan as $edu)
                    <div class="flex gap-4 p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
                        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600 font-black text-lg">
                            {{ $edu->jenjang }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $edu->institusi }}</h4>
                            <p class="text-sm text-slate-600">{{ $edu->jurusan }}</p>
                            <p class="text-xs text-slate-400 font-mono mt-1">Lulus: {{ $edu->tahun_lulus }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <p class="text-slate-400 font-medium">Belum ada data pendidikan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif

        </div>
    </div>
</div>