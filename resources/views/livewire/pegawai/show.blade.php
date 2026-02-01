<div class="space-y-6 animate-fade-in">
    <!-- Header Profile Card -->
    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-bl-full -mr-10 -mt-10 -z-0"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row gap-8 items-start">
            <!-- Avatar -->
            <div class="w-32 h-32 rounded-[2rem] bg-white shadow-xl shadow-slate-200 border-4 border-white overflow-hidden flex items-center justify-center text-4xl font-black text-slate-300 relative group">
                @if($pegawai->foto_profil)
                    <img src="{{ Storage::url($pegawai->foto_profil) }}" class="w-full h-full object-cover">
                @else
                    {{ substr($pegawai->user->name ?? 'X', 0, 1) }}
                @endif
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                    <span class="text-xs font-bold text-white uppercase">Ubah Foto</span>
                </div>
            </div>

            <!-- Identity -->
            <div class="flex-1 min-w-0">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
                    <div>
                        <h2 class="text-3xl font-black text-slate-800 tracking-tight">{{ $pegawai->user->name ?? 'Tanpa Nama' }}</h2>
                        <div class="flex flex-wrap items-center gap-3 mt-2">
                            <span class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-xs font-black uppercase tracking-wider">{{ $pegawai->jabatan ?? 'Staff' }}</span>
                            <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">{{ $pegawai->nip ?? 'NIP Belum Diatur' }}</span>
                            <span class="flex items-center gap-1 text-xs font-bold text-slate-500">
                                <span class="w-2 h-2 rounded-full {{ $pegawai->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $pegawai->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <a href="{{ route('pegawai.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold uppercase hover:bg-slate-50 transition-colors">
                            Kembali
                        </a>
                        <button wire:click="toggleEditProfil" class="px-5 py-2.5 rounded-xl bg-slate-800 text-white text-xs font-bold uppercase hover:bg-slate-900 transition-colors shadow-lg shadow-slate-200">
                            {{ $isEditingProfil ? 'Batal Edit' : 'Edit Profil Utama' }}
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-6 pt-6 border-t border-dashed border-slate-200">
                    <div>
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Unit Kerja</span>
                        <p class="font-bold text-slate-700">{{ $pegawai->poli->nama_poli ?? 'General' }}</p>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Masa Kerja</span>
                        <p class="font-bold text-slate-700">{{ $masa_kerja }}</p>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Usia</span>
                        <p class="font-bold text-slate-700">{{ $age }} Tahun</p>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Email</span>
                        <p class="font-bold text-slate-700 truncate" title="{{ $pegawai->user->email }}">{{ $pegawai->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="border-b border-slate-200 overflow-x-auto">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @foreach(['profil' => 'Biodata & Identitas', 'keluarga' => 'Keluarga & Tanggungan', 'pendidikan' => 'Riwayat Pendidikan', 'dokumen' => 'Dokumen Digital', 'karir' => 'Riwayat Karir'] as $key => $label)
            <button wire:click="setTab('{{ $key }}')" 
                class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors {{ $activeTab === $key ? 'border-blue-500 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                {{ $label }}
            </button>
            @endforeach
        </nav>
    </div>

    <!-- TAB CONTENTS -->
    <div class="min-h-[400px]">
        
        <!-- 1. TAB PROFIL -->
        @if($activeTab === 'profil')
            @if($isEditingProfil)
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 animate-fade-in-up">
                <form wire:submit="updateProfil">
                    <h3 class="font-black text-slate-800 text-lg mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></span>
                        Edit Informasi Pegawai
                    </h3>
                    
                    <!-- Section: Identitas -->
                    <div class="mb-8">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2 mb-4">Identitas Pribadi</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                                <input wire:model="formProfil.nama" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('formProfil.nama') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Email Login</label>
                                <input wire:model="formProfil.email" type="email" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('formProfil.email') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">NIP (Nomor Induk Pegawai)</label>
                                <input wire:model="formProfil.nip" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('formProfil.nip') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">NIK (KTP)</label>
                                <input wire:model="formProfil.nik" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">No. Kartu Keluarga</label>
                                <input wire:model="formProfil.kk" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tempat Lahir</label>
                                <input wire:model="formProfil.tempat_lahir" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tanggal Lahir</label>
                                <input wire:model="formProfil.tanggal_lahir" type="date" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                                <select wire:model="formProfil.jenis_kelamin" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Agama</label>
                                <select wire:model="formProfil.agama" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Status Pernikahan</label>
                                <select wire:model="formProfil.status_pernikahan" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Golongan Darah</label>
                                <select wire:model="formProfil.golongan_darah" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="-">-</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-1">Alamat Lengkap (Sesuai KTP)</label>
                                <input wire:model="formProfil.alamat" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">No. Telepon / WA</label>
                                <input wire:model="formProfil.no_telepon" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Kepegawaian -->
                    <div class="mb-8">
                         <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2 mb-4">Data Kepegawaian</h4>
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Jabatan</label>
                                <input wire:model="formProfil.jabatan" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Unit Kerja / Poli</label>
                                <select wire:model="formProfil.poli_id" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Non-Medis / Umum</option>
                                    @foreach($polis as $poli)
                                        <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Status Kepegawaian</label>
                                <select wire:model="formProfil.status_kepegawaian" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Tetap">Tetap</option>
                                    <option value="Kontrak">Kontrak</option>
                                    <option value="Honor">Honor</option>
                                    <option value="PNS">PNS</option>
                                    <option value="PPPK">PPPK</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tanggal Masuk</label>
                                <input wire:model="formProfil.tanggal_masuk" type="date" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                         </div>
                    </div>

                    <!-- Section: Keuangan -->
                    <div class="mb-8">
                         <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2 mb-4">Informasi Payroll & Pajak</h4>
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">NPWP</label>
                                <input wire:model="formProfil.npwp" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Nama Bank</label>
                                <input wire:model="formProfil.nama_bank" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Nomor Rekening</label>
                                <input wire:model="formProfil.nomor_rekening" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Pemilik Rekening</label>
                                <input wire:model="formProfil.pemilik_rekening" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">No. BPJS Kesehatan</label>
                                <input wire:model="formProfil.no_bpjs_kesehatan" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">No. BPJS Ketenagakerjaan</label>
                                <input wire:model="formProfil.no_bpjs_ketenagakerjaan" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                         </div>
                    </div>

                     <!-- Section: Kontak Darurat -->
                    <div class="mb-8">
                         <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2 mb-4">Kontak Darurat</h4>
                         <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Nama Kontak</label>
                                <input wire:model="formProfil.kontak_darurat_nama" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Hubungan</label>
                                <input wire:model="formProfil.kontak_darurat_relasi" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">No. Telepon</label>
                                <input wire:model="formProfil.kontak_darurat_telp" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                         </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <button type="button" wire:click="toggleEditProfil" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-600 font-bold uppercase text-xs">Batal</button>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 text-white font-bold uppercase text-xs shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
            @else
            <!-- VIEW MODE: Profil -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 animate-fade-in">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Identitas Dasar</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">NIK (KTP)</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->nik ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">No. KK</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->kk ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">Tempat, Tanggal Lahir</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->tempat_lahir ?? '-' }}, {{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">Jenis Kelamin</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : ($pegawai->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">Agama</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->agama ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">Status Pernikahan</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->status_pernikahan ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">Alamat</span>
                                    <span class="text-sm font-bold text-slate-800 text-right max-w-[200px]">{{ $pegawai->alamat ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Keuangan & Pajak</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">NPWP</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->npwp ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">Bank & No. Rek</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->nama_bank ?? '-' }} - {{ $pegawai->nomor_rekening ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">BPJS Kesehatan</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->no_bpjs_kesehatan ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-dashed border-slate-100 pb-2">
                                    <span class="text-sm text-slate-500">BPJS Ketenagakerjaan</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->no_bpjs_ketenagakerjaan ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                             <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Kepegawaian</h4>
                             <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-3">
                                 <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">NIP</span>
                                    <span class="text-sm font-black text-slate-800">{{ $pegawai->nip }}</span>
                                 </div>
                                 <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Jabatan</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->jabatan }}</span>
                                 </div>
                                  <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Status</span>
                                    <span class="text-sm font-bold text-blue-600 uppercase">{{ $pegawai->status_kepegawaian }}</span>
                                 </div>
                                 <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Tanggal Masuk</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $pegawai->tanggal_masuk ? \Carbon\Carbon::parse($pegawai->tanggal_masuk)->translatedFormat('d F Y') : '-' }}</span>
                                 </div>
                             </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Kontak Darurat</h4>
                            <div class="bg-rose-50 p-4 rounded-xl border border-rose-100">
                                <p class="text-lg font-black text-rose-700">{{ $pegawai->kontak_darurat_nama ?? '-' }}</p>
                                <div class="flex items-center gap-2 text-rose-500 mt-1">
                                    <span class="text-xs font-bold uppercase">{{ $pegawai->kontak_darurat_relasi ?? 'Relasi N/A' }}</span>
                                    <span>•</span>
                                    <span class="text-sm font-bold">{{ $pegawai->kontak_darurat_telp ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endif

        <!-- 2. TAB KELUARGA -->
        @if($activeTab === 'keluarga')
        <div class="space-y-6 animate-fade-in-up">
            @if($showKeluargaForm)
            <div class="bg-white p-6 rounded-[2rem] border border-blue-200 shadow-lg shadow-blue-500/10">
                <h3 class="font-black text-slate-800 text-lg mb-4">Tambah Anggota Keluarga</h3>
                <form wire:submit="saveKeluarga">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                            <input wire:model="formKeluarga.nama" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                            @error('formKeluarga.nama') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">NIK</label>
                            <input wire:model="formKeluarga.nik" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Hubungan</label>
                            <select wire:model="formKeluarga.hubungan" class="w-full rounded-xl border-slate-200 text-sm">
                                <option value="Istri">Istri</option>
                                <option value="Suami">Suami</option>
                                <option value="Anak">Anak</option>
                                <option value="Orang Tua">Orang Tua</option>
                            </select>
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Lahir</label>
                            <input wire:model="formKeluarga.tanggal_lahir" type="date" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Kelamin</label>
                            <select wire:model="formKeluarga.jenis_kelamin" class="w-full rounded-xl border-slate-200 text-sm">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pekerjaan (Opsional)</label>
                            <input wire:model="formKeluarga.pekerjaan" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                         <div class="md:col-span-2">
                             <label class="flex items-center gap-2">
                                <input wire:model="formKeluarga.status_tunjangan" type="checkbox" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-bold text-slate-700">Masuk dalam tanggungan tunjangan (BPJS/Kesehatan)?</span>
                             </label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showKeluargaForm', false)" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold uppercase">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold uppercase shadow-lg shadow-blue-500/30">Simpan Data</button>
                    </div>
                </form>
            </div>
            @else
            <div class="flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-lg">Daftar Keluarga</h3>
                <button wire:click="$set('showKeluargaForm', true)" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                    + Tambah Anggota
                </button>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pegawai->keluarga as $kel)
                <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm relative group">
                    <button wire:click="deleteKeluarga({{ $kel->id }})" class="absolute top-4 right-4 text-slate-300 hover:text-rose-500 transition-colors" onclick="return confirm('Hapus data keluarga ini?') || event.stopImmediatePropagation()">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-wider">{{ $kel->hubungan }}</span>
                        @if($kel->status_tunjangan)
                        <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-wider">Tertanggung</span>
                        @endif
                    </div>
                    <h4 class="font-bold text-slate-800 text-lg">{{ $kel->nama }}</h4>
                    <p class="text-xs text-slate-500 font-medium mt-1">Lahir: {{ $kel->tanggal_lahir ? \Carbon\Carbon::parse($kel->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p>
                    <div class="mt-4 pt-4 border-t border-dashed border-slate-100 text-xs">
                        <p class="text-slate-400">NIK: <span class="font-bold text-slate-600">{{ $kel->nik ?? '-' }}</span></p>
                    </div>
                </div>
                @empty
                <div class="col-span-full p-8 text-center border-2 border-dashed border-slate-200 rounded-3xl">
                    <p class="text-slate-400 font-bold">Belum ada data keluarga tercatat.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endif

        <!-- 3. TAB PENDIDIKAN -->
        @if($activeTab === 'pendidikan')
        <div class="space-y-6 animate-fade-in-up">
            @if($showPendidikanForm)
             <div class="bg-white p-6 rounded-[2rem] border border-blue-200 shadow-lg shadow-blue-500/10">
                <h3 class="font-black text-slate-800 text-lg mb-4">Tambah Riwayat Pendidikan</h3>
                <form wire:submit="savePendidikan">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenjang</label>
                            <select wire:model="formPendidikan.jenjang" class="w-full rounded-xl border-slate-200 text-sm">
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA/SMK">SMA/SMK</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                                <option value="Non-Formal">Non-Formal</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Institusi</label>
                            <input wire:model="formPendidikan.nama_institusi" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                             @error('formPendidikan.nama_institusi') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jurusan</label>
                            <input wire:model="formPendidikan.jurusan" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tahun Lulus</label>
                            <input wire:model="formPendidikan.tahun_lulus" type="number" class="w-full rounded-xl border-slate-200 text-sm">
                             @error('formPendidikan.tahun_lulus') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">IPK / Nilai</label>
                            <input wire:model="formPendidikan.ipk" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor Ijazah</label>
                            <input wire:model="formPendidikan.nomor_ijazah" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showPendidikanForm', false)" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold uppercase">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold uppercase shadow-lg shadow-blue-500/30">Simpan Data</button>
                    </div>
                </form>
            </div>
            @else
            <div class="flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-lg">Riwayat Pendidikan</h3>
                <button wire:click="$set('showPendidikanForm', true)" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                    + Tambah Pendidikan
                </button>
            </div>
            @endif

            <div class="relative border-l-2 border-slate-100 ml-4 space-y-8">
                @forelse($pegawai->pendidikan as $pend)
                <div class="relative pl-8 group">
                    <div class="absolute -left-[9px] top-0 w-4 h-4 bg-white border-2 border-blue-500 rounded-full group-hover:bg-blue-500 transition-colors"></div>
                    <button wire:click="deletePendidikan({{ $pend->id }})" class="absolute top-0 right-0 text-slate-300 hover:text-rose-500 opacity-0 group-hover:opacity-100 transition-all" onclick="return confirm('Hapus riwayat ini?') || event.stopImmediatePropagation()">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                        <span class="text-sm font-black text-blue-600">{{ $pend->tahun_lulus }}</span>
                        <span class="hidden sm:inline text-slate-300">•</span>
                        <h4 class="font-bold text-slate-800">{{ $pend->nama_institusi }}</h4>
                    </div>
                    <div class="text-sm text-slate-600">
                        <span class="font-bold">{{ $pend->jenjang }}</span> {{ $pend->jurusan ? '- '.$pend->jurusan : '' }}
                    </div>
                    @if($pend->ipk)
                    <p class="text-xs text-slate-500 mt-1">IPK/Nilai: {{ $pend->ipk }}</p>
                    @endif
                </div>
                @empty
                <div class="pl-8 text-slate-400 text-sm">Belum ada riwayat pendidikan.</div>
                @endforelse
            </div>
        </div>
        @endif

         <!-- 4. TAB DOKUMEN -->
        @if($activeTab === 'dokumen')
        <div class="space-y-6 animate-fade-in-up">
            @if($showDokumenForm)
             <div class="bg-white p-6 rounded-[2rem] border border-blue-200 shadow-lg shadow-blue-500/10">
                <h3 class="font-black text-slate-800 text-lg mb-4">Upload Dokumen Digital</h3>
                <form wire:submit="saveDokumen">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="md:col-span-2">
                             <label class="block text-xs font-bold text-slate-500 uppercase mb-1">File Dokumen (PDF/JPG/PNG Max 5MB)</label>
                             <input type="file" wire:model="uploadFile" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                             @error('uploadFile') <span class="text-rose-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Dokumen</label>
                            <input wire:model="formDokumen.nama_dokumen" type="text" placeholder="Contoh: KTP, Ijazah S1" class="w-full rounded-xl border-slate-200 text-sm">
                             @error('formDokumen.nama_dokumen') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label>
                            <select wire:model="formDokumen.kategori_dokumen" class="w-full rounded-xl border-slate-200 text-sm">
                                <option value="Identitas">Identitas (KTP/KK)</option>
                                <option value="Pendidikan">Pendidikan (Ijazah/Transkrip)</option>
                                <option value="Kompetensi">Kompetensi (Sertifikat)</option>
                                <option value="Legalitas">Legalitas (STR/SIP/SK)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Kadaluarsa (Opsional)</label>
                            <input wire:model="formDokumen.tanggal_kadaluarsa" type="date" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Keterangan (Opsional)</label>
                            <input wire:model="formDokumen.keterangan" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showDokumenForm', false)" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold uppercase">Batal</button>
                        <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold uppercase shadow-lg shadow-blue-500/30">
                            <span wire:loading.remove>Upload</span>
                            <span wire:loading>Uploading...</span>
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-lg">Arsip Digital</h3>
                <button wire:click="$set('showDokumenForm', true)" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                    + Upload Dokumen
                </button>
            </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($pegawai->dokumen as $doc)
                <div class="group relative bg-slate-50 rounded-2xl p-4 border border-slate-100 hover:shadow-lg transition-all text-center">
                    <button wire:click="deleteDokumen({{ $doc->id }})" class="absolute top-2 right-2 p-1 bg-white rounded-full text-slate-300 hover:text-rose-500 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-10" onclick="return confirm('Hapus dokumen ini permanen?') || event.stopImmediatePropagation()">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="block">
                        <div class="w-16 h-16 mx-auto mb-3 bg-white rounded-xl flex items-center justify-center text-slate-400 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800 truncate px-2">{{ $doc->nama_dokumen }}</h4>
                        <p class="text-[10px] text-slate-500 uppercase font-bold">{{ $doc->kategori_dokumen }}</p>
                    </a>
                </div>
                @empty
                <div class="col-span-full p-8 text-center border-2 border-dashed border-slate-200 rounded-3xl">
                    <p class="text-slate-400 font-bold">Belum ada dokumen diunggah.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endif

        <!-- 5. TAB KARIR -->
        @if($activeTab === 'karir')
        <div class="space-y-6 animate-fade-in-up">
            @if($showKarirForm)
            <div class="bg-white p-6 rounded-[2rem] border border-blue-200 shadow-lg shadow-blue-500/10">
                <h3 class="font-black text-slate-800 text-lg mb-4">Catat Mutasi / Promosi Jabatan</h3>
                <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 mb-6 text-xs text-amber-800 font-medium">
                    Perhatian: Mencatat riwayat ini akan otomatis memperbarui Jabatan Aktif pegawai saat ini.
                </div>
                <form wire:submit="saveKarir">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jenis Perubahan</label>
                            <select wire:model="formKarir.jenis_mutasi" class="w-full rounded-xl border-slate-200 text-sm">
                                <option value="Promosi">Promosi</option>
                                <option value="Mutasi">Mutasi</option>
                                <option value="Demosi">Demosi</option>
                                <option value="Pengangkatan">Pengangkatan Pertama</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Mulai Efektif</label>
                            <input wire:model="formKarir.tanggal_mulai" type="date" class="w-full rounded-xl border-slate-200 text-sm">
                            @error('formKarir.tanggal_mulai') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jabatan Baru</label>
                            <input wire:model="formKarir.jabatan_baru" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                            @error('formKarir.jabatan_baru') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Unit Kerja Baru</label>
                            <input wire:model="formKarir.unit_kerja_baru" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nomor SK</label>
                            <input wire:model="formKarir.nomor_sk" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Keterangan</label>
                            <input wire:model="formKarir.keterangan" type="text" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showKarirForm', false)" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold uppercase">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 text-white text-xs font-bold uppercase shadow-lg shadow-blue-500/30">Simpan & Update</button>
                    </div>
                </form>
            </div>
            @else
            <div class="flex justify-between items-center">
                <h3 class="font-black text-slate-800 text-lg">Riwayat Jabatan</h3>
                <button wire:click="$set('showKarirForm', true)" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                    + Catat Mutasi
                </button>
            </div>
            @endif

             <div class="space-y-4">
                @forelse($pegawai->riwayatJabatan as $karir)
                <div class="bg-white p-5 rounded-3xl border border-slate-100 flex items-start gap-4">
                    <div class="flex flex-col items-center justify-center w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200 shrink-0">
                         <span class="text-xs font-black text-slate-400">{{ \Carbon\Carbon::parse($karir->tanggal_mulai)->format('Y') }}</span>
                         <span class="text-lg font-black text-slate-800">{{ \Carbon\Carbon::parse($karir->tanggal_mulai)->format('d M') }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-slate-800 text-lg">{{ $karir->jabatan_baru }}</h4>
                            <span class="px-2 py-1 rounded bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-wider">{{ $karir->jenis_mutasi }}</span>
                        </div>
                        <p class="text-sm text-slate-500">{{ $karir->unit_kerja_baru ?? 'Unit Tidak Spesifik' }}</p>
                        @if($karir->nomor_sk)
                        <p class="text-xs text-slate-400 mt-2 font-mono bg-slate-50 inline-block px-2 py-1 rounded border border-slate-100">SK: {{ $karir->nomor_sk }}</p>
                        @endif
                    </div>
                </div>
                @empty
                 <div class="p-8 text-center border-2 border-dashed border-slate-200 rounded-3xl">
                    <p class="text-slate-400 font-bold">Belum ada riwayat mutasi/promosi.</p>
                </div>
                @endforelse
             </div>
        </div>
        @endif

    </div>
</div>