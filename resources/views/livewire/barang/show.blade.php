<div class="space-y-8 animate-fade-in">
    <!-- Header: Identitas Utama & QR -->
    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="flex flex-col lg:flex-row gap-8 items-start relative z-10">
            <!-- Gambar / Icon -->
            <div class="w-32 h-32 rounded-3xl bg-slate-50 border border-slate-100 flex items-center justify-center overflow-hidden shrink-0">
                @if($barang->gambar)
                    <img src="{{ Storage::url($barang->gambar) }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                @endif
            </div>

            <!-- Detail Utama -->
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-black uppercase tracking-wider">
                        {{ $barang->jenis_aset }}
                    </span>
                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase tracking-wider">
                        {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                    @if($barang->is_asset)
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold uppercase tracking-wider">Aset Tetap</span>
                    @endif
                </div>
                
                <h1 class="text-3xl font-black text-slate-800 mb-1">{{ $barang->nama_barang }}</h1>
                <p class="text-slate-500 font-mono text-sm font-bold bg-slate-50 inline-block px-2 py-1 rounded mb-4">{{ $barang->kode_barang }}</p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Merk / Brand</p>
                        <p class="text-sm font-bold text-slate-700">{{ $barang->merk ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Lokasi</p>
                        <p class="text-sm font-bold text-slate-700">{{ $barang->ruangan->nama_ruangan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Kondisi</p>
                        <span class="text-sm font-bold {{ $barang->kondisi == 'Baik' ? 'text-emerald-600' : 'text-rose-600' }}">{{ $barang->kondisi }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Stok Total</p>
                        <p class="text-xl font-black text-blue-600">{{ $barang->stok }} <span class="text-xs font-normal text-slate-500">{{ $barang->satuan }}</span></p>
                    </div>
                </div>
            </div>

            <!-- QR Code (Placeholder) -->
            <div class="shrink-0 text-center">
                <div class="bg-white p-2 rounded-xl border border-slate-200 shadow-sm">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $barang->kode_barang }}" class="w-24 h-24 rounded-lg" alt="QR Code">
                </div>
                <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest">Scan Identitas</p>
            </div>
        </div>
        
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 rounded-bl-full -mr-16 -mt-16 -z-0 pointer-events-none"></div>
    </div>

    <!-- Main Content Tabs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Navigation -->
        <div class="space-y-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 sticky top-24">
                <nav class="space-y-2">
                    <button wire:click="aturTab('ringkasan')" class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $tabAktif == 'ringkasan' ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                        Ringkasan & Spesifikasi
                    </button>
                    @if($barang->jenis_aset == 'Medis')
                    <button wire:click="aturTab('medis')" class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $tabAktif == 'medis' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                        Data Medis & Regulasi
                    </button>
                    @endif
                    @if($barang->is_asset)
                    <button wire:click="aturTab('keuangan')" class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $tabAktif == 'keuangan' ? 'bg-amber-50 text-amber-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                        Keuangan & Penyusutan
                    </button>
                    @endif
                    <button wire:click="aturTab('riwayat')" class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold transition-all {{ $tabAktif == 'riwayat' ? 'bg-purple-50 text-purple-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                        Riwayat Aktivitas
                    </button>
                </nav>

                <div class="mt-8 pt-6 border-t border-slate-100 space-y-3">
                    <a href="{{ route('barang.maintenance.create.specific', $barang->id) }}" class="block w-full py-3 bg-amber-500 text-white font-bold rounded-xl text-xs uppercase tracking-widest text-center hover:bg-amber-600 transition shadow-lg shadow-amber-500/20">
                        Jadwalkan Maintenance
                    </a>
                    <a href="{{ route('barang.mutasi.create') }}?barang_id={{ $barang->id }}" class="block w-full py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl text-xs uppercase tracking-widest text-center hover:bg-slate-50 transition">
                        Mutasi Aset
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- TAB: RINGKASAN -->
            @if($tabAktif == 'ringkasan')
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 animate-fade-in-up">
                <h3 class="text-xl font-black text-slate-800 mb-6">Spesifikasi Teknis</h3>
                <div class="prose prose-slate prose-sm max-w-none mb-8">
                    @if($barang->spesifikasi || $barang->spesifikasi_teknis)
                        <p>{{ $barang->spesifikasi }}</p>
                        <p>{{ $barang->spesifikasi_teknis }}</p>
                    @else
                        <p class="text-slate-400 italic">Belum ada data spesifikasi teknis.</p>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Nomor Seri (SN)</p>
                        <p class="text-slate-800 font-mono font-bold">{{ $barang->nomor_seri ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Label Inventaris</p>
                        <p class="text-slate-800 font-mono font-bold">{{ $barang->nomor_inventaris ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Tanggal Pengadaan</p>
                        <p class="text-slate-800 font-bold">{{ $barang->tanggal_pengadaan ? \Carbon\Carbon::parse($barang->tanggal_pengadaan)->translatedFormat('d F Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Supplier</p>
                        <p class="text-slate-800 font-bold">{{ $barang->supplier->nama_supplier ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- TAB: MEDIS -->
            @if($tabAktif == 'medis')
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 animate-fade-in-up">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800">Detail Medis & Regulasi</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-emerald-50/50 p-6 rounded-3xl border border-emerald-100">
                        <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">Izin Edar & Distribusi</p>
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-slate-500">Nomor Izin Edar (AKL/AKD)</span>
                                <p class="font-bold text-slate-800">{{ $barang->nomor_izin_edar ?? 'Belum diinput' }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-slate-500">Distributor Resmi</span>
                                <p class="font-bold text-slate-800">{{ $barang->distributor ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-2">Status Kalibrasi</p>
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-slate-500">Terakhir Kalibrasi</span>
                                <p class="font-bold text-slate-800">{{ $barang->tanggal_kalibrasi_terakhir ? \Carbon\Carbon::parse($barang->tanggal_kalibrasi_terakhir)->translatedFormat('d F Y') : '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-slate-500">Jadwal Berikutnya</span>
                                <p class="font-bold {{ $barang->tanggal_kalibrasi_berikutnya && \Carbon\Carbon::parse($barang->tanggal_kalibrasi_berikutnya)->isPast() ? 'text-rose-600' : 'text-slate-800' }}">
                                    {{ $barang->tanggal_kalibrasi_berikutnya ? \Carbon\Carbon::parse($barang->tanggal_kalibrasi_berikutnya)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- TAB: KEUANGAN -->
            @if($tabAktif == 'keuangan')
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 animate-fade-in-up">
                <h3 class="text-xl font-black text-slate-800 mb-6">Valuasi & Penyusutan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Harga Perolehan</p>
                        <p class="text-lg font-black text-slate-800">Rp {{ number_format($barang->harga_perolehan, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Nilai Buku (Saat Ini)</p>
                        <p class="text-lg font-black text-blue-600">Rp {{ number_format($barang->nilai_buku, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Nilai Residu</p>
                        <p class="text-lg font-black text-slate-600">Rp {{ number_format($barang->nilai_residu, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="space-y-2 text-sm text-slate-600 bg-slate-50 p-6 rounded-3xl">
                    <div class="flex justify-between">
                        <span>Sumber Dana</span>
                        <span class="font-bold">{{ $barang->sumber_dana ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Masa Manfaat</span>
                        <span class="font-bold">{{ $barang->masa_manfaat }} Tahun</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Metode Penyusutan</span>
                        <span class="font-bold">{{ $barang->metode_penyusutan ?? 'Garis Lurus' }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- TAB: RIWAYAT -->
            @if($tabAktif == 'riwayat')
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 animate-fade-in-up">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-slate-800">Linimasa Aktivitas</h3>
                    
                    <!-- Form Transaksi Cepat Inline -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition">
                            + Catat Mutasi Manual
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute right-0 top-10 w-72 bg-white rounded-2xl shadow-xl border border-slate-100 p-4 z-50">
                            <form wire:submit="simpanTransaksi" class="space-y-3">
                                <select wire:model="jenis_transaksi" class="w-full text-xs rounded-lg border-slate-200">
                                    <option value="Masuk">Stok Masuk (+)</option>
                                    <option value="Keluar">Stok Keluar (-)</option>
                                </select>
                                <input type="number" wire:model="jumlah" placeholder="Jumlah" class="w-full text-xs rounded-lg border-slate-200">
                                <input type="text" wire:model="keterangan" placeholder="Keterangan" class="w-full text-xs rounded-lg border-slate-200">
                                <button type="submit" class="w-full bg-blue-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="relative border-l-2 border-slate-100 ml-3 space-y-8">
                    @forelse($timeline as $log)
                    <div class="relative pl-8">
                        <div class="absolute -left-[11px] top-0 h-6 w-6 rounded-full border-4 border-white bg-slate-200"></div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                            <div>
                                <span class="text-[10px] font-black uppercase text-slate-500 bg-slate-100 px-2 py-0.5 rounded tracking-wider">
                                    {{ $log['type'] }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-800 mt-1">
                                    {{ $log['data']->jenis_transaksi ?? $log['data']->jenis_kegiatan ?? 'Aktivitas' }}
                                </h4>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $log['data']->keterangan ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-slate-600">{{ \Carbon\Carbon::parse($log['date'])->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 py-10 italic">Belum ada riwayat tercatat.</p>
                    @endforelse
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
