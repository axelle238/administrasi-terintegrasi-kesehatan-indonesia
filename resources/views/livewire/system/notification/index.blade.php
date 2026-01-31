<div class="space-y-6">
    <!-- Header Controls -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
        
        <!-- Filter Tabs -->
        <div class="flex p-1 bg-slate-100 rounded-xl">
            <button wire:click="setFilter('all')" class="px-4 py-2 text-sm font-bold rounded-lg transition-all {{ $filter === 'all' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Semua
            </button>
            <button wire:click="setFilter('unread')" class="px-4 py-2 text-sm font-bold rounded-lg transition-all {{ $filter === 'unread' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Belum Dibaca
            </button>
        </div>

        <!-- Filter Kategori & Action -->
        <div class="flex items-center gap-3">
            <select wire:model.live="kategoriFilter" class="form-select text-sm border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Kategori</option>
                <option value="info">Informasi</option>
                <option value="success">Berhasil</option>
                <option value="warning">Peringatan</option>
                <option value="danger">Bahaya/Error</option>
                <option value="urgent">Mendesak</option>
            </select>

            <button wire:click="markAllRead" class="px-4 py-2 bg-blue-50 text-blue-600 text-sm font-bold rounded-xl hover:bg-blue-100 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Baca Semua
            </button>
        </div>
    </div>

    <!-- Notification List -->
    <div class="space-y-4">
        @forelse($notifications as $notif)
            @php
                $color = $notif->data['warna'] ?? 'blue';
                $icon = $notif->data['ikon'] ?? 'information-circle';
                $isRead = !is_null($notif->read_at);
            @endphp
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 relative overflow-hidden group transition-all hover:shadow-md {{ !$isRead ? 'border-l-4 border-l-'.$color.'-500 bg-'.$color.'-50/10' : '' }}">
                <div class="flex gap-5 items-start">
                    <!-- Icon Box -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-2xl bg-{{ $color }}-50 text-{{ $color }}-600 flex items-center justify-center">
                            @if($icon == 'check-circle') <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @elseif($icon == 'exclamation-triangle') <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            @elseif($icon == 'x-circle') <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @elseif($icon == 'bell-alert') <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                            @else <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @endif
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0 pt-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-{{ $color }}-100 text-{{ $color }}-800 uppercase tracking-wide mb-2">
                                    {{ $notif->data['kategori'] ?? 'System' }}
                                </span>
                                <h3 class="text-lg font-bold text-slate-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors" wire:click="markAsRead('{{ $notif->id }}')">
                                    {{ $notif->data['judul'] ?? 'Tidak ada judul' }}
                                </h3>
                            </div>
                            <span class="text-xs font-bold text-slate-400 whitespace-nowrap ml-4">
                                {{ $notif->created_at->isoFormat('D MMMM Y, HH:mm') }}
                                <br>
                                <span class="font-normal opacity-70 block text-right mt-1">{{ $notif->created_at->diffForHumans() }}</span>
                            </span>
                        </div>
                        
                        <p class="text-slate-600 leading-relaxed mb-4 max-w-3xl">
                            {{ $notif->data['pesan'] ?? '' }}
                        </p>

                        <div class="flex items-center gap-4">
                            @if(isset($notif->data['url']) && $notif->data['url'] !== '#')
                            <button wire:click="markAsRead('{{ $notif->id }}')" class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 group/link">
                                Lihat Detail
                                <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </button>
                            @endif

                            @if(!$isRead)
                            <button wire:click="markAsRead('{{ $notif->id }}')" class="text-sm font-medium text-slate-500 hover:text-slate-800">
                                Tandai Dibaca
                            </button>
                            @else
                            <button wire:click="delete('{{ $notif->id }}')" class="text-sm font-medium text-red-400 hover:text-red-600">
                                Hapus
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Tidak Ada Notifikasi</h3>
                <p class="text-slate-500 max-w-sm text-center">Saat ini Anda tidak memiliki notifikasi {{ $filter === 'unread' ? 'yang belum dibaca' : '' }}.</p>
                @if($filter !== 'all')
                    <button wire:click="setFilter('all')" class="mt-6 px-6 py-2 bg-blue-50 text-blue-600 font-bold rounded-xl hover:bg-blue-100 transition-colors">
                        Lihat Semua Riwayat
                    </button>
                @endif
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
