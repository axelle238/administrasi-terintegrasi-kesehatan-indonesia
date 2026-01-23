<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Data Pasien
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Kelola data pasien, riwayat kunjungan, dan informasi penjamin.
            </p>
        </div>
        <a href="{{ route('pasien.create') }}" wire:navigate class="inline-flex items-center px-5 py-2.5 bg-teal-600 text-white rounded-xl font-semibold text-sm shadow-lg hover:bg-teal-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Pasien Baru
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <div class="relative w-full md:w-1/2 lg:w-1/3">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500 transition-shadow" placeholder="Cari Pasien (Nama, NIK, No. BPJS)..." />
        </div>
    </div>

    <!-- Data Table (Desktop) -->
    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Identitas Pasien</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nomor Penting</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kontak & Alamat</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($pasiens as $pasien)
                        <tr class="hover:bg-gray-50/80 transition duration-150 ease-in-out group cursor-pointer" onclick="window.location='{{ route('pasien.show', $pasien->id) }}'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-full bg-teal-50 text-teal-600 font-bold text-lg border border-teal-100 group-hover:bg-teal-100 transition-colors">
                                        {{ substr($pasien->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 group-hover:text-teal-600 transition-colors">{{ $pasien->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                            <span>{{ $pasien->jenis_kelamin }}</span>
                                            <span>•</span>
                                            <span>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-semibold text-gray-400 w-8">NIK</span>
                                        <span class="text-sm font-mono text-gray-700">{{ $pasien->nik }}</span>
                                    </div>
                                    @if($pasien->no_bpjs)
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-semibold text-green-600 w-8">BPJS</span>
                                            <span class="text-sm font-mono text-green-700 bg-green-50 px-1.5 py-0.5 rounded">{{ $pasien->no_bpjs }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $pasien->no_telepon }}</div>
                                <div class="text-xs text-gray-500 mt-1 truncate max-w-xs">{{ $pasien->alamat }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('pasien.show', $pasien->id) }}" wire:navigate class="p-2 text-teal-600 hover:text-teal-800 hover:bg-teal-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                    <button wire:click="delete({{ $pasien->id }})" wire:confirm="Apakah Anda yakin ingin menghapus data pasien ini?" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="p-4 bg-gray-50 rounded-full mb-4">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Data Pasien Kosong</h3>
                                    <p class="text-sm text-gray-500 text-center mb-6">Belum ada data pasien yang terdaftar. Silakan tambahkan pasien baru.</p>
                                    <a href="{{ route('pasien.create') }}" wire:navigate class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-semibold hover:bg-teal-700 transition">
                                        Daftar Pasien Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile View (Cards) -->
    <div class="md:hidden space-y-4">
        @forelse ($pasiens as $pasien)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5" onclick="window.location='{{ route('pasien.show', $pasien->id) }}'">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded-full bg-teal-50 flex items-center justify-center text-teal-600 font-bold text-lg border border-teal-100">
                            {{ substr($pasien->nama_lengkap, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">{{ $pasien->nama_lengkap }}</h3>
                            <p class="text-xs text-gray-500">{{ $pasien->jenis_kelamin }} • {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Thn</p>
                        </div>
                    </div>
                    @if($pasien->no_bpjs)
                        <span class="px-2.5 py-1 bg-green-50 text-green-700 text-[10px] font-bold rounded-lg border border-green-100">BPJS</span>
                    @else
                        <span class="px-2.5 py-1 bg-gray-50 text-gray-600 text-[10px] font-bold rounded-lg border border-gray-100">UMUM</span>
                    @endif
                </div>
                
                <div class="space-y-3 pt-4 border-t border-gray-50 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">NIK</span>
                        <span class="font-mono text-gray-700 bg-gray-50 px-2 py-0.5 rounded">{{ $pasien->nik }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Telepon</span>
                        <span class="font-medium text-gray-700">{{ $pasien->no_telepon }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-end gap-3" onclick="event.stopPropagation()">
                    <a href="{{ route('pasien.show', $pasien->id) }}" wire:navigate class="px-4 py-2 bg-teal-50 text-teal-700 rounded-xl text-xs font-bold hover:bg-teal-100 transition">Detail</a>
                    <button wire:click="delete({{ $pasien->id }})" wire:confirm="Hapus data?" class="px-4 py-2 bg-red-50 text-red-700 rounded-xl text-xs font-bold hover:bg-red-100 transition">Hapus</button>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-8 text-center text-gray-500">
                Tidak ada data pasien.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $pasiens->links() }}
    </div>
</div>