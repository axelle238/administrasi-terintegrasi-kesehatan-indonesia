<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-20">
    
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row justify-between gap-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Input Stok Opname
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Pastikan Anda memasukkan jumlah fisik yang sebenarnya ada di gudang/penyimpanan.
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="w-full sm:w-auto">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Lokasi Ruangan</label>
                    <select wire:model.live="ruangan_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                        <option value="">Semua Ruangan</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal Opname</label>
                    <input type="date" wire:model="tanggal" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <textarea wire:model="keterangan" rows="2" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm" placeholder="Catatan tambahan untuk sesi opname ini (Opsional)..."></textarea>
        </div>
    </div>

    <!-- Mobile View (Cards) -->
    <div class="md:hidden space-y-4">
        @forelse($items as $item)
            <div wire:key="mobile-item-{{ $item->id }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 relative overflow-hidden" 
                 x-data="{ fisik: @entangle('physicalStocks.'.$item->id) }"
                 :class="fisik != {{ $item->stok }} ? 'border-l-4 border-l-yellow-400' : 'border-l-4 border-l-green-400'">
                
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $item->nama_barang }}</h3>
                        <p class="text-xs text-gray-500 font-mono">{{ $item->kode_barang }}</p>
                    </div>
                    <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-2 py-1 rounded">
                        Sistem: {{ $item->stok }} {{ $item->satuan }}
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Fisik</label>
                        <input type="number" wire:model.blur="physicalStocks.{{ $item->id }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-lg font-bold text-center" inputmode="numeric">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 mb-1">Selisih</label>
                        <div class="text-lg font-bold text-center py-2 bg-gray-50 rounded-lg"
                             :class="fisik - {{ $item->stok }} < 0 ? 'text-red-600' : (fisik - {{ $item->stok }} > 0 ? 'text-blue-600' : 'text-gray-400')">
                            <span x-text="fisik - {{ $item->stok }} > 0 ? '+' + (fisik - {{ $item->stok }}) : (fisik - {{ $item->stok }})">0</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <input type="text" wire:model.blur="itemNotes.{{ $item->id }}" class="block w-full text-xs border-gray-200 rounded-md focus:border-teal-500 focus:ring-teal-500" placeholder="Catatan item...">
                </div>
            </div>
        @empty
            <div class="text-center py-10 bg-white rounded-xl text-gray-500">
                Tidak ada barang ditemukan.
            </div>
        @endforelse
    </div>

    <!-- Desktop View (Table) -->
    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Barang</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok Sistem</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Stok Fisik</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Selisih</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($items as $item)
                        <tr wire:key="desktop-item-{{ $item->id }}" class="hover:bg-gray-50 transition-colors" x-data="{ fisik: @entangle('physicalStocks.'.$item->id) }">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $item->nama_barang }}</div>
                                <div class="text-xs text-gray-500 font-mono">{{ $item->kode_barang }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-semibold text-gray-700">{{ $item->stok }}</span>
                                <span class="text-xs text-gray-500">{{ $item->satuan }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" wire:model.blur="physicalStocks.{{ $item->id }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-center font-bold">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="font-bold" 
                                      :class="fisik - {{ $item->stok }} < 0 ? 'text-red-600' : (fisik - {{ $item->stok }} > 0 ? 'text-blue-600' : 'text-gray-300')">
                                    <span x-text="fisik - {{ $item->stok }} > 0 ? '+' + (fisik - {{ $item->stok }}) : (fisik - {{ $item->stok }})">0</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="text" wire:model.blur="itemNotes.{{ $item->id }}" class="block w-full text-sm border-gray-200 rounded-lg focus:border-teal-500 focus:ring-teal-500" placeholder="Keterangan...">
                            </td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada barang ditemukan di lokasi ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sticky Footer Actions -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-lg z-50 md:sticky md:bottom-auto md:border-0 md:shadow-none md:bg-transparent md:p-0">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-end gap-3">
            <button type="button" wire:click="save(false)" class="w-full md:w-auto px-6 py-3 bg-white border border-gray-300 rounded-xl font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all text-sm">
                Simpan Draft
            </button>
            <button type="button" wire:click="save(true)" 
                    wire:confirm="Apakah Anda yakin ingin memfinalisasi Stok Opname ini? Stok sistem akan diperbarui sesuai stok fisik yang diinput."
                    class="w-full md:w-auto px-6 py-3 bg-teal-600 border border-transparent rounded-xl font-bold text-white shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all text-sm flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Finalisasi & Update Stok
            </button>
        </div>
    </div>
</div>
