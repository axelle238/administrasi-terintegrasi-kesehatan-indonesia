<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    {{-- Header & Search --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="w-full sm:w-1/3">
            <input wire:model.live.debounce.300ms="search" type="text" 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition duration-150 ease-in-out" 
                placeholder="Cari pengguna...">
        </div>
        @if(!$isOpen)
        <button wire:click="create" 
            class="w-full sm:w-auto px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
            Tambah Pengguna Baru
        </button>
        @endif
    </div>

    {{-- Form Section (Inline - No Modal) --}}
    @if($isOpen)
    <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-indigo-100 transition-all duration-300 ease-in-out">
        <div class="px-6 py-4 border-b border-gray-100 bg-indigo-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-indigo-900">
                {{ $userId ? 'Edit Data Pengguna' : 'Tambah Pengguna Baru' }}
            </h3>
            <button wire:click="$set('isOpen', false)" class="text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kolom Kiri --}}
            <div class="space-y-4">
                <div>
                    <x-input-label for="name" value="Nama Lengkap" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" placeholder="Masukkan nama lengkap" />
                    @error('name') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-input-label for="email" value="Alamat Email" />
                    <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" placeholder="contoh@email.com" />
                    @error('email') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="space-y-4">
                <div>
                    <x-input-label for="role" value="Peran / Jabatan" />
                    <select wire:model="role" id="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Pilih Peran --</option>
                        <option value="admin">Admin Sistem</option>
                        <option value="dokter">Dokter</option>
                        <option value="perawat">Perawat</option>
                        <option value="apoteker">Apoteker</option>
                        <option value="staf">Staf Administrasi</option>
                    </select>
                    @error('role') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-input-label for="password" value="Kata Sandi {{ $userId ? '(Kosongkan jika tidak ingin mengubah)' : '' }}" />
                    <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" placeholder="Minimal 8 karakter" />
                    @error('password') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
            <button wire:click="save" type="button" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition">
                Simpan Data
            </button>
            <button wire:click="$set('isOpen', false)" type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition">
                Batal
            </button>
        </div>
    </div>
    @endif

    {{-- Table Section --}}
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Peran</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Terdaftar Sejak</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg ring-2 ring-white shadow-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 border border-purple-200' : 
                                      ($user->role === 'dokter' ? 'bg-green-100 text-green-800 border border-green-200' : 
                                      ($user->role === 'perawat' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 
                                      ($user->role === 'apoteker' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' :
                                      'bg-gray-100 text-gray-800 border border-gray-200'))) }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->isoFormat('D MMMM Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 mr-4 font-semibold hover:underline">Edit</button>
                                @if(auth()->id() !== $user->id)
                                    <button wire:click="delete({{ $user->id }})" 
                                        wire:confirm="Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan." 
                                        class="text-red-600 hover:text-red-900 font-semibold hover:underline">Hapus</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $users->links() }}
        </div>
    </div>
</div>