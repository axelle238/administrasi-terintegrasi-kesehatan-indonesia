<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
    <!-- Mini Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Pasien -->
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl p-5 text-white shadow-lg shadow-teal-500/20 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-teal-100 uppercase tracking-widest mb-1">Total Pasien</p>
            <h3 class="text-3xl font-black">{{ number_format($totalPasien) }}</h3>
            <div class="mt-3 flex items-center text-[10px] font-bold bg-white/20 w-max px-2 py-1 rounded-lg">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                {{ $pasienBaruHariIni }} Baru Hari Ini
            </div>
        </div>

        <!-- BPJS vs Umum -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative overflow-hidden">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Jenis Penjamin</p>
            <div class="flex items-end justify-between mb-2">
                <div>
                    <span class="text-2xl font-black text-slate-800">{{ $bpjsCount }}</span>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-1.5 py-0.5 rounded ml-1">BPJS</span>
                </div>
                <div class="text-right">
                    <span class="text-xl font-bold text-slate-600">{{ $umumCount }}</span>
                    <span class="text-xs font-bold text-slate-400 block">UMUM</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden flex">
                <div class="bg-green-500 h-full" style="width: {{ $totalPasien > 0 ? ($bpjsCount / $totalPasien) * 100 : 0 }}%"></div>
            </div>
        </div>

        <!-- Gender -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative overflow-hidden">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Demografi Gender</p>
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">L</div>
                    <span class="text-xl font-black text-slate-800">{{ $priaCount }}</span>
                </div>
                <div class="h-8 w-px bg-slate-100"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center font-bold text-xs">P</div>
                    <span class="text-xl font-black text-slate-800">{{ $wanitaCount }}</span>
                </div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 flex flex-col justify-center gap-3">
            <a href="{{ route('pasien.create') }}" wire:navigate class="w-full py-2.5 bg-teal-600 text-white rounded-xl text-xs font-bold text-center hover:bg-teal-700 transition shadow-lg shadow-teal-500/20 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                Registrasi Pasien
            </a>
            <button class="w-full py-2.5 bg-white border border-slate-300 text-slate-600 rounded-xl text-xs font-bold text-center hover:bg-slate-100 transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Export Data
            </button>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="space-y-4">
        <!-- Search & Filter Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500 transition-shadow text-sm" placeholder="Cari Nama, NIK, RM, atau BPJS..." />
            </div>
            
            <div class="flex gap-2">
                <!-- Filter buttons could go here -->
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Identitas</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($pasiens as $pasien)
                            <tr class="hover:bg-slate-50/80 transition duration-150 group cursor-pointer" onclick="window.location='{{ route('pasien.show', $pasien->id) }}'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-teal-50 text-teal-600 font-bold text-sm border border-teal-100 group-hover:bg-teal-100 transition-colors">
                                            {{ substr($pasien->nama_lengkap, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-900 group-hover:text-teal-700 transition-colors">{{ $pasien->nama_lengkap }}</div>
                                            <div class="text-xs text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <span class="font-mono bg-slate-100 px-1.5 rounded">{{ $pasien->no_rm }}</span>
                                                <span>{{ $pasien->jenis_kelamin }}</span>
                                                <span>•</span>
                                                <span>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Thn</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <div class="text-xs text-slate-500">NIK: <span class="font-mono text-slate-700 font-medium">{{ $pasien->nik }}</span></div>
                                        @if($pasien->no_bpjs)
                                            <div class="inline-flex items-center gap-1">
                                                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                                <span class="text-xs font-mono text-green-700 font-medium">{{ $pasien->no_bpjs }}</span>
                                            </div>
                                        @else
                                            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded w-max">UMUM</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-700 font-medium">{{ $pasien->no_telepon }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5 truncate max-w-[200px]">{{ $pasien->alamat }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" onclick="event.stopPropagation()">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('pasien.edit', $pasien->id) }}" wire:navigate class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </a>
                                        <button wire:click="delete({{ $pasien->id }})" wire:confirm="Hapus data pasien ini?" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="p-4 bg-slate-50 rounded-full mb-4">
                                            <svg class="h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900 mb-1">Data Pasien Kosong</h3>
                                        <p class="text-sm text-slate-500 text-center mb-6">Belum ada data pasien yang ditemukan. Mulai dengan menambahkan pasien baru.</p>
                                        <a href="{{ route('pasien.create') }}" wire:navigate class="px-5 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-bold hover:bg-teal-700 transition shadow-lg shadow-teal-500/30">
                                            + Tambah Pasien
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pasiens->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $pasiens->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
