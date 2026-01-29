<div class="space-y-6">
    <!-- Header Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- IKM Score -->
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-6 rounded-3xl text-white shadow-xl shadow-orange-500/20 relative overflow-hidden flex items-center justify-between group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div>
                <p class="text-xs font-bold text-orange-100 uppercase tracking-widest mb-1">Indeks Kepuasan</p>
                <h3 class="text-4xl font-black">{{ number_format($ikmScore, 1) }}</h3>
                <p class="text-[10px] font-medium bg-white/20 px-2 py-1 rounded inline-block mt-2">Dari {{ $totalResponden }} Responden</p>
            </div>
            <div class="text-right">
                @if($ikmScore >= 80)
                    <span class="text-5xl">😁</span>
                @elseif($ikmScore >= 60)
                    <span class="text-5xl">🙂</span>
                @else
                    <span class="text-5xl">😐</span>
                @endif
            </div>
        </div>

        <!-- UKM Shortcut -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:border-indigo-200 transition-colors cursor-pointer" wire:click="setTab('ukm')">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kegiatan UKM</p>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white mt-1">Program Kesehatan</h3>
                </div>
                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-indigo-600 font-bold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                Kelola Kegiatan <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </p>
        </div>

        <!-- Survey Shortcut -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:border-pink-200 transition-colors cursor-pointer" wire:click="setTab('survey')">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Feedback</p>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white mt-1">Ulasan Masyarakat</h3>
                </div>
                <div class="p-2 bg-pink-50 dark:bg-pink-900/30 rounded-lg text-pink-600 dark:text-pink-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-pink-600 font-bold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                Lihat Detail <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="border-b border-gray-100 dark:border-gray-700 px-6 pt-4 flex gap-8 overflow-x-auto">
            <button wire:click="setTab('ikhtisar')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'ikhtisar' ? 'text-amber-600' : 'text-gray-400 hover:text-gray-600' }}">
                Ringkasan Pelayanan
                @if($activeTab == 'ikhtisar') <div class="absolute bottom-0 left-0 w-full h-1 bg-amber-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('ukm')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'ukm' ? 'text-indigo-600' : 'text-gray-400 hover:text-gray-600' }}">
                Kegiatan UKM
                @if($activeTab == 'ukm') <div class="absolute bottom-0 left-0 w-full h-1 bg-indigo-600 rounded-t-full"></div> @endif
            </button>
            <button wire:click="setTab('survey')" class="pb-4 text-sm font-bold transition-all relative whitespace-nowrap {{ $activeTab == 'survey' ? 'text-pink-600' : 'text-gray-400 hover:text-gray-600' }}">
                Survey Kepuasan
                @if($activeTab == 'survey') <div class="absolute bottom-0 left-0 w-full h-1 bg-pink-600 rounded-t-full"></div> @endif
            </button>
        </div>

        <div class="p-8 min-h-[400px]">
            <!-- TAB 1: IKHTISAR -->
            @if($activeTab == 'ikhtisar')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-up">
                    <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tren Kepuasan (6 Bulan)</h4>
                        <div class="h-64 flex items-end justify-between gap-4">
                            @foreach($tabData['trenKepuasan']['data'] as $idx => $val)
                                <div class="flex flex-col items-center flex-1 h-full justify-end group">
                                    <div class="w-full max-w-[50px] bg-amber-400 rounded-t-lg relative transition-all duration-300 hover:bg-amber-500" 
                                         style="height: {{ $val > 0 ? ($val / 5) * 100 : 0 }}%">
                                         <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">{{ $val }}</span>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500 mt-2">{{ $tabData['trenKepuasan']['labels'][$idx] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">Pengaduan Masuk Terbaru</h4>
                            <a href="{{ route('admin.masyarakat.pengaduan.index') }}" class="text-xs font-bold text-indigo-600 hover:underline">Kelola Semua</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($tabData['pengaduanTerbaru'] as $p)
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <div class="flex justify-between items-start mb-1">
                                        <h5 class="text-sm font-bold text-gray-900 dark:text-white truncate pr-2">{{ $p->subjek }}</h5>
                                        <span class="text-[10px] text-gray-400 whitespace-nowrap">{{ $p->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-xs text-gray-500 line-clamp-1">{{ $p->nama_pelapor }}: {{ $p->isi_pengaduan }}</p>
                                    <div class="mt-2">
                                        @if($p->status == 'Menunggu')
                                            <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-[10px] font-bold rounded">Menunggu</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded">{{ $p->status }}</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-center py-8 text-gray-400 text-sm">Belum ada pengaduan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 2: UKM -->
            @if($activeTab == 'ukm')
                <div class="space-y-6 animate-fade-in-up">
                    <div class="flex gap-4">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kegiatan..." class="w-full sm:w-72 pl-4 pr-10 py-2 rounded-xl border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm focus:ring-indigo-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($tabData['kegiatans'] as $kegiatan)
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow group">
                                <div class="h-40 bg-slate-200 dark:bg-slate-700 relative">
                                    @if($kegiatan->foto)
                                        <img src="{{ asset('storage/' . $kegiatan->foto) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center text-slate-400">
                                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-gray-700">
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y') }}
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h4 class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-1" title="{{ $kegiatan->nama_kegiatan }}">{{ $kegiatan->nama_kegiatan }}</h4>
                                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ $kegiatan->lokasi }}
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $kegiatan->deskripsi }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-400">Tidak ada kegiatan UKM ditemukan.</div>
                        @endforelse
                    </div>
                    
                    {{ $tabData['kegiatans']->links() }}
                </div>
            @endif

            <!-- TAB 3: SURVEY -->
            @if($activeTab == 'survey')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-bold text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-500 uppercase">Nama (Opsional)</th>
                                        <th class="px-4 py-3 text-center font-bold text-gray-500 uppercase">Rating</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-500 uppercase">Kritik & Saran</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($tabData['surveys'] as $s)
                                        <tr>
                                            <td class="px-4 py-3 text-gray-500">{{ $s->created_at->format('d/m/y H:i') }}</td>
                                            <td class="px-4 py-3 font-bold text-gray-800 dark:text-gray-200">{{ $s->nama_responden ?? 'Anonim' }}</td>
                                            <td class="px-4 py-3 text-center text-amber-500 font-bold">
                                                {{ $s->rating_layanan }} <span class="text-gray-400 text-xs font-normal">/ 5</span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400 italic line-clamp-1" title="{{ $s->kritik_saran }}">{{ $s->kritik_saran ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada data survey.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $tabData['surveys']->links() }}
                    </div>

                    <div class="space-y-6">
                        <div class="bg-pink-50 dark:bg-pink-900/20 p-6 rounded-2xl border border-pink-100 dark:border-pink-800">
                            <h4 class="text-lg font-bold text-pink-800 dark:text-pink-300 mb-4">Distribusi Rating</h4>
                            <div class="space-y-2">
                                @for($i=5; $i>=1; $i--)
                                    @php 
                                        $count = $tabData['distribusiBintang']->where('rating_layanan', $i)->first()->total ?? 0;
                                        $percent = $totalResponden > 0 ? ($count / $totalResponden) * 100 : 0;
                                    @endphp
                                    <div class="flex items-center gap-2 text-xs">
                                        <span class="font-bold w-3">{{ $i }}</span>
                                        <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <div class="flex-1 bg-white dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                                            <div class="bg-amber-400 h-full rounded-full" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="w-8 text-right">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
