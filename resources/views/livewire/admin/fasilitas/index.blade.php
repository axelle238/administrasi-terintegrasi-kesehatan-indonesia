<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="w-full md:w-1/3">
            <input wire:model.live.debounce.300ms="search" type="search" placeholder="Cari nama fasilitas..." class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all text-sm">
        </div>
        <a href="{{ route('admin.fasilitas.create') }}" class="btn-primary w-full md:w-auto flex justify-center items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Fasilitas
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-wider">Fasilitas</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Jenis</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Status</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($fasilitas as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($item->gambar)
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden">
                                            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $item->nama_fasilitas }}</div>
                                        <div class="text-xs text-slate-500 line-clamp-1">{{ Str::limit($item->deskripsi, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs font-bold capitalize bg-slate-100 text-slate-600">
                                    {{ $item->jenis }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->is_active)
                                    <span class="badge-success">Aktif</span>
                                @else
                                    <span class="badge-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.fasilitas.edit', $item->id) }}" class="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <button wire:confirm="Yakin ingin menghapus fasilitas ini?" wire:click="delete({{ $item->id }})" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                Belum ada data fasilitas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $fasilitas->links() }}
        </div>
    </div>
</div>