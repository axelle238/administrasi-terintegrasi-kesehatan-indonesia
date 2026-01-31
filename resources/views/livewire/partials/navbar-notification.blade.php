<div x-data="{ dropdownOpen: false }" class="relative" wire:poll.15s>
    <!-- Lonceng Trigger -->
    <button @click="dropdownOpen = !dropdownOpen" class="relative p-2.5 rounded-xl text-slate-400 hover:bg-blue-50 hover:text-blue-600 focus:outline-none transition-all duration-300 group">
        <div class="absolute inset-0 bg-blue-50 rounded-xl scale-0 group-hover:scale-100 transition-transform"></div>
        <svg class="w-6 h-6 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @if($this->unreadCount > 0)
        <span class="absolute top-2.5 right-2.5 flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 ring-2 ring-white"></span>
        </span>
        @endif
    </button>

    <!-- Backdrop untuk menutup dropdown saat klik luar -->
    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-30 cursor-default" style="display: none;"></div>

    <!-- Dropdown Content -->
    <div x-show="dropdownOpen" 
         x-transition:enter="transition ease-out duration-200" 
         x-transition:enter-start="transform opacity-0 scale-95 translate-y-2" 
         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" 
         x-transition:leave="transition ease-in duration-150" 
         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" 
         x-transition:leave-end="transform opacity-0 scale-95 translate-y-2" 
         class="absolute right-0 z-40 w-80 md:w-96 mt-3 origin-top-right bg-white rounded-2xl shadow-xl ring-1 ring-black/5 focus:outline-none overflow-hidden" 
         style="display: none;">
        
        <!-- Header Dropdown -->
        <div class="px-4 py-3 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between backdrop-blur-sm">
            <h3 class="text-sm font-bold text-slate-800">Notifikasi</h3>
            
            @if($this->unreadCount > 0)
                <button wire:click="markAllRead" class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline">
                    Tandai Semua Dibaca
                </button>
            @else
                <span class="text-xs text-slate-400 font-medium">Semua sudah dibaca</span>
            @endif
        </div>

        <!-- List Notifikasi -->
        <div class="max-h-[400px] overflow-y-auto custom-scrollbar">
            @forelse($this->notifications as $notif)
                <div wire:click="markAsRead('{{ $notif->id }}')" 
                     class="px-4 py-3 hover:bg-slate-50 transition-colors cursor-pointer border-b border-slate-50 last:border-0 relative group {{ $notif->read_at ? 'opacity-75' : 'bg-blue-50/30' }}">
                    
                    <div class="flex gap-3">
                        <!-- Icon Kategori -->
                        <div class="flex-shrink-0 mt-1">
                            @php
                                $color = $notif->data['warna'] ?? 'blue';
                                $icon = $notif->data['ikon'] ?? 'information-circle';
                            @endphp
                            <div class="w-8 h-8 rounded-full bg-{{ $color }}-100 text-{{ $color }}-600 flex items-center justify-center">
                                @if($icon == 'check-circle') <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @elseif($icon == 'exclamation-triangle') <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                @elseif($icon == 'x-circle') <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @elseif($icon == 'bell-alert') <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                @else <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-0.5">
                                {{ $notif->data['kategori'] ?? 'Info' }}
                            </p>
                            <h4 class="text-sm font-bold text-slate-800 leading-tight mb-1">
                                {{ $notif->data['judul'] ?? 'Notifikasi Baru' }}
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-2">
                                {{ $notif->data['pesan'] ?? '' }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-2 font-medium">
                                {{ $notif->created_at->diffForHumans() }}
                            </p>
                        </div>
                        
                        @if(!$notif->read_at)
                        <div class="absolute top-4 right-4 w-2 h-2 rounded-full bg-blue-500"></div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto text-slate-300 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Tidak ada notifikasi baru</p>
                </div>
            @endforelse
        </div>

        <!-- Footer Dropdown -->
        <a href="#" class="block px-4 py-3 bg-slate-50 text-center text-xs font-bold text-blue-600 hover:text-blue-700 hover:bg-blue-50 transition-colors border-t border-slate-100 uppercase tracking-wider">
            Lihat Semua Aktivitas
        </a>
    </div>
</div>
