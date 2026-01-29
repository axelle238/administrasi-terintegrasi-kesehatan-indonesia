<div class="space-y-6">
    <!-- Header & Search -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="w-full md:w-1/2">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="search" 
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-all duration-200" 
                    placeholder="Cari Kode ICD (A00) atau Nama Penyakit (Demam...)" autofocus>
            </div>
        </div>
        
        <div class="flex items-center gap-2 w-full md:w-auto">
            <select wire:model.live="filterBpjs" class="block w-full py-2.5 pl-3 pr-10 text-sm border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">Semua Tipe</option>
                <option value="1">Ditanggung BPJS</option>
                <option value="0">Non-BPJS</option>
            </select>
            
            <button type="button" class="inline-flex items-center px-4 py-2.5 border border-slate-200 rounded-xl shadow-sm text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Import Data
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-24">Kode ICD</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Diagnosa (Indonesia)</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">Diagnosa (Inggris/WHO)</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-24">BPJS</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($penyakit as $item)
                    <tr class="hover:bg-slate-50 transition-colors duration-150 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-sm font-bold bg-blue-100 text-blue-700 font-mono">
                                {{ $item->code }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-800">{{ $item->name_id ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            <div class="text-sm text-slate-500 italic">{{ $item->name_en }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($item->is_bpjs)
                                <svg class="h-6 w-6 text-green-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-slate-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-slate-400 hover:text-blue-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-lg font-medium">Tidak ada data penyakit ditemukan.</p>
                                <p class="text-sm">Coba kata kunci lain atau reset filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
            {{ $penyakit->links() }}
        </div>
    </div>
    
    <!-- Info Footer -->
    <div class="text-center text-xs text-slate-400">
        Data berdasarkan ICD-10 WHO Version 2010. Digunakan untuk standar koding diagnosa BPJS Kesehatan.
    </div>
</div>