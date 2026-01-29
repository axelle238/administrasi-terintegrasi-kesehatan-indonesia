<div class="space-y-8">
    <!-- Row 1: Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pengaduan</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $totalPengaduan }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Selesai</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $pengaduanSelesai }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Diproses</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $pengaduanProses }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Rata-rata Waktu Respon</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $avgResponseTime }} <span class="text-sm font-medium text-slate-400">Jam</span></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: IKM & Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- IKM Score -->
        <div class="bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg flex flex-col justify-center items-center text-center relative overflow-hidden group">
            <div class="relative z-10">
                <h3 class="text-5xl font-black mb-2">{{ number_format($ikmScore, 1) }}<span class="text-2xl opacity-75">/5.0</span></h3>
                <p class="text-sm font-bold text-orange-100 uppercase tracking-widest mb-4">Indeks Kepuasan Masyarakat</p>
                
                <!-- Star Rating Visual -->
                <div class="flex gap-1 mb-6 text-yellow-300">
                    @for($i=1; $i<=5; $i++)
                        @if($i <= round($ikmScore))
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        @else
                            <svg class="w-6 h-6 text-orange-400 fill-current opacity-50" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        @endif
                    @endfor
                </div>

                <div class="inline-flex items-center gap-2 bg-white/20 px-4 py-2 rounded-full backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                    <span class="font-bold">{{ $totalResponden }} Responden</span>
                </div>
            </div>
            <svg class="absolute bottom-0 right-0 w-48 h-48 text-white opacity-10 -mr-10 -mb-10 transform group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
        </div>

        <!-- Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Tren Pengaduan Bulanan</h3>
            <div class="h-64 flex items-end justify-between gap-4 px-4">
                @foreach($grafikPengaduan['data'] as $index => $val)
                    <div class="flex flex-col items-center flex-1 group">
                        <div class="w-full bg-orange-100 dark:bg-orange-900/30 rounded-t-lg relative transition-all duration-300 hover:bg-orange-200" 
                             style="height: {{ $val > 0 ? ($val / (max($grafikPengaduan['data']) ?: 1) * 100) : 0 }}%">
                             <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-xs font-bold text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity">{{ $val }}</span>
                        </div>
                        <span class="text-[10px] text-slate-400 mt-2 font-bold">{{ $grafikPengaduan['labels'][$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Row 3: Recent List & Channels -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent List -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Aduan Terbaru</h3>
            <div class="space-y-4">
                @forelse($pengaduanTerbaru as $p)
                    <div class="flex justify-between items-center p-4 bg-slate-50 dark:bg-slate-700/30 rounded-xl hover:bg-slate-100 transition-colors">
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 dark:text-white">{{ $p->subjek }}</h4>
                            <p class="text-xs text-slate-500 mt-1">{{ $p->nama_pelapor }} - {{ $p->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-widest
                            @if($p->status == 'Pending') bg-yellow-100 text-yellow-800
                            @elseif($p->status == 'Diproses') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ $p->status }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-400 text-sm">Belum ada pengaduan.</div>
                @endforelse
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('admin.masyarakat.pengaduan.index') }}" wire:navigate class="text-xs font-bold text-blue-600 hover:text-blue-800 uppercase tracking-widest">Lihat Semua Pengaduan &rarr;</a>
            </div>
        </div>

        <!-- Channels -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Kanal Pengaduan Utama</h3>
            <div class="space-y-4">
                @foreach($kanalPengaduan as $kanal)
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                @if(Str::contains($kanal['nama'], 'Web'))
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                @elseif(Str::contains($kanal['nama'], 'Whats'))
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                @endif
                            </div>
                            <span class="text-sm font-bold text-slate-700 dark:text-gray-300">{{ $kanal['nama'] }}</span>
                        </div>
                        <span class="px-2 py-1 bg-slate-100 dark:bg-slate-700 rounded-lg text-xs font-black">{{ $kanal['total'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>