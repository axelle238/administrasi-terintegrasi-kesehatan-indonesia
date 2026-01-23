<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Manajemen SDM Kesehatan') }}
        </h2>
    </x-slot>

    <!-- Stats SDM -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
            <div class="text-xs font-bold text-gray-400 uppercase">Total Pegawai</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalPegawai }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-teal-500">
            <div class="text-xs font-bold text-gray-400 uppercase">Dokter</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalDokter }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-purple-500">
            <div class="text-xs font-bold text-gray-400 uppercase">Perawat</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalPerawat }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-yellow-500">
            <div class="text-xs font-bold text-gray-400 uppercase">Apoteker</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalApoteker }}</div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="relative w-full md:w-1/3">
             <input type="text" placeholder="Cari Nama / NIP..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm shadow-sm">
             <div class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        <a href="{{ route('pegawai.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Tambah Pegawai
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
                        <th class="px-6 py-4 text-left">Nama & NIP</th>
                        <th class="px-6 py-4 text-left">Jabatan & Role</th>
                        <th class="px-6 py-4 text-left">Kontak</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Masa Kerja</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($pegawais as $pegawai)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold">
                                    {{ substr($pegawai->user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $pegawai->user->name }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $pegawai->nip }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $pegawai->jabatan }}</div>
                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-600 uppercase mt-1 inline-block">
                                {{ $pegawai->user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $pegawai->no_telepon }}</div>
                            <div class="text-xs text-gray-500">{{ $pegawai->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                {{ $pegawai->status_kepegawaian }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($pegawai->tanggal_masuk)->diffForHumans(null, true) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="text-gray-400 hover:text-teal-600 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" onsubmit="return confirm('Hapus pegawai {{ $pegawai->user->name }}? Akun login juga akan dihapus.');">
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
                            Belum ada data pegawai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
            {{ $pegawais->links() }}
        </div>
    </div>
</x-app-layout>
