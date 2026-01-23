<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Arsip Surat Digital') }}
        </h2>
    </x-slot>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        
        <!-- Filters -->
        <div class="flex bg-white rounded-lg p-1 shadow-sm border border-gray-200">
            <a href="{{ route('surat.index') }}" class="px-4 py-2 text-sm font-medium rounded-md {{ !request('jenis') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }}">
                Semua
            </a>
            <a href="{{ route('surat.index', ['jenis' => 'Masuk']) }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request('jenis') == 'Masuk' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }}">
                Surat Masuk
            </a>
            <a href="{{ route('surat.index', ['jenis' => 'Keluar']) }}" class="px-4 py-2 text-sm font-medium rounded-md {{ request('jenis') == 'Keluar' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }}">
                Surat Keluar
            </a>
        </div>

        <!-- Action -->
        <a href="{{ route('surat.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Arsip Baru
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
                        <th class="px-6 py-4 text-left">Detail Surat</th>
                        <th class="px-6 py-4 text-left">Perihal</th>
                        <th class="px-6 py-4 text-left">Asal / Tujuan</th>
                        <th class="px-6 py-4 text-center">Jenis</th>
                        <th class="px-6 py-4 text-center">Disposisi</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($surats as $surat)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $surat->nomor_surat }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-800 font-medium max-w-xs truncate" title="{{ $surat->perihal }}">{{ $surat->perihal }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($surat->jenis_surat == 'Masuk')
                                <div class="text-xs text-gray-400 uppercase">Dari:</div>
                                <div class="text-sm text-gray-900">{{ $surat->pengirim }}</div>
                            @else
                                <div class="text-xs text-gray-400 uppercase">Kepada:</div>
                                <div class="text-sm text-gray-900">{{ $surat->penerima }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($surat->jenis_surat == 'Masuk')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Masuk</span>
                            @else
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Keluar</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($surat->jenis_surat == 'Masuk')
                                @if($surat->status_disposisi == 'Pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold">Pending</span>
                                @elseif($surat->status_disposisi == 'Diteruskan')
                                    <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-bold">Diteruskan</span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Selesai</span>
                                @endif
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('surat.show', $surat->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                                    Detail
                                </a>
                                <form action="{{ route('surat.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus arsip surat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                            Belum ada arsip surat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
            {{ $surats->links() }}
        </div>
    </div>
</x-app-layout>
