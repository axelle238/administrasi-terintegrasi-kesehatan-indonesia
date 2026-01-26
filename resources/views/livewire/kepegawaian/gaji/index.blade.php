<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Penggajian</h2>
            <p class="text-sm text-gray-500">Kelola gaji pegawai, tunjangan, dan slip gaji.</p>
        </div>
        <button wire:click="create" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Input Gaji Baru
        </button>
    </div>

    <!-- Payroll History Table -->
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Pendapatan Kotor</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Potongan</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Take Home Pay</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($gajis as $gaji)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $gaji->bulan }} {{ $gaji->tahun }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $gaji->user->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $gaji->user->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-green-600 font-medium">
                                Rp {{ number_format($gaji->gaji_pokok + $gaji->tunjangan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-red-500 font-medium">
                                (Rp {{ number_format($gaji->potongan, 0, ',', '.') }})
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-indigo-700">
                                Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button wire:click="delete({{ $gaji->id }})" wire:confirm="Hapus data gaji ini?" class="text-red-400 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                                <!-- Print Button (Mock) -->
                                <button class="text-gray-400 hover:text-blue-600 p-2 rounded-lg hover:bg-blue-50 transition" title="Cetak Slip">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                Belum ada data penggajian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $gajis->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('isOpen', false)"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-6" id="modal-title">Input Gaji Pegawai</h3>
                    
                    <form wire:submit="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Info Dasar -->
                            <div class="md:col-span-2 bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <h4 class="font-bold text-gray-700 mb-3 text-sm uppercase tracking-wide">Informasi Dasar</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                                        <div class="flex gap-2">
                                            <select wire:model="bulan" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                                                    <option value="{{ $b }}">{{ $b }}</option>
                                                @endforeach
                                            </select>
                                            <input type="number" wire:model="tahun" class="block w-24 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Pegawai</label>
                                        <select wire:model.live="user_id" class="block w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">-- Pilih Pegawai --</option>
                                            @foreach($users as $u)
                                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->role }})</option>
                                            @endforeach
                                        </select>
                                        @error('user_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Penerimaan -->
                            <div class="bg-green-50/50 p-4 rounded-xl border border-green-100">
                                <h4 class="font-bold text-green-800 mb-3 text-sm uppercase tracking-wide flex justify-between">
                                    <span>Penerimaan</span>
                                    <span>(+)</span>
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-green-700">Gaji Pokok</label>
                                        <input type="number" wire:model.live="gaji_pokok" class="block w-full mt-1 rounded-lg border-green-200 focus:ring-green-500 focus:border-green-500 sm:text-sm text-right font-bold text-gray-700">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-green-700">Tunj. Jabatan</label>
                                            <input type="number" wire:model.live="tunjangan_jabatan" class="block w-full mt-1 rounded-lg border-green-200 text-sm text-right">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-green-700">Tunj. Fungsional</label>
                                            <input type="number" wire:model.live="tunjangan_fungsional" class="block w-full mt-1 rounded-lg border-green-200 text-sm text-right">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-green-700">Tunj. Makan</label>
                                            <input type="number" wire:model.live="tunjangan_makan" class="block w-full mt-1 rounded-lg border-green-200 text-sm text-right">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-green-700">Tunj. Transport</label>
                                            <input type="number" wire:model.live="tunjangan_transport" class="block w-full mt-1 rounded-lg border-green-200 text-sm text-right">
                                        </div>
                                    </div>
                                    <div class="pt-2 border-t border-green-200 flex justify-between items-center font-bold text-green-800">
                                        <span class="text-sm">Total Penerimaan</span>
                                        <span>Rp {{ number_format((int)$gaji_pokok + (int)$total_tunjangan, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Potongan -->
                            <div class="bg-red-50/50 p-4 rounded-xl border border-red-100">
                                <h4 class="font-bold text-red-800 mb-3 text-sm uppercase tracking-wide flex justify-between">
                                    <span>Potongan</span>
                                    <span>(-)</span>
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-red-700">PPh 21</label>
                                        <input type="number" wire:model.live="potongan_pph21" class="block w-full mt-1 rounded-lg border-red-200 focus:ring-red-500 focus:border-red-500 sm:text-sm text-right font-bold text-gray-700">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-red-700">BPJS Kesehatan</label>
                                            <input type="number" wire:model.live="potongan_bpjs_kesehatan" class="block w-full mt-1 rounded-lg border-red-200 text-sm text-right">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-red-700">BPJS Ketenagakerjaan</label>
                                            <input type="number" wire:model.live="potongan_bpjs_tk" class="block w-full mt-1 rounded-lg border-red-200 text-sm text-right">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-red-700">Absensi</label>
                                            <input type="number" wire:model.live="potongan_absen" class="block w-full mt-1 rounded-lg border-red-200 text-sm text-right">
                                        </div>
                                    </div>
                                    <div class="pt-2 border-t border-red-200 flex justify-between items-center font-bold text-red-800">
                                        <span class="text-sm">Total Potongan</span>
                                        <span>Rp {{ number_format((int)$total_potongan, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="md:col-span-2 bg-indigo-900 rounded-xl p-6 text-white flex justify-between items-center shadow-lg">
                                <div>
                                    <p class="text-indigo-200 text-sm font-bold uppercase tracking-wider">Take Home Pay</p>
                                    <h2 class="text-3xl font-extrabold mt-1">Rp {{ number_format($take_home_pay, 0, ',', '.') }}</h2>
                                </div>
                                <button type="submit" class="bg-white text-indigo-900 hover:bg-indigo-50 px-6 py-3 rounded-xl font-bold transition shadow-lg flex items-center gap-2">
                                    <svg wire:loading.remove class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    <span wire:loading.remove>Simpan & Proses</span>
                                    <span wire:loading class="text-sm">Menyimpan...</span>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="$set('isOpen', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
