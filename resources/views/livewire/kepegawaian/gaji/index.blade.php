<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Penggajian</h2>
        <button wire:click="create" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 shadow-sm">
            + Input Gaji Baru
        </button>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pegawai</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Gaji Pokok</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Tunjangan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Potongan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($gajis as $gaji)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $gaji->bulan }} {{ $gaji->tahun }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $gaji->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($gaji->user->role) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-green-600">
                                + {{ number_format($gaji->tunjangan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-red-600">
                                - {{ number_format($gaji->potongan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-indigo-700">
                                Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="delete({{ $gaji->id }})" wire:confirm="Hapus data gaji ini?" class="text-red-600 hover:text-red-900">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-gray-500">Belum ada data gaji.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50">
            {{ $gajis->links() }}
        </div>
    </div>

    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" wire:click="$set('isOpen', false)"></div>
                <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Input Gaji Pegawai</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Periode -->
                                <div>
                                    <x-input-label value="Bulan" />
                                    <select wire:model="bulan" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                        @foreach(range(1, 12) as $m)
                                            <option value="{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}">
                                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label value="Tahun" />
                                    <x-text-input type="number" wire:model="tahun" class="w-full mt-1" />
                                </div>

                                <!-- Pegawai -->
                                <div class="md:col-span-2">
                                    <x-input-label value="Pegawai" />
                                    <select wire:model.live="user_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                        <option value="">Pilih Pegawai</option>
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role }})</option>
                                        @endforeach
                                    </select>
                                    @error('user_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Nominal -->
                                <div>
                                    <x-input-label value="Gaji Pokok (Rp)" />
                                    <x-text-input type="number" wire:model="gaji_pokok" class="w-full mt-1" />
                                    @error('gaji_pokok') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <x-input-label value="Tunjangan (Rp)" />
                                    <x-text-input type="number" wire:model="tunjangan" class="w-full mt-1" />
                                </div>
                                <div>
                                    <x-input-label value="Potongan (Rp)" />
                                    <x-text-input type="number" wire:model="potongan" class="w-full mt-1" />
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan Data
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