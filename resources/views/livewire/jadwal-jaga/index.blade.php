<div class="space-y-6">
    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
            <div>
                <x-input-label for="dateFilter" value="Tanggal" />
                <x-text-input wire:model.live="dateFilter" id="dateFilter" type="date" class="block mt-1 w-full" />
            </div>
            <div>
                <x-input-label for="pegawaiFilter" value="Filter Pegawai" />
                <select wire:model.live="pegawaiFilter" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Semua Pegawai</option>
                    @foreach($pegawais as $p)
                        <option value="{{ $p->id }}">{{ $p->user->name }} ({{ ucfirst($p->user->role) }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <a href="{{ route('jadwal-jaga.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Jadwal Baru
        </a>
    </div>

    <!-- Table Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shift</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($jadwals as $jadwal)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $jadwal->pegawai->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($jadwal->pegawai->user->role) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $jadwal->shift->nama_shift }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $jadwal->shift->jam_mulai }} - {{ $jadwal->shift->jam_selesai }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($jadwal->status_kehadiran == 'Hadir') bg-green-100 text-green-800
                                    @elseif($jadwal->status_kehadiran == 'Sakit') bg-yellow-100 text-yellow-800
                                    @elseif($jadwal->status_kehadiran == 'Izin') bg-indigo-100 text-indigo-800
                                    @elseif($jadwal->status_kehadiran == 'Alpha') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $jadwal->status_kehadiran }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('jadwal-jaga.edit', $jadwal->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <button wire:click="delete({{ $jadwal->id }})" wire:confirm="Hapus jadwal ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada jadwal pada tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50">
            {{ $jadwals->links() }}
        </div>
    </div>
</div>