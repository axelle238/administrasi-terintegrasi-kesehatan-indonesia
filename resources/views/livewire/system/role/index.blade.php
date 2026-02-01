<div class="space-y-8 animate-fade-in">
    
    <!-- Hero Header & Stats -->
    <div class="relative overflow-hidden rounded-[3rem] bg-slate-900 p-8 md:p-12 shadow-2xl">
        <!-- Background Decor -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-indigo-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-fuchsia-500/20 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-start lg:items-end gap-8">
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-indigo-200 text-[10px] font-black uppercase tracking-[0.2em] backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                    System Security
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-white tracking-tight leading-tight">
                    Hak Akses & <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Peran Pengguna</span>
                </h2>
                <p class="text-slate-400 font-medium max-w-lg text-sm md:text-base leading-relaxed">
                    Kelola struktur otorisasi sistem dengan presisi. Tentukan siapa yang dapat mengakses fitur sensitif dan operasional.
                </p>
            </div>

            <!-- Quick Action -->
            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                <div class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Role</p>
                        <p class="text-2xl font-black text-white">{{ $roles->count() }}</p>
                    </div>
                    <div class="h-8 w-px bg-white/10"></div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total User</p>
                        <p class="text-2xl font-black text-white">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
                
                <a href="{{ route('system.role.create') }}" class="group relative px-8 py-4 bg-white text-slate-900 rounded-2xl text-sm font-black uppercase tracking-wider hover:bg-indigo-50 transition-all flex items-center justify-center gap-3 shadow-lg shadow-white/10 overflow-hidden">
                    <span class="relative z-10 flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Buat Role Baru
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Role Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($roles as $role)
            @php
                // Tentukan Tema Warna Berdasarkan Nama Role
                $theme = match(true) {
                    Str::contains(strtolower($role->name), ['admin', 'security']) => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'border' => 'border-indigo-100', 'gradient' => 'from-indigo-500 to-purple-600', 'icon' => 'shield'],
                    Str::contains(strtolower($role->name), ['dokter', 'medis', 'perawat']) => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100', 'gradient' => 'from-emerald-400 to-teal-500', 'icon' => 'heart'],
                    Str::contains(strtolower($role->name), ['keuangan', 'kasir', 'finance']) => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'border' => 'border-amber-100', 'gradient' => 'from-amber-400 to-orange-500', 'icon' => 'cash'],
                    Str::contains(strtolower($role->name), ['hrd', 'pegawai', 'sdm']) => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'border' => 'border-rose-100', 'gradient' => 'from-rose-400 to-pink-500', 'icon' => 'users'],
                    Str::contains(strtolower($role->name), ['farmasi', 'obat', 'apotek']) => ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-600', 'border' => 'border-cyan-100', 'gradient' => 'from-cyan-400 to-blue-500', 'icon' => 'beaker'],
                    default => ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'border' => 'border-slate-100', 'gradient' => 'from-slate-400 to-slate-600', 'icon' => 'cube']
                };

                // Hitung Persentase Akses (Estimasi Visual)
                $totalPerms = \App\Models\Permission::count();
                $rolePerms = $role->permissions_count;
                $percentage = $totalPerms > 0 ? ($rolePerms / $totalPerms) * 100 : 0;
            @endphp

            <div class="group relative bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">
                <!-- Top Decor -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br {{ $theme['gradient'] }} opacity-5 rounded-bl-[3rem] transition-opacity group-hover:opacity-10"></div>
                
                <!-- Header -->
                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl {{ $theme['bg'] }} {{ $theme['text'] }} flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                            @if($theme['icon'] == 'shield') <i class="fas fa-shield-alt"></i> <!-- Fallback if no fontawesome, use SVG -->
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            @elseif($theme['icon'] == 'heart')
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            @elseif($theme['icon'] == 'cash')
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @elseif($theme['icon'] == 'users')
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            @elseif($theme['icon'] == 'beaker')
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            @else
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight group-hover:{{ $theme['text'] }} transition-colors">{{ $role->name }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Guard: {{ $role->guard_name }}</p>
                        </div>
                    </div>
                    
                    <!-- Action Menu -->
                    <div class="flex gap-1">
                        <a href="{{ route('system.role.edit', $role->id) }}" class="p-2 rounded-xl text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors" title="Edit Konfigurasi">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <button wire:click="delete({{ $role->id }})" 
                                onclick="return confirm('Hapus role ini?') || event.stopImmediatePropagation()"
                                class="p-2 rounded-xl text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-colors" title="Hapus Role">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </div>
                </div>

                <!-- Body: Users Stack -->
                <div class="flex-1">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-slate-500">Pengguna Aktif</span>
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-black">{{ $role->users_count }} User</span>
                        </div>
                        <div class="flex -space-x-3 items-center">
                            @foreach($role->users()->take(5)->get() as $user)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[9px] font-bold text-slate-500 relative group/avatar overflow-hidden" title="{{ $user->name }}">
                                    @if(isset($user->pegawai->foto_profil) && $user->pegawai->foto_profil)
                                        <img src="{{ Storage::url($user->pegawai->foto_profil) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($user->name, 0, 1) }}
                                    @endif
                                </div>
                            @endforeach
                            @if($role->users_count > 5)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-50 flex items-center justify-center text-[9px] font-black text-slate-400">
                                    +{{ $role->users_count - 5 }}
                                </div>
                            @endif
                            @if($role->users_count == 0)
                                <span class="text-[10px] text-slate-400 italic pl-4">Belum ada pengguna.</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer: Permission Meter -->
                <div class="mt-auto pt-4 border-t border-dashed {{ $theme['border'] }}">
                    <div class="flex justify-between items-end mb-2">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Akses Fitur</p>
                            <p class="text-sm font-bold {{ $theme['text'] }} mt-0.5">
                                {{ $rolePerms }} <span class="text-slate-400 font-medium text-xs">/ {{ $totalPerms }}</span>
                            </p>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400">{{ number_format($percentage) }}%</span>
                    </div>
                    <!-- Progress Bar -->
                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r {{ $theme['gradient'] }} rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800">Belum Ada Role</h3>
                <p class="text-slate-400 max-w-sm mx-auto mt-2 mb-8">Sistem belum memiliki definisi peran. Buat role pertama Anda untuk mulai mengatur hak akses.</p>
                <a href="{{ route('system.role.create') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all">
                    Buat Role Administrator
                </a>
            </div>
        @endforelse
    </div>
</div>