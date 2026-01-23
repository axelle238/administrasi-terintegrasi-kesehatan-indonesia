<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Data Pasien') }}
        </h2>
    </x-slot>

    <!-- Header & Action -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex-1 w-full md:w-auto">
             <!-- Search Placeholder (If backend supports it later) -->
            <div class="relative">
                <input type="text" placeholder="Cari nama atau NIK..." class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>
        <a href="{{ route('pasien.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Pasien Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
            <span class="text-green-700 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">NIK</th>
                        <th class="px-6 py-4 text-left">Nama Lengkap</th>
                        <th class="px-6 py-4 text-left">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-left">Alamat</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($pasiens as $pasien)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-sm font-mono text-gray-600">
                            {{ $pasien->nik }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 group-hover:text-teal-600 transition-colors">{{ $pasien->nama_lengkap }}</div>
                            <div class="text-xs text-gray-400">{{ $pasien->no_bpjs ?? 'Non-BPJS' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $pasien->jenis_kelamin }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                            {{ Str::limit($pasien->alamat, 40) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('pasien.edit', $pasien->id) }}" class="text-gray-400 hover:text-teal-600 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                            Belum ada data pasien terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pasiens->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
            {{ $pasiens->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
