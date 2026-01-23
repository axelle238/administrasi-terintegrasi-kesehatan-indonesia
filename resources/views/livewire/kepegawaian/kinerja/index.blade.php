<div>
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex gap-2">
            <select wire:model.live="bulan" class="rounded-lg border-gray-300">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                @endfor
            </select>
            <select wire:model.live="tahun" class="rounded-lg border-gray-300">
                @for($i=date('Y'); $i>=date('Y')-2; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        
        <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            + Input Penilaian Baru
        </button>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pegawai</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pelayanan</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Integritas</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Disiplin</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Rata-rata</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Predikat</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($kinerjas as $k)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $k->pegawai->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $k->pegawai->nip }}</div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm">{{ $k->orientasi_pelayanan }}</td>
                        <td class="px-6 py-4 text-center text-sm">{{ $k->integritas }}</td>
                        <td class="px-6 py-4 text-center text-sm">{{ $k->disiplin }}</td>
                        <td class="px-6 py-4 text-center text-sm font-bold">{{ number_format($k->nilai_rata_rata, 1) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $k->predikat }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('isOpen', false)"></div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Input Penilaian Kinerja</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pegawai</label>
                            <select wire:model="pegawai_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Pilih Pegawai</option>
                                @foreach($pegawais as $p)
                                    <option value="{{ $p->id }}">{{ $p->user->name }} - {{ $p->nip }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Orientasi Pelayanan</label>
                                <input type="number" wire:model="orientasi_pelayanan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Integritas</label>
                                <input type="number" wire:model="integritas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Komitmen</label>
                                <input type="number" wire:model="komitmen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Disiplin</label>
                                <input type="number" wire:model="disiplin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kerjasama</label>
                                <input type="number" wire:model="kerjasama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan Atasan</label>
                            <textarea wire:model="catatan_atasan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="save" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                    <button wire:click="$set('isOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
