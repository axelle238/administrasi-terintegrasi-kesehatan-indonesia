<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    
    @if($isReplying)
        <!-- Reply Form Section -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-t-4 border-teal-500">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Tanggapi Pengaduan</h3>
                <button wire:click="cancelReply" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            @php $p = \App\Models\Pengaduan::find($selectedId); @endphp
            @if($p)
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                        <div>
                            <p class="text-gray-500">Pelapor:</p>
                            <p class="font-bold">{{ $p->nama_pelapor }} ({{ $p->no_telepon_pelapor }})</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Waktu:</p>
                            <p class="font-bold">{{ $p->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-500">Subjek:</p>
                        <p class="font-bold">{{ $p->subjek }}</p>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-500">Isi Pengaduan:</p>
                        <div class="mt-1 text-gray-800 whitespace-pre-wrap">{{ $p->isi_pengaduan }}</div>
                    </div>
                    @if($p->file_lampiran)
                        <div class="mt-4">
                            <a href="{{ asset('storage/'.$p->file_lampiran) }}" target="_blank" class="inline-flex items-center text-teal-600 hover:underline">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                Lihat Lampiran
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <form wire:submit.prevent="saveReply" class="space-y-4">
                <div>
                    <x-input-label for="newStatus" value="Update Status" />
                    <select wire:model="newStatus" id="newStatus" class="border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm block mt-1 w-full">
                        <option value="Pending">Pending</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="tanggapan" value="Isi Tanggapan" />
                    <textarea wire:model="tanggapan" id="tanggapan" class="border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm block mt-1 w-full" rows="5" required placeholder="Tuliskan tindakan atau jawaban resmi..."></textarea>
                    @error('tanggapan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="cancelReply" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-teal-600 text-white font-bold rounded-md hover:bg-teal-700 transition shadow-md">Simpan Tanggapan & Perbarui Status</button>
                </div>
            </form>
        </div>
    @else
        <!-- Filter & Search Section -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <div class="relative">
                    <x-text-input wire:model.live.debounce.300ms="search" placeholder="Cari pelapor atau isi..." class="w-full md:w-64 pl-10" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </div>
                <select wire:model.live="filterStatus" class="border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="">Semua Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelapor & Subjek</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Isi Pengaduan</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pengaduans as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $p->nama_pelapor }}</div>
                                    <div class="text-xs text-gray-500">{{ $p->no_telepon_pelapor }}</div>
                                    <div class="mt-1 text-sm font-medium text-teal-600">{{ $p->subjek }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 line-clamp-2">{{ $p->isi_pengaduan }}</div>
                                    <div class="text-[10px] text-gray-400 mt-1">{{ $p->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                        @if($p->status == 'Selesai') bg-green-100 text-green-800 
                                        @elseif($p->status == 'Diproses') bg-blue-100 text-blue-800 
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <button wire:click="selectForReply({{ $p->id }})" class="text-teal-600 hover:text-teal-900 font-bold">Tanggapi</button>
                                        <button wire:click="delete({{ $p->id }})" wire:confirm="Hapus pengaduan ini?" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">Belum ada pengaduan masyarakat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $pengaduans->links() }}
            </div>
        </div>
    @endif
</div>
