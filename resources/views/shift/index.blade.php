<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Shift Kerja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-4">
                <a href="{{ route('shift.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Shift
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Nama Shift</th>
                                <th class="py-2 px-4 border-b">Jam Mulai</th>
                                <th class="py-2 px-4 border-b">Jam Selesai</th>
                                <th class="py-2 px-4 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shifts as $shift)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $shift->nama_shift }}</td>
                                <td class="py-2 px-4 border-b">{{ $shift->jam_mulai }}</td>
                                <td class="py-2 px-4 border-b">{{ $shift->jam_selesai }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('shift.edit', $shift->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                                    <form action="{{ route('shift.destroy', $shift->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus shift ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-4 px-4 text-center text-gray-500">Belum ada data shift.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
