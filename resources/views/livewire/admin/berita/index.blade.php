<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="w-full md:w-1/3">
            <input wire:model.live.debounce.300ms="search" type="search" placeholder="Cari judul berita..." class="w-full rounded-xl border-slate-200 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all text-sm">
        </div>
        <a href="{{ route('admin.berita.create') }}" class="btn-primary w-full md:w-auto flex justify-center items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tulis Berita Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-bold tracking-wider">Judul & Kategori</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Penulis</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Status</th>
                        <th class="px-6 py-4 font-bold tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 font-bold tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($berita as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $item->judul }}</div>
                                <div class="text-xs text-slate-500 mt-1 flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-600 font-bold">{{ $item->kategori }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $item->penulis->name ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status == 'published')
                                    <span class="badge-success">Published</span>
                                @else
                                    <span class="badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.berita.edit', $item->id) }}" class="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <button wire:confirm="Yakin ingin menghapus berita ini?" wire:click="delete({{ $item->id }})" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                Belum ada berita yang ditulis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $berita->links() }}
        </div>
    </div>
</div>