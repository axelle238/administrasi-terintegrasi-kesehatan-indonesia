<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jadwal Jaga Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 p-4">
                <form action="{{ route('jadwal-jaga.index') }}" method="GET" class="flex gap-4 items-end">
                    <div>
                        <x-input-label for="tanggal" :value="__('Tanggal')" />
                        <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="request('tanggal')" />
                    </div>
                    <div>
                        <x-input-label for="pegawai_id" :value="__('Pegawai')" />
                        <select id="pegawai_id" name="pegawai_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Semua Pegawai</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}" {{ request('pegawai_id') == $pegawai->id ? 'selected' : '' }}>
                                    {{ $pegawai->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Filter
                    </button>
                    <a href="{{ route('jadwal-jaga.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-auto">
                        + Jadwal Baru
                    </a>
                </form>
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
                                <th class="py-2 px-4 border-b">Tanggal</th>
                                <th class="py-2 px-4 border-b">Pegawai</th>
                                <th class="py-2 px-4 border-b">Shift</th>
                                <th class="py-2 px-4 border-b">Jam</th>
                                <th class="py-2 px-4 border-b">Kehadiran</th>
                                <th class="py-2 px-4 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwals as $jadwal)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}</td>
                                <td class="py-2 px-4 border-b">{{ $jadwal->pegawai->user->name }}</td>
                                <td class="py-2 px-4 border-b">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-900">
                                        {{ $jadwal->shift->nama_shift }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($jadwal->shift->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->shift->jam_selesai)->format('H:i') }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    @php
                                        $colors = [
                                            'Hadir' => 'green',
                                            'Izin' => 'yellow',
                                            'Sakit' => 'blue',
                                            'Alpha' => 'red',
                                            'Belum Hadir' => 'gray',
                                        ];
                                        $color = $colors[$jadwal->status_kehadiran] ?? 'gray';
                                    @endphp
                                    <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        {{ $jadwal->status_kehadiran }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('jadwal-jaga.edit', $jadwal->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                                    <form action="{{ route('jadwal-jaga.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jadwal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-4 px-4 text-center text-gray-500">Belum ada jadwal jaga.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $jadwals->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
