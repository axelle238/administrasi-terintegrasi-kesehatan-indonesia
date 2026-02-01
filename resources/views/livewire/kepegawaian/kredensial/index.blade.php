<div class="space-y-6 animate-fade-in pb-20">
    
    <!-- 1. Header & Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Expired Card -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer" wire:click="$set('filterStatus', 'expired')">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Dokumen Expired</p>
            <h3 class="text-4xl font-black text-red-600 mt-2">{{ $countExpired }}</h3>
            <p class="text-xs font-bold text-red-400 mt-1">Perlu Tindakan Segera</p>
        </div>

        <!-- Warning Card -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group cursor-pointer" wire:click="$set('filterStatus', 'warning')">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-24 h-24 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akan Expired (3 Bulan)</p>
            <h3 class="text-4xl font-black text-amber-500 mt-2">{{ $countWarning }}</h3>
            <p class="text-xs font-bold text-amber-400 mt-1">Siapkan Perpanjangan</p>
        </div>

        <!-- Add New Action -->
        <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white p-6 rounded-[2rem] shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-1 flex flex-col items-center justify-center gap-3">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <span class="font-black text-sm uppercase tracking-widest">Input Dokumen Baru</span>
        </button>
    </div>

    <!-- 2. Form Panel (Inline) -->
    @if($isCreating || $isEditing)
    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-blue-100 animate-fade-in-up relative overflow-hidden">
        <div class="flex justify-between items-center mb-6 relative z-10">
            <div>
                <h3 class="text-xl font-black text-slate-800">{{ $isEditing ? 'Perbarui Dokumen' : 'Registrasi Dokumen Baru' }}</h3>
                <p class="text-sm text-slate-500">Pastikan data sesuai dengan fisik dokumen asli.</p>
            </div>
            <button wire:click="cancel" class="p-2 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                <svg class="w-6 h-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 relative z-10">
            <!-- Pegawai -->
            <div class="lg:col-span-3">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pemilik Dokumen</label>
                <select wire:model="pegawai_id" class="w-full rounded-xl border-slate-200 font-bold text-slate-700 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Pegawai...</option>
                    @foreach($pegawais as $p)
                        <option value="{{ $p->id }}">{{ $p->user->name }} - {{ $p->jabatan }}</option>
                    @endforeach
                </select>
                @error('pegawai_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- Jenis & Nomor -->
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Jenis Dokumen</label>
                <select wire:model="jenis_dokumen" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                    <option value="">Pilih Jenis...</option>
                    <option value="STR">STR (Surat Tanda Registrasi)</option>
                    <option value="SIP">SIP (Surat Izin Praktik)</option>
                    <option value="SIK">SIK (Surat Izin Kerja)</option>
                    <option value="Sertifikat">Sertifikat Kompetensi</option>
                </select>
                @error('jenis_dokumen') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nomor Dokumen</label>
                <input type="text" wire:model="nomor_dokumen" class="w-full rounded-xl border-slate-200 font-bold text-slate-700" placeholder="Contoh: 123/STR/2024">
                @error('nomor_dokumen') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Penerbit</label>
                <input type="text" wire:model="penerbit" class="w-full rounded-xl border-slate-200 font-bold text-slate-700" placeholder="Contoh: Kemenkes RI">
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Terbit</label>
                <input type="date" wire:model="tanggal_terbit" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                @error('tanggal_terbit') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Berakhir</label>
                <input type="date" wire:model="tanggal_berakhir" class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                @error('tanggal_berakhir') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Scan Dokumen (PDF/JPG)</label>
                <input type="file" wire:model="file_dokumen" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                @error('file_dokumen') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-6 relative z-10">
            <button wire:click="cancel" class="px-6 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition-all">Batal</button>
            <button wire:click="save" class="px-8 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-sm shadow-lg shadow-blue-600/30 hover:bg-blue-700 transition-all">Simpan Data</button>
        </div>
    </div>
    @endif

    <!-- 3. Data Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <!-- Toolbar -->
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex gap-2">
                @foreach(['all' => 'Semua', 'active' => 'Aktif', 'warning' => 'Warning', 'expired' => 'Expired'] as $key => $label)
                    <button wire:click="$set('filterStatus', '{{ $key }}')" 
                        class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all {{ $filterStatus === $key ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
            <div class="relative w-full md:w-64">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari dokumen / nama..." class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border-none text-sm font-bold focus:ring-2 focus:ring-blue-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] uppercase font-black text-slate-400 tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Pegawai</th>
                        <th class="px-6 py-4">Dokumen</th>
                        <th class="px-6 py-4">Masa Berlaku</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($kredensials as $k)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $k->pegawai->user->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-slate-500">{{ $k->pegawai->jabatan ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-blue-600">{{ $k->jenis_dokumen }}</div>
                            <div class="text-xs font-mono text-slate-500">{{ $k->nomor_dokumen }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-700">{{ $k->tanggal_berakhir->format('d M Y') }}</span>
                                <span class="text-xs text-slate-400">({{ $k->tanggal_berakhir->diffForHumans() }})</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $status = $k->status_masa_berlaku; // Accessor
                                $badgeClass = match($status) {
                                    'Expired' => 'bg-red-100 text-red-700',
                                    'Warning' => 'bg-amber-100 text-amber-700',
                                    default => 'bg-emerald-100 text-emerald-700'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $badgeClass }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($k->file_dokumen)
                                    <a href="{{ Storage::url($k->file_dokumen) }}" target="_blank" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-blue-100 hover:text-blue-600" title="Lihat File">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                @endif
                                <button wire:click="edit({{ $k->id }})" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-amber-100 hover:text-amber-600" title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="delete({{ $k->id }})" wire:confirm="Hapus dokumen ini?" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-red-100 hover:text-red-600" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-slate-400 italic">Tidak ada data kredensial ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">
            {{ $kredensials->links() }}
        </div>
    </div>
</div>