<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-up">
    <!-- Informasi Pribadi -->
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm h-full">
        <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <h3 class="font-black text-slate-800 text-lg">Informasi Pribadi</h3>
        </div>
        
        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="font-bold text-slate-800">{{ $pegawai->user->name }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Email Akun</p>
                    <p class="font-bold text-slate-800">{{ $pegawai->user->email }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">NIP / NIK</p>
                    <p class="font-bold text-slate-800">{{ $pegawai->nip ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Lahir</p>
                    <p class="font-bold text-slate-800">{{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Domisili</p>
                <p class="font-medium text-slate-600 text-sm leading-relaxed">{{ $pegawai->alamat ?? 'Belum diisi' }}</p>
            </div>

            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kontak Darurat</p>
                @if($pegawai->kontak_darurat_nama)
                    <div class="bg-red-50 border border-red-100 p-3 rounded-xl flex items-center justify-between">
                        <span class="text-xs font-bold text-red-700">{{ $pegawai->kontak_darurat_nama }}</span>
                        <span class="text-xs font-mono text-red-600 bg-white px-2 py-1 rounded">{{ $pegawai->kontak_darurat_telp }}</span>
                    </div>
                @else
                    <p class="text-sm text-slate-400 italic">Tidak ada data kontak darurat.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Informasi Kepegawaian -->
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm h-full">
        <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <h3 class="font-black text-slate-800 text-lg">Status Kepegawaian</h3>
        </div>

        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jabatan Saat Ini</p>
                    <p class="font-bold text-slate-800">{{ $pegawai->jabatan }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Unit Kerja / Poli</p>
                    <p class="font-bold text-slate-800">{{ $pegawai->poli->nama_poli ?? 'Umum / Staff' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status</p>
                    <span class="inline-block px-3 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600 uppercase">{{ $pegawai->status_kepegawaian }}</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Masuk</p>
                    <p class="font-bold text-slate-800">{{ $pegawai->tanggal_masuk ? \Carbon\Carbon::parse($pegawai->tanggal_masuk)->translatedFormat('d F Y') : '-' }}</p>
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 mt-4">
                <div class="flex justify-between items-center mb-2">
                    <p class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">Sisa Cuti Tahunan</p>
                    <span class="text-xl font-black text-blue-600">{{ $pegawai->sisa_cuti }} / {{ $pegawai->kuota_cuti_tahunan }}</span>
                </div>
                <div class="w-full bg-white rounded-full h-2">
                    @php $persenCuti = $pegawai->kuota_cuti_tahunan > 0 ? ($pegawai->sisa_cuti / $pegawai->kuota_cuti_tahunan) * 100 : 0; @endphp
                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ $persenCuti }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="mt-8 pt-6 border-t border-dashed border-slate-200">
            <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="w-full py-3 flex items-center justify-center gap-2 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-700 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Edit Data Lengkap
            </a>
        </div>
    </div>
</div>