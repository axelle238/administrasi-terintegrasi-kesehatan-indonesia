<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Shift Jaga</h2>
        <a href="{{ route('shift.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Shift
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($shifts as $shift)
            <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300 border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-full {{ $loop->iteration % 2 == 0 ? 'bg-blue-100 text-blue-600' : 'bg-teal-100 text-teal-600' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('shift.edit', $shift->id) }}" wire:navigate class="text-gray-400 hover:text-indigo-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <button wire:click="delete({{ $shift->id }})" wire:confirm="Apakah Anda yakin ingin menghapus shift ini?" class="text-gray-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $shift->nama_shift }}</h3>
                    <div class="flex items-center text-gray-500 text-sm mb-4">
                        <span class="font-medium bg-gray-100 px-2 py-1 rounded">{{ $shift->jam_mulai }}</span>
                        <span class="mx-2">-</span>
                        <span class="font-medium bg-gray-100 px-2 py-1 rounded">{{ $shift->jam_selesai }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10 bg-white rounded-lg border border-dashed border-gray-300">
                <p class="text-gray-500">Belum ada data shift yang dibuat.</p>
            </div>
        @endforelse
    </div>
</div>