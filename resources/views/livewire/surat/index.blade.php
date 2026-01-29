<div class="space-y-8">
    
    <!-- Row 1: Key Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Surat Masuk -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Surat Masuk</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $totalSuratMasuk }}</h3>
                </div>
            </div>
            <div class="mt-4 text-xs font-medium text-slate-500">
                <span class="text-green-600 font-bold">+{{ $suratMasukBulanIni }}</span> bulan ini
            </div>
        </div>

        <!-- Surat Keluar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Surat Keluar</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $totalSuratKeluar }}</h3>
                </div>
            </div>
            <div class="mt-4 text-xs font-medium text-slate-500">
                <span class="text-blue-600 font-bold">+{{ $suratKeluarBulanIni }}</span> bulan ini
            </div>
        </div>

        <!-- Pending Disposisi -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700 relative overflow-hidden">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Perlu Disposisi</p>
                    <h3 class="text-2xl font-black text-slate-800">{{ $suratBelumDisposisi }}</h3>
                </div>
            </div>
            <div class="mt-4 text-xs font-medium text-amber-600">
                Tindak lanjuti segera
            </div>
        </div>

        <!-- Shortcut -->
        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg flex flex-col justify-center gap-3">
            <a href="{{ route('surat.create') }}" class="w-full text-center px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-sm font-bold rounded-xl transition backdrop-blur-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Catat Surat Baru
            </a>
        </div>
    </div>

    <!-- Row 2: Charts & Data Table -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grafik -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Volume Surat (6 Bulan)</h3>
            <div class="h-64 flex items-end justify-between gap-3 px-2">
                @foreach($grafikSurat['labels'] as $index => $label)
                    <div class="flex flex-col items-center flex-1 h-full justify-end group gap-1">
                        <!-- Stacked Bar (Masuk + Keluar) -->
                        <div class="w-full flex flex-col-reverse h-full justify-end items-center">
                            @php
                                $maxVal = max(array_merge($grafikSurat['dataMasuk'], $grafikSurat['dataKeluar'])) ?: 1;
                                $hMasuk = ($grafikSurat['dataMasuk'][$index] / $maxVal) * 80; // Scale 80% height max
                                $hKeluar = ($grafikSurat['dataKeluar'][$index] / $maxVal) * 80;
                            @endphp
                            
                            <!-- Keluar -->
                            <div class="w-full bg-blue-400 rounded-t-sm relative hover:bg-blue-500 transition-colors" style="height: {{ $hKeluar }}%" title="Keluar: {{ $grafikSurat['dataKeluar'][$index] }}"></div>
                            <!-- Masuk -->
                            <div class="w-full bg-green-400 rounded-b-sm relative hover:bg-green-500 transition-colors" style="height: {{ $hMasuk }}%" title="Masuk: {{ $grafikSurat['dataMasuk'][$index] }}"></div>
                        </div>
                        <span class="text-[10px] text-slate-400 mt-2 font-bold">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center gap-4 mt-4 text-xs font-bold text-slate-500">
                <span class="flex items-center gap-1"><div class="w-3 h-3 bg-green-400 rounded-sm"></div> Masuk</span>
                <span class="flex items-center gap-1"><div class="w-3 h-3 bg-blue-400 rounded-sm"></div> Keluar</span>
            </div>
        </div>

        <!-- Data Table -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                <h3 class="text-lg font-bold text-slate-800">Arsip Surat Menyurat</h3>
                <div class="flex gap-2 w-full sm:w-auto">
                    <select wire:model.live="jenisFilter" class="rounded-xl border-slate-200 text-sm focus:ring-indigo-500">
                        <option value="">Semua Jenis</option>
                        <option value="Masuk">Masuk</option>
                        <option value="Keluar">Keluar</option>
                    </select>
                    <input wire:model.live.debounce.300ms="search" type="search" placeholder="Cari nomor/perihal..." class="rounded-xl border-slate-200 text-sm w-full sm:w-48 focus:ring-indigo-500">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-bold tracking-wider">No. Surat / Tgl</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Perihal</th>
                            <th class="px-6 py-4 font-bold tracking-wider">Arah</th>
                            <th class="px-6 py-4 font-bold tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($surats as $surat)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $surat->nomor_surat }}</div>
                                    <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate text-slate-600">
                                    {{ $surat->perihal }}
                                    <div class="text-xs text-slate-400 mt-1">
                                        {{ $surat->jenis_surat == 'Masuk' ? 'Dari: '.$surat->pengirim : 'Kepada: '.$surat->penerima }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($surat->jenis_surat == 'Masuk')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded">Masuk</span>
                                    @else
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded">Keluar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if($surat->jenis_surat == 'Masuk')
                                            <!-- Ganti Modal dengan Link Halaman -->
                                            <a href="{{ route('surat.disposisi.manage', $surat->id) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg font-bold text-xs" title="Kelola Disposisi">
                                                Disposisi
                                            </a>
                                        @endif
                                        <a href="{{ route('surat.edit', $surat->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </a>
                                        <button wire:confirm="Hapus surat ini?" wire:click="delete({{ $surat->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-8 text-slate-400">Belum ada arsip surat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $surats->links() }}
            </div>
        </div>
    </div>
</div>