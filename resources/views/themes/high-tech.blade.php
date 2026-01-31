<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $pengaturan['app_description'] ?? 'Sistem Administrasi Kesehatan Terintegrasi' }}">
    <meta name="theme-color" content="{{ $pengaturan['primary_color'] ?? '#0f172a' }}">
    <title>{{ $pengaturan['app_name'] ?? 'SATRIA' }} - {{ $pengaturan['app_tagline'] ?? 'Health System' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-display: 'Outfit', sans-serif;
            --font-body: 'Space Grotesk', sans-serif;
            --color-primary: {{ $pengaturan['primary_color'] ?? '#3b82f6' }};
        }
        
        body { 
            font-family: var(--font-body); 
            background-color: #020617; /* Slate 950 */
            color: #e2e8f0; 
            overflow-x: hidden; 
        }
        
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-display); }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-primary); }

        /* Glassmorphism Utilities */
        .glass-nav {
            background: rgba(2, 6, 23, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .glass-card {
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.4) 0%, rgba(15, 23, 42, 0.6) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        .glass-card:hover {
            border-color: var(--color-primary);
            box-shadow: 0 0 30px -10px var(--color-primary);
        }

        /* Animations */
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        @keyframes glow { 0%, 100% { opacity: 0.5; } 50% { opacity: 1; } }
        .animate-glow { animation: glow 3s ease-in-out infinite; }

        .text-glow { text-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
        
        .bg-grid {
            background-size: 50px 50px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            mask-image: radial-gradient(circle at center, black 40%, transparent 100%);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased selection:bg-blue-500 selection:text-white" x-data="{ scrolled: false, mobileMenu: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Background Elements -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-grid"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-purple-600/10 rounded-full blur-[120px] translate-y-1/3 -translate-x-1/4"></div>
    </div>

    <!-- Announcement Bar -->
    @if(($pengaturan['announcement_active'] ?? '0') == '1')
        <div class="relative z-50 bg-blue-600/10 border-b border-blue-500/20 backdrop-blur-sm text-center py-2 px-4 overflow-hidden">
            <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-blue-400 animate-pulse mr-2">Info</span>
            <span class="text-xs md:text-sm font-medium text-blue-100">{{ $pengaturan['announcement_text'] }}</span>
        </div>
    @endif

    <!-- Navbar -->
    <nav :class="{ 'glass-nav py-4': scrolled, 'bg-transparent py-6': !scrolled }" class="fixed w-full z-40 transition-all duration-500 top-0 left-0 right-0">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-blue-600 to-cyan-400 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <div>
                        <h1 class="font-black text-xl tracking-tight text-white leading-none">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</h1>
                        <p class="text-[9px] font-bold uppercase tracking-[0.25em] text-blue-400 mt-0.5">Enterprise</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    @foreach(['Beranda', 'Layanan', 'Dokter', 'Fasilitas', 'Berita'] as $item)
                        <a href="#{{ strtolower($item) }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors uppercase tracking-wider relative group">
                            {{ $item }}
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                    @endforeach
                </div>

                <!-- CTA -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-full bg-white/5 border border-white/10 text-white text-xs font-bold uppercase tracking-wider hover:bg-white/10 transition-all flex items-center gap-2">
                            Dashboard
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">Login Staff</a>
                        <a href="{{ route('antrean.monitor') }}" class="px-6 py-2.5 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-blue-600/25 hover:shadow-blue-600/50 hover:bg-blue-500 transition-all transform hover:-translate-y-0.5">
                            Ambil Antrean
                        </a>
                    @endauth
                </div>

                <!-- Mobile Button -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden text-white p-2 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="absolute top-full left-0 w-full bg-[#020617] border-b border-white/10 p-6 md:hidden shadow-2xl">
            <div class="flex flex-col gap-4">
                @foreach(['Beranda', 'Layanan', 'Dokter', 'Fasilitas', 'Berita'] as $item)
                    <a href="#{{ strtolower($item) }}" @click="mobileMenu = false" class="text-sm font-bold text-slate-300 hover:text-white uppercase tracking-wider">{{ $item }}</a>
                @endforeach
                <div class="h-px bg-white/10 my-2"></div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-center w-full py-3 bg-white/10 rounded-xl text-white font-bold text-sm">Dashboard</a>
                @else
                    <a href="{{ route('antrean.monitor') }}" class="text-center w-full py-3 bg-blue-600 rounded-xl text-white font-bold text-sm shadow-lg shadow-blue-600/20">Daftar Antrean</a>
                    <a href="{{ route('login') }}" class="text-center w-full py-3 border border-white/10 rounded-xl text-slate-300 font-bold text-sm">Login Staff</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="beranda" class="relative min-h-screen flex items-center pt-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="space-y-8 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-900/30 border border-blue-500/30 backdrop-blur-sm animate-fade-in-up">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        <span class="text-xs font-bold text-blue-300 uppercase tracking-widest">{{ $pengaturan['app_tagline'] ?? 'Next Gen Healthcare' }}</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-black text-white leading-tight tracking-tight animate-fade-in-up" style="animation-delay: 0.1s">
                        {{ $pengaturan['hero_title'] ?? 'Masa Depan Layanan' }} 
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-400 to-emerald-400 text-glow">
                            {{ $pengaturan['hero_subtitle'] ?? 'Kesehatan' }}
                        </span>
                    </h1>
                    
                    <p class="text-lg text-slate-400 leading-relaxed max-w-xl mx-auto lg:mx-0 animate-fade-in-up" style="animation-delay: 0.2s">
                        {{ $pengaturan['app_description'] }}
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start animate-fade-in-up" style="animation-delay: 0.3s">
                        <a href="{{ route('antrean.monitor') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold text-sm uppercase tracking-wider hover:shadow-[0_0_40px_-10px_rgba(59,130,246,0.6)] transition-all transform hover:-translate-y-1 text-center">
                            Mulai Registrasi
                        </a>
                        @if(($pengaturan['show_pengaduan_cta'] ?? '1') == '1')
                            <a href="{{ route('pengaduan.public') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/5 border border-white/10 text-white font-bold text-sm uppercase tracking-wider hover:bg-white/10 hover:border-white/20 transition-all flex items-center justify-center gap-2 group">
                                <span>Layanan Pengaduan</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </a>
                        @endif
                    </div>

                    <!-- Stats Strip -->
                    <div class="grid grid-cols-3 gap-4 pt-8 border-t border-white/5 animate-fade-in-up" style="animation-delay: 0.4s">
                        <div>
                            <p class="text-3xl font-black text-white">{{ $stats['dokter_total'] ?? '0' }}</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Dokter Ahli</p>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-white">{{ $stats['layanan_total'] ?? '0' }}+</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Pasien Terlayani</p>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-white">24/7</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Layanan IGD</p>
                        </div>
                    </div>
                </div>

                <!-- Visual/Illustration -->
                <div class="relative lg:h-[600px] flex items-center justify-center animate-float hidden lg:flex">
                    <!-- Decorative Circles -->
                    <div class="absolute inset-0 border border-white/5 rounded-full scale-75 animate-spin-slow"></div>
                    <div class="absolute inset-0 border border-dashed border-white/10 rounded-full scale-100 animate-spin-reverse-slow"></div>
                    
                    <!-- Glass Card Floating -->
                    <div class="relative z-10 glass-card p-8 rounded-3xl max-w-sm w-full transform rotate-3 hover:rotate-0 transition-transform duration-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-lg">Sistem Terintegrasi</h3>
                                <p class="text-xs text-slate-400">Real-time Data Sync</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="h-2 w-full bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 w-3/4 rounded-full animate-pulse"></div>
                            </div>
                            <div class="h-2 w-2/3 bg-white/10 rounded-full"></div>
                            <div class="h-2 w-1/2 bg-white/10 rounded-full"></div>
                        </div>
                        <div class="mt-6 flex justify-between items-center">
                            <div class="flex -space-x-2">
                                <div class="w-8 h-8 rounded-full bg-slate-700 border-2 border-slate-800"></div>
                                <div class="w-8 h-8 rounded-full bg-slate-600 border-2 border-slate-800"></div>
                                <div class="w-8 h-8 rounded-full bg-slate-500 border-2 border-slate-800"></div>
                            </div>
                            <span class="text-xs font-bold text-emerald-400">System Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LAYANAN POLI -->
    @if(($pengaturan['show_layanan_poli'] ?? '1') == '1')
    <section id="layanan" class="py-24 relative bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-500 font-bold tracking-[0.2em] uppercase text-xs mb-2 block">Poliklinik</span>
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Layanan Spesialis</h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Kami menyediakan berbagai layanan poliklinik dengan dokter spesialis berpengalaman dan peralatan medis terkini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($layanan as $poli)
                <div class="glass-card p-8 rounded-3xl group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-blue-400 mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors">{{ $poli->nama_poli }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed mb-6">Layanan medis komprehensif dengan standar pelayanan terbaik untuk pasien.</p>
                        <span class="inline-flex items-center gap-2 text-xs font-bold text-blue-500 uppercase tracking-wider group-hover:gap-3 transition-all">
                            Detail Layanan <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- JADWAL DOKTER -->
    @if(($pengaturan['show_jadwal_dokter'] ?? '1') == '1')
    <section id="dokter" class="py-24 relative overflow-hidden">
        <!-- Background Grid -->
        <div class="absolute inset-0 bg-grid opacity-20"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <span class="text-emerald-500 font-bold tracking-[0.2em] uppercase text-xs mb-2 block">Jadwal Praktik</span>
                    <h2 class="text-3xl md:text-5xl font-black text-white">Dokter Hari Ini</h2>
                </div>
                <div class="px-5 py-2 rounded-xl bg-white/5 border border-white/10 backdrop-blur text-white text-sm font-bold flex items-center gap-3">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="glass-card p-6 rounded-3xl group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-2xl font-black text-white shadow-lg">
                                {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-lg truncate w-32">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                                <p class="text-xs text-emerald-400 font-bold uppercase tracking-wider">{{ $jadwal->pegawai->poli->nama_poli ?? 'Umum' }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-white/5">
                            <span class="text-xs text-slate-400 uppercase font-bold tracking-wider">Jam Praktik</span>
                            <span class="px-3 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 text-xs font-bold border border-emerald-500/20">
                                {{ $jadwal->shift->jam_masuk ?? '08:00' }} - {{ $jadwal->shift->jam_keluar ?? '14:00' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="glass-card p-12 text-center rounded-3xl border-dashed border-2 border-white/10">
                    <p class="text-slate-400">Jadwal dokter belum tersedia untuk hari ini.</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- FASILITAS -->
    @if(($pengaturan['show_fasilitas'] ?? '1') == '1')
    <section id="fasilitas" class="py-24 relative bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="mb-16">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Fasilitas Unggulan</h2>
                <div class="h-1 w-20 bg-blue-500 rounded-full"></div>
            </div>

            @if(isset($fasilitas) && count($fasilitas) > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($fasilitas as $f)
                    <div class="group relative h-80 rounded-3xl overflow-hidden cursor-pointer">
                        @if($f->gambar)
                            <img src="{{ Storage::url($f->gambar) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $f->nama_fasilitas }}">
                        @else
                            <div class="absolute inset-0 bg-slate-800 flex items-center justify-center">
                                <svg class="w-16 h-16 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                        
                        <div class="absolute bottom-0 left-0 p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            <h3 class="text-2xl font-bold text-white mb-2">{{ $f->nama_fasilitas }}</h3>
                            <p class="text-slate-300 text-sm line-clamp-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">{{ $f->deskripsi }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- BERITA -->
    <section id="berita" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="flex justify-between items-end mb-12">
                <h2 class="text-3xl md:text-5xl font-black text-white">Berita Terkini</h2>
                <a href="#" class="hidden md:block text-sm font-bold text-blue-500 hover:text-white transition-colors uppercase tracking-wider">Lihat Semua &rarr;</a>
            </div>

            @if(isset($beritaTerbaru) && count($beritaTerbaru) > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($beritaTerbaru as $berita)
                    <article class="glass-card rounded-3xl overflow-hidden group flex flex-col h-full hover:-translate-y-2 transition-transform duration-300">
                        <div class="h-48 bg-slate-800 relative overflow-hidden">
                            @if($berita->thumbnail)
                                <img src="{{ Storage::url($berita->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $berita->judul }}">
                            @endif
                            <div class="absolute top-4 left-4 bg-black/50 backdrop-blur px-3 py-1 rounded-lg border border-white/10">
                                <span class="text-[10px] font-bold text-white uppercase tracking-wider">{{ $berita->kategori ?? 'Umum' }}</span>
                            </div>
                        </div>
                        <div class="p-8 flex-1 flex flex-col">
                            <time class="text-xs font-bold text-blue-500 mb-3 block">{{ $berita->created_at->translatedFormat('d F Y') }}</time>
                            <h3 class="text-xl font-bold text-white mb-4 leading-tight group-hover:text-blue-400 transition-colors">{{ $berita->judul }}</h3>
                            <p class="text-slate-400 text-sm line-clamp-3 mb-6 flex-1">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                            <span class="text-xs font-bold text-white uppercase tracking-wider group-hover:text-blue-400 transition-colors flex items-center gap-2">
                                Baca Selengkapnya <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </span>
                        </div>
                    </article>
                    @endforeach
                </div>
            @else
                <div class="glass-card p-12 text-center rounded-3xl">
                    <p class="text-slate-400">Belum ada berita dipublikasikan.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="relative bg-slate-950 pt-24 pb-12 border-t border-white/5">
        <div class="absolute inset-0 bg-grid opacity-10"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-10 w-10 rounded-xl bg-blue-600 flex items-center justify-center text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm mb-8">
                        {{ $pengaturan['app_address'] ?? 'Alamat belum diatur.' }}
                    </p>
                    <div class="flex gap-4">
                        <!-- Social Placeholders -->
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-slate-400 hover:bg-blue-400 hover:text-white transition-all">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.106 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Tautan</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li><a href="#beranda" class="hover:text-blue-400 transition-colors">Beranda</a></li>
                        <li><a href="#layanan" class="hover:text-blue-400 transition-colors">Layanan Medis</a></li>
                        <li><a href="#dokter" class="hover:text-blue-400 transition-colors">Jadwal Dokter</a></li>
                        <li><a href="#berita" class="hover:text-blue-400 transition-colors">Berita & Artikel</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Kontak</h4>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            <span>{{ $pengaturan['app_phone'] ?? '-' }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span>{{ $pengaturan['app_email'] ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-bold text-slate-500 uppercase tracking-widest">
                <p>&copy; {{ date('Y') }} {{ $pengaturan['footer_text'] ?? 'All Rights Reserved.' }}</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
