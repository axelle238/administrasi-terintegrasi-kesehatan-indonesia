<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Riwayat Rekam Medis') }}
        </h2>
    </x-slot>

    <!-- Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="relative w-full md:w-1/3">
             <input type="text" placeholder="Cari Pasien / No. RM..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm shadow-sm">
             <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        <a href="{{ route('rekam-medis.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Periksa Pasien Baru
        </a>
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
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Pasien</th>
                        <th class="px-6 py-4 text-left">Dokter</th>
                        <th class="px-6 py-4 text-left">Diagnosa</th>
                        <th class="px-6 py-4 text-center">Status Resep</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rekamMedis as $rm)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($rm->tanggal_periksa)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $rm->pasien->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">RM #{{ $rm->id }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $rm->dokter->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                            {{ Str::limit($rm->diagnosa, 50) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($rm->status_resep == 'Selesai')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Selesai</span>
                            @elseif($rm->status_resep == 'Menunggu')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold animate-pulse">Menunggu</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">Tidak Ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('rekam-medis.show', $rm->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                            Belum ada riwayat rekam medis.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
            {{ $rekamMedis->links() }}
        </div>
    </div>
</x-app-layout>