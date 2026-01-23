<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Gudang Farmasi (Stok Obat)') }}
        </h2>
    </x-slot>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="relative w-full md:w-1/3">
             <input type="text" placeholder="Cari Nama Obat / Kode..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm shadow-sm">
             <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('transaksi-obat.create') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2 px-4 rounded-lg shadow-sm transition-all flex items-center">
                <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                Catat Transaksi
            </a>
            <a href="{{ route('obat.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Obat Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Informasi Obat</th>
                        <th class="px-6 py-4 text-left">Kategori</th>
                        <th class="px-6 py-4 text-center">Stok</th>
                        <th class="px-6 py-4 text-left">Kedaluwarsa</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($obats as $obat)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600 font-bold border border-teal-100">
                                    {{ substr($obat->nama_obat, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900 group-hover:text-teal-600 transition-colors">{{ $obat->nama_obat }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $obat->kode_obat }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $obat->jenis_obat }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-lg font-bold {{ $obat->stok <= $obat->min_stok ? 'text-red-600' : 'text-gray-800' }}">
                                {{ $obat->stok }}
                            </span>
                            <span class="text-xs text-gray-500 block">{{ $obat->satuan }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->format('d M Y') }}
                            <br>
                            <span class="text-xs {{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->isPast() ? 'text-red-600 font-bold' : 'text-gray-400' }}">
                                {{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->diffForHumans() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($obat->stok <= 0)
                                <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded-full text-xs font-bold">Habis</span>
                            @elseif($obat->stok <= $obat->min_stok)
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold animate-pulse">Kritis</span>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Aman</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('obat.edit', $obat->id) }}" class="text-gray-400 hover:text-teal-600 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" onsubmit="return confirm('Hapus data obat ini?');">
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
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                            Belum ada data obat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
            {{ $obats->links() }}
        </div>
    </div>
</x-app-layout>
