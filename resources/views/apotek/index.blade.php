<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Farmasi / Apotek') }}
        </h2>
    </x-slot>

    <!-- Info Banner -->
    <div class="bg-indigo-600 rounded-xl shadow-lg p-6 mb-8 text-white flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold mb-1">Antrean Resep Masuk</h3>
            <p class="text-indigo-100 text-sm">Proses resep segera untuk mengurangi waktu tunggu pasien.</p>
        </div>
        <div class="flex items-center space-x-4">
             <div class="text-center">
                <span class="block text-3xl font-bold">{{ $reseps->total() }}</span>
                <span class="text-xs uppercase tracking-wider opacity-80">Menunggu</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
            <span class="text-green-700 font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-700">Daftar E-Resep ({{ date('d-m-Y') }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">Waktu Masuk</th>
                        <th class="px-6 py-4 text-left">Pasien</th>
                        <th class="px-6 py-4 text-left">Dokter Peresep</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($reseps as $resep)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $resep->created_at->format('H:i') }}
                            <span class="text-xs text-gray-400 block">{{ $resep->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $resep->pasien->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">RM #{{ $resep->pasien->id }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $resep->dokter->name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($resep->status_resep == 'Menunggu')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold flex items-center justify-center w-fit mx-auto gap-1">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span> Menunggu
                                </span>
                            @elseif($resep->status_resep == 'Diproses')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Diproses</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('apotek.show', $resep->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold rounded-lg shadow transition-all hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                Proses Resep
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-lg font-medium">Semua resep sudah diproses.</p>
                                <p class="text-sm">Kerja bagus! Tidak ada antrean saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
            {{ $reseps->links() }}
        </div>
    </div>
</x-app-layout>