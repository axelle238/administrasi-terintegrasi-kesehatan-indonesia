<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="w-full md:w-1/3 flex gap-2">
            <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari Surat..." class="w-full" />
            <select wire:model.live="jenisFilter" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Semua</option>
                <option value="Masuk">Masuk</option>
                <option value="Keluar">Keluar</option>
            </select>
        </div>
        
        <a href="{{ route('surat.create') }}" wire:navigate class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Arsip Surat Baru
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat / Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim / Penerima</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sifat</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($surats as $surat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $surat->nomor_surat }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                                {{ $surat->perihal }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($surat->jenis_surat == 'Masuk')
                                    <span class="text-green-600 font-medium">← {{ $surat->pengirim }}</span>
                                @else
                                    <span class="text-blue-600 font-medium">→ {{ $surat->penerima }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $surat->jenis_surat == 'Masuk' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $surat->jenis_surat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($surat->jenis_surat == 'Masuk')
                                    <button wire:click="$dispatch('openDisposisi', { suratId: {{ $surat->id }} })" class="text-orange-600 hover:text-orange-900 mr-3 font-bold" title="Buat Disposisi">
                                        Disposisi
                                    </button>
                                @endif
                                <a href="{{ route('surat.edit', $surat->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <button wire:click="delete({{ $surat->id }})" wire:confirm="Hapus surat ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 italic">
                                Tidak ada surat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden">
            @forelse ($surats as $surat)
                <div class="p-4 border-b border-gray-200 last:border-b-0">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2 py-1 text-xs font-bold rounded-full {{ $surat->jenis_surat == 'Masuk' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $surat->jenis_surat }}
                        </span>
                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}</div>
                    </div>
                    
                    <h4 class="text-sm font-bold text-gray-900 mb-1">{{ $surat->nomor_surat }}</h4>
                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $surat->perihal }}</p>
                    
                    <div class="text-xs text-gray-500 mb-3">
                        @if($surat->jenis_surat == 'Masuk')
                            Dari: <span class="font-medium text-gray-800">{{ $surat->pengirim }}</span>
                        @else
                            Kepada: <span class="font-medium text-gray-800">{{ $surat->penerima }}</span>
                        @endif
                    </div>

                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                        @if($surat->jenis_surat == 'Masuk')
                            <button wire:click="$dispatch('openDisposisi', { suratId: {{ $surat->id }} })" class="px-3 py-1.5 bg-orange-50 text-orange-700 rounded-lg text-xs font-bold">Disposisi</button>
                        @endif
                        <a href="{{ route('surat.edit', $surat->id) }}" wire:navigate class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-bold">Edit</a>
                        <button wire:click="delete({{ $surat->id }})" wire:confirm="Hapus?" class="px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-bold">Hapus</button>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500 text-sm">Tidak ada surat.</div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            {{ $surats->links() }}
        </div>
    </div>

    {{-- Komponen Modal Disposisi --}}
    <livewire:surat.disposisi />
</div>
