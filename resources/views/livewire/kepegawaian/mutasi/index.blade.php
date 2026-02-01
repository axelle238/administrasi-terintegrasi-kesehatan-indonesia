<div class="space-y-6 animate-fade-in pb-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-800">Manajemen Karir & Mutasi</h2>
            <p class="text-sm text-slate-500">Kelola promosi, demosi, dan rotasi jabatan pegawai.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            Buat Usulan Baru
        </button>
    </div>

    <!-- Stats / Tabs -->
    <div class="flex gap-2 overflow-x-auto pb-2">
        <button wire:click="$set('filterStatus', 'Pending')" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ $filterStatus == 'Pending' ? 'bg-amber-100 text-amber-700' : 'bg-white text-slate-500 hover:bg-slate-50' }}">
            Menunggu Persetujuan
            @if($countPending > 0) <span class="ml-2 px-2 py-0.5 bg-amber-200 text-amber-800 rounded-lg text-xs">{{ $countPending }}</span> @endif
        </button>
        <button wire:click="$set('filterStatus', 'Disetujui')" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ $filterStatus == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-white text-slate-500 hover:bg-slate-50' }}">
            Riwayat Disetujui
        </button>
        <button wire:click="$set('filterStatus', 'Ditolak')" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ $filterStatus == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-white text-slate-500 hover:bg-slate-50' }}">
            Ditolak
        </button>
    </div>

    <!-- Form Panel (Inline) -->
    @if($isCreating)
    <div class="bg-white p-8 rounded-[2.5rem] border border-indigo-100 shadow-xl relative overflow-hidden animate-fade-in-up">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-widest">Formulir Mutasi Jabatan</h3>
            <button wire:click="cancel" class="p-2 text-slate-400 hover:text-slate-600 bg-slate-50 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-3">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pegawai</label>
                <select wire:model="pegawai_id" class="w-full rounded-xl border-slate-200 font-bold text-slate-700 focus:ring-indigo-500">
                    <option value="">Pilih Pegawai...</option>
                    @foreach($pegawais as $p)
                        <option value="{{ $p->id }}">{{ $p->user->name }} - {{ $p->jabatan }}</option>
                    @endforeach
                </select>
                @error('pegawai_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Jenis Perubahan</label>
                <select wire:model="jenis_perubahan" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                    <option value="">Pilih...</option>
                    <option value="Promosi">Promosi (Naik Jabatan)</option>
                    <option value="Mutasi">Mutasi (Rotasi Unit)</option>
                    <option value="Demosi">Demosi (Turun Jabatan)</option>
                    <option value="Penugasan">Penugasan Khusus</option>
                </select>
                @error('jenis_perubahan') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Jabatan Baru</label>
                <input type="text" wire:model="jabatan_baru" class="w-full rounded-xl border-slate-200 font-bold text-slate-700" placeholder="Contoh: Kepala Ruangan">
                @error('jabatan_baru') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Unit Kerja Baru</label>
                <select wire:model="unit_kerja_baru" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                    <option value="">Pilih Unit...</option>
                    <option value="Manajemen">Manajemen Pusat</option>
                    @foreach($polis as $poli)
                        <option value="{{ $poli->nama_poli }}">{{ $poli->nama_poli }}</option>
                    @endforeach
                </select>
                @error('unit_kerja_baru') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Efektif</label>
                <input type="date" wire:model="tanggal_efektif" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                @error('tanggal_efektif') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="lg:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nomor SK / Referensi</label>
                <input type="text" wire:model="nomor_sk" class="w-full rounded-xl border-slate-200 font-bold text-slate-700" placeholder="No. Surat Keputusan">
            </div>
            
            <div class="lg:col-span-3">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Keterangan Tambahan</label>
                <textarea wire:model="keterangan" class="w-full rounded-xl border-slate-200 font-bold text-slate-700" rows="3"></textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50">Batal</button>
            <button wire:click="save" class="px-8 py-2.5 rounded-xl bg-indigo-600 text-white font-bold shadow-lg hover:bg-indigo-700">Kirim Pengajuan</button>
        </div>
    </div>
    @endif

    <!-- Data List -->
    <div class="space-y-4">
        @forelse($mutasis as $m)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:border-indigo-200 transition-all relative overflow-hidden group">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4 relative z-10">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-black text-lg border-2 border-white shadow-sm">
                        {{ substr($m->pegawai->user->name ?? '?', 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-lg">{{ $m->pegawai->user->name ?? 'Pegawai' }}</h4>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs font-medium text-slate-500">{{ $m->jabatan_lama }}</span>
                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">{{ $m->jabatan_baru }}</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-2 font-mono">Efektif: {{ \Carbon\Carbon::parse($m->tanggal_efektif)->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-3">
                    <span class="px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider {{ $m->status_pengajuan == 'Pending' ? 'bg-amber-100 text-amber-700' : ($m->status_pengajuan == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                        {{ $m->status_pengajuan }}
                    </span>
                    
                    @if($m->status_pengajuan == 'Pending')
                    <div class="flex gap-2 mt-2">
                        <button wire:click="reject({{ $m->id }})" wire:confirm="Tolak pengajuan mutasi ini?" class="px-4 py-2 bg-white border border-slate-200 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-xl text-xs font-bold transition-colors">Tolak</button>
                        <button wire:click="approve({{ $m->id }})" wire:confirm="Setujui mutasi? Jabatan pegawai akan diperbarui." class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-xl text-xs font-bold transition-colors shadow-lg shadow-indigo-600/20">Setujui</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
            <p class="text-slate-400 font-bold">Tidak ada data mutasi dengan status ini.</p>
        </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $mutasis->links() }}
    </div>
</div>