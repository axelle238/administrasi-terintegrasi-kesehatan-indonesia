<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="text-gray-600">
            @if($isAdmin)
                <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full font-bold">Mode Admin</span>
            @endif
        </div>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 w-full md:w-auto shadow-md transition duration-150 ease-in-out">
            + Ajukan Cuti Baru
        </button>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis & Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($cutis as $cuti)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $cuti->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $cuti->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-indigo-600 font-semibold">{{ $cuti->jenis_cuti }}</div>
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ $cuti->keterangan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d M Y') }} s/d <br>
                                {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $colors = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Disetujui' => 'bg-green-100 text-green-800',
                                        'Ditolak' => 'bg-red-100 text-red-800',
                                    ];
                                    $color = $colors[$cuti->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                    {{ $cuti->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($isAdmin && $cuti->status == 'Pending')
                                    <button wire:click="approve({{ $cuti->id }})" class="text-green-600 hover:text-green-900 mr-2 font-bold" title="Setujui">✔</button>
                                    <button wire:click="reject({{ $cuti->id }})" wire:confirm="Tolak pengajuan ini?" class="text-red-600 hover:text-red-900 font-bold" title="Tolak">✘</button>
                                @endif

                                @if($cuti->user_id == auth()->id() && $cuti->status == 'Pending')
                                    <button wire:click="cancel({{ $cuti->id }})" wire:confirm="Batalkan pengajuan?" class="text-gray-500 hover:text-red-600 text-xs underline ml-2">Batal</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data pengajuan cuti.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $cutis->links() }}
        </div>
    </div>

    {{-- Modal Form --}}
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" wire:click="$set('isOpen', false)" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Form Pengajuan Cuti</h3>
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <x-input-label for="jenis_cuti" value="Jenis Cuti" />
                                            <select wire:model="jenis_cuti" id="jenis_cuti" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                <option value="Cuti Tahunan">Cuti Tahunan</option>
                                                <option value="Sakit">Sakit</option>
                                                <option value="Izin">Izin (Potong Gaji)</option>
                                                <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                            </select>
                                            @error('jenis_cuti') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="tanggal_mulai" value="Mulai" />
                                                <x-text-input type="date" wire:model="tanggal_mulai" id="tanggal_mulai" class="w-full mt-1" />
                                                @error('tanggal_mulai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <x-input-label for="tanggal_selesai" value="Selesai" />
                                                <x-text-input type="date" wire:model="tanggal_selesai" id="tanggal_selesai" class="w-full mt-1" />
                                                @error('tanggal_selesai') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div>
                                            <x-input-label for="keterangan" value="Keterangan / Alasan" />
                                            <textarea wire:model="keterangan" id="keterangan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                            @error('keterangan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">
                                Kirim Pengajuan
                            </button>
                            <button type="button" wire:click="$set('isOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
