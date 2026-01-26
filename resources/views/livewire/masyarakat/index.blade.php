<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Layanan Masyarakat
            </h2>
            <p class="text-sm text-gray-500 mt-1 ml-10">
                Informasi kegiatan kesehatan masyarakat, penyuluhan, dan survei kepuasan.
            </p>
        </div>
        
        <div class="relative w-full md:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 w-full rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-shadow" placeholder="Cari kegiatan..." />
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
            <h3 class="text-lg font-bold mb-1">Kegiatan Mendatang</h3>
            <p class="text-3xl font-extrabold">{{ $kegiatans->total() }}</p>
            <p class="text-xs text-orange-100 mt-2">Agenda UKM & Penyuluhan</p>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-1">Survei Kepuasan</h3>
            <p class="text-3xl font-extrabold text-orange-600">{{ $activeSurveys }}</p>
            <p class="text-xs text-gray-500 mt-2">Total Responden</p>
        </div>

        <a href="{{ route('survey.create') }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-orange-200 hover:shadow-md transition-all group flex flex-col justify-center items-center text-center cursor-pointer">
            <div class="p-3 bg-orange-50 text-orange-600 rounded-full mb-3 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <span class="font-bold text-gray-800 group-hover:text-orange-600 transition-colors">Isi Survei Kepuasan</span>
        </a>
    </div>

    <!-- Grid Kegiatan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($kegiatans as $kegiatan)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
                <div class="h-32 bg-orange-50 relative">
                    <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-lg text-xs font-bold text-orange-600 shadow-sm">
                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y') }}
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $kegiatan->nama_kegiatan }}</h3>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $kegiatan->lokasi }}
                    </div>
                    <p class="text-gray-600 text-sm mb-6 line-clamp-3 flex-1">
                        {{ $kegiatan->deskripsi ?? 'Tidak ada deskripsi kegiatan.' }}
                    </p>
                    <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                        <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2 py-1 rounded">
                            {{ $kegiatan->sasaran ?? 'Umum' }}
                        </span>
                        <!-- Detail button placeholder -->
                        <button class="text-orange-600 text-sm font-bold hover:text-orange-700">Detail ></button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-gray-100 border-dashed">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada kegiatan</h3>
                <p class="text-gray-500 mt-1">Belum ada agenda kegiatan masyarakat yang dijadwalkan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $kegiatans->links() }}
    </div>
</div>
