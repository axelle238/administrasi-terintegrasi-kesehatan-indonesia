<div class="space-y-6 animate-fade-in pb-20">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-black text-slate-800">Manajemen Terminasi Pegawai</h2>
            <p class="text-sm text-slate-500">Proses pengunduran diri, PHK, dan pensiun.</p>
        </div>
        <button wire:click="create" class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-rose-600/20 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Input Pengunduran Diri
        </button>
    </div>

    <!-- Status Filter -->
    <div class="flex gap-2 overflow-x-auto pb-2">
        @foreach(['Pending', 'Disetujui', 'Ditolak'] as $status)
            <button wire:click="$set('filterStatus', '{{ $status }}')" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ $filterStatus == $status ? 'bg-slate-800 text-white' : 'bg-white text-slate-500 hover:bg-slate-50' }}">
                {{ $status }}
            </button>
        @endforeach
    </div>

    <!-- CREATE FORM -->
    @if($isCreating)
    <div class="bg-white p-8 rounded-[2.5rem] border border-rose-100 shadow-xl relative overflow-hidden animate-fade-in-up">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rose-500 to-orange-500"></div>
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-widest">Formulir Terminasi</h3>
            <button wire:click="cancel" class="p-2 text-slate-400 hover:text-slate-600 bg-slate-50 rounded-lg">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pegawai</label>
                <select wire:model="pegawai_id" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                    <option value="">Pilih Pegawai...</option>
                    @foreach($pegawais as $p)
                        <option value="{{ $p->id }}">{{ $p->user->name }} - {{ $p->jabatan }}</option>
                    @endforeach
                </select>
                @error('pegawai_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Jenis Terminasi</label>
                <select wire:model="jenis_berhenti" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                    <option value="Resign">Resign (Mengundurkan Diri)</option>
                    <option value="PHK">PHK</option>
                    <option value="Pensiun">Pensiun</option>
                    <option value="Meninggal">Meninggal Dunia</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Pengajuan</label>
                <input type="date" wire:model="tanggal_pengajuan" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Efektif Keluar</label>
                <input type="date" wire:model="tanggal_efektif_keluar" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Surat Pengunduran Diri (PDF)</label>
                <input type="file" wire:model="file_surat" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Alasan</label>
                <textarea wire:model="alasan" class="w-full rounded-xl border-slate-200 font-bold text-slate-700" rows="3"></textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 font-bold text-slate-600 hover:bg-slate-50">Batal</button>
            <button wire:click="save" class="px-8 py-2.5 rounded-xl bg-rose-600 text-white font-bold shadow-lg hover:bg-rose-700">Simpan Pengajuan</button>
        </div>
    </div>
    @endif

    <!-- CLEARANCE PANEL (APPROVAL) -->
    @if($selectedPengajuanId)
    <div class="bg-white p-8 rounded-[2.5rem] border border-blue-100 shadow-xl animate-fade-in-up mb-6">
        <h3 class="text-lg font-black text-slate-800 mb-6 border-b border-slate-100 pb-4">Checklist Offboarding & Persetujuan</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:border-blue-300 {{ $clearance_aset ? 'bg-blue-50 border-blue-200' : '' }}">
                <input type="checkbox" wire:model="clearance_aset" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                <span class="text-sm font-bold text-slate-700">Aset Dikembalikan</span>
            </label>
            <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:border-blue-300 {{ $clearance_keuangan ? 'bg-blue-50 border-blue-200' : '' }}">
                <input type="checkbox" wire:model="clearance_keuangan" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                <span class="text-sm font-bold text-slate-700">Bebas Tanggungan Keuangan</span>
            </label>
            <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:border-blue-300 {{ $clearance_dokumen ? 'bg-blue-50 border-blue-200' : '' }}">
                <input type="checkbox" wire:model="clearance_dokumen" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                <span class="text-sm font-bold text-slate-700">Serah Terima Dokumen/Akses</span>
            </label>
        </div>

        <div class="mb-6">
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Catatan HRD</label>
            <textarea wire:model="catatan_hrd" class="w-full rounded-xl border-slate-200 font-bold text-slate-700" rows="2" placeholder="Catatan final..."></textarea>
        </div>

        @error('clearance_check') <p class="text-red-500 text-sm font-bold mb-4">{{ $message }}</p> @enderror

        <div class="flex justify-end gap-3">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 font-bold text-slate-600">Batal</button>
            <button wire:click="reject" class="px-6 py-2.5 rounded-xl bg-red-100 text-red-700 font-bold hover:bg-red-200">Tolak</button>
            <button wire:click="approve" class="px-8 py-2.5 rounded-xl bg-blue-600 text-white font-bold shadow-lg hover:bg-blue-700">Setujui & Non-Aktifkan Pegawai</button>
        </div>
    </div>
    @endif

    <!-- Data List -->
    <div class="space-y-4">
        @forelse($pengajuans as $p)
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:border-rose-200 transition-all flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-black">
                    {{ substr($p->pegawai->user->name ?? 'X', 0, 1) }}
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-lg">{{ $p->pegawai->user->name ?? 'Unknown' }}</h4>
                    <p class="text-sm text-slate-500">{{ $p->jenis_berhenti }} • Efektif: {{ $p->tanggal_efektif_keluar->format('d M Y') }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                @if($p->status_approval == 'Pending')
                    <button wire:click="openClearance({{ $p->id }})" class="px-5 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 shadow-lg">
                        Proses Clearance
                    </button>
                @else
                    <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider {{ $p->status_approval == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ $p->status_approval }}
                    </span>
                @endif
            </div>
        </div>
        @empty
        <div class="p-12 text-center bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
            <p class="text-slate-400 font-bold">Tidak ada data pengajuan.</p>
        </div>
        @endforelse
    </div>
    
    <div class="mt-6">
        {{ $pengajuans->links() }}
    </div>
</div>