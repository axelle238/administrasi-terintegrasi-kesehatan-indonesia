<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="w-full md:w-1/3">
            <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari Nama Pasien..." class="w-full" />
        </div>
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 w-full md:w-auto shadow-md">
            + Rawat Inap Baru
        </button>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kamar & Bangsal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($admissions as $row)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $row->pasien->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">{{ $row->pasien->nik }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-bold">No. {{ $row->kamar->nomor_kamar }}</div>
                                <div class="text-xs text-gray-500">{{ $row->kamar->nama_bangsal }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $row->waktu_masuk->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <span class="px-2 py-1 rounded bg-gray-100">{{ $row->jenis_pembayaran }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $color = match($row->status) {
                                        'Aktif' => 'bg-green-100 text-green-800',
                                        'Pulang' => 'bg-blue-100 text-blue-800',
                                        'Rujuk' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-red-100 text-red-800'
                                    };
                                @endphp
                                <span class="px-2 text-xs font-bold rounded-full {{ $color }}">{{ $row->status }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($row->status == 'Aktif')
                                    <button wire:click="openCheckout({{ $row->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold">Checkout</button>
                                @else
                                    <span class="text-gray-400">Selesai</span>
                                @endif
                                <button wire:click="openCheckout({{ $rawat->id }})" class="text-green-600 hover:text-green-900 ml-3 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Pulangkan
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-gray-500">Belum ada data rawat inap.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t">{{ $admissions->links() }}</div>
    </div>

    {{-- Admission Modal --}}
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500/75" wire:click="$set('isOpen', false)"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pendaftaran Rawat Inap</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label value="Pasien" />
                                <select wire:model="pasien_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Pilih --</option>
                                    @foreach($pasiens as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama_lengkap }} ({{ $p->nik }})</option>
                                    @endforeach
                                </select>
                                @error('pasien_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <x-input-label value="Kamar & Bangsal" />
                                <select wire:model="kamar_id" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Pilih Kamar Tersedia --</option>
                                    @foreach($availableKamars as $k)
                                        <option value="{{ $k->id }}">{{ $k->nomor_kamar }} - {{ $k->nama_bangsal }} (Sisa: {{ $k->kapasitas_bed - $k->bed_terisi }} Bed)</option>
                                    @endforeach
                                </select>
                                @error('kamar_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label value="Waktu Masuk" />
                                    <x-text-input type="datetime-local" wire:model="waktu_masuk" class="w-full mt-1" />
                                </div>
                                <div>
                                    <x-input-label value="Jenis Pembayaran" />
                                    <select wire:model="jenis_pembayaran" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                        <option value="Umum">Umum (Mandiri)</option>
                                        <option value="BPJS">BPJS Kesehatan</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <x-input-label value="Diagnosa Awal" />
                                <textarea wire:model="diagnosa_awal" class="w-full mt-1 border-gray-300 rounded-md shadow-sm"></textarea>
                                @error('diagnosa_awal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" wire:click="save" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:w-auto sm:text-sm">
                            Simpan
                        </button>
                        <button type="button" wire:click="$set('isOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Checkout Modal --}}
    @if($isCheckoutOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500/75" wire:click="$set('isCheckoutOpen', false)"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Checkout / Pulangkan Pasien</h3>
                        <div class="space-y-4">
                            <div>
                                <x-input-label value="Waktu Keluar" />
                                <x-text-input type="datetime-local" wire:model="waktu_keluar" class="w-full mt-1" />
                            </div>

                            <div>
                                <x-input-label value="Status Akhir" />
                                <select wire:model="checkoutStatus" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <option value="Pulang">Sembuh / Pulang</option>
                                    <option value="Rujuk">Rujuk ke RS</option>
                                    <option value="APS">Atas Permintaan Sendiri</option>
                                    <option value="Meninggal">Meninggal Dunia</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label value="Diagnosa Akhir / Resume Medis" />
                                <textarea wire:model="diagnosa_akhir" class="w-full mt-1 border-gray-300 rounded-md shadow-sm" placeholder="Isi resume singkat..."></textarea>
                                @error('diagnosa_akhir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" wire:click="checkout" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:w-auto sm:text-sm">
                            Proses Checkout
                        </button>
                        <button type="button" wire:click="$set('isCheckoutOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>