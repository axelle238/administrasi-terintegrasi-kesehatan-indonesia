<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $pengaturan['deskripsi'] ?? '' }}">
    <meta name="theme-color" content="{{ $pengaturan['primary_color'] ?? '#0d9488' }}">
    <title>{{ $pengaturan['nama_aplikasi'] ?? 'SATRIA' }} - {{ $pengaturan['tagline'] ?? '' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: {{ $pengaturan['primary_color'] ?? '#0d9488' }};
            --primary-rgb: {{ hexdec(substr($pengaturan['primary_color'] ?? '#0d9488', 1, 2)) }}, {{ hexdec(substr($pengaturan['primary_color'] ?? '#0d9488', 3, 2)) }}, {{ hexdec(substr($pengaturan['primary_color'] ?? '#0d9488', 5, 2)) }};
        }
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        
        .text-primary { color: var(--primary-color); }
        .bg-primary { background-color: var(--primary-color); }
        .bg-primary-50 { background-color: rgba(var(--primary-rgb), 0.05); }
        .bg-primary-100 { background-color: rgba(var(--primary-rgb), 0.1); }
        .border-primary { border-color: var(--primary-color); }
        .ring-primary { --tw-ring-color: var(--primary-color); }
        
        .hover\:bg-primary:hover { background-color: var(--primary-color); }
        .hover\:text-primary:hover { color: var(--primary-color); }
        .group:hover .group-hover\:text-primary { color: var(--primary-color); }
        
        .hero-pattern {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230d9488' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .blob {
            position: absolute;
            filter: blur(40px);
            z-index: -1;
            opacity: 0.5;
            animation: move 10s infinite alternate;
        }
        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(20px, -20px) scale(1.1); }
        }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-600 selection:bg-primary selection:text-white overflow-x-hidden" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navbar -->
    <nav :class="{ 'py-2 shadow-md bg-white/95': scrolled, 'py-4 bg-transparent': !scrolled }" class="fixed w-full z-50 transition-all duration-300 top-0 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30 transform group-hover:rotate-6 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-black text-xl text-slate-800 tracking-tight leading-none group-hover:text-primary transition-colors">{{ $pengaturan['nama_aplikasi'] ?? 'SATRIA' }}</h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sistem Kesehatan</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="#beranda" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-primary hover:bg-primary-50 rounded-full transition-all">Beranda</a>
                    <a href="#layanan" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-primary hover:bg-primary-50 rounded-full transition-all">Layanan</a>
                    <a href="#jadwal" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-primary hover:bg-primary-50 rounded-full transition-all">Jadwal Dokter</a>
                    <a href="#fasilitas" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-primary hover:bg-primary-50 rounded-full transition-all">Fasilitas</a>
                    <a href="#berita" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-primary hover:bg-primary-50 rounded-full transition-all">Info Terkini</a>
                </div>

                <!-- CTA Button & Mobile Toggle -->
                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-slate-800 text-white text-sm font-bold rounded-xl hover:bg-slate-900 transition-all shadow-lg shadow-slate-900/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                                    Dashboard
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="hidden sm:inline-flex px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:border-primary hover:text-primary transition-all items-center gap-2">
                                    Masuk Staf
                                </a>
                                <a href="{{ route('antrean.monitor') }}" class="px-5 py-2.5 bg-gradient-to-r from-primary to-emerald-600 text-white text-sm font-bold rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/30 flex items-center gap-2 transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                    Antrean
                                </a>
                            @endauth
                        @endif
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <svg x-cloak x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu Dropdown -->
            <div x-cloak x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden mt-2 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden absolute w-full left-0 z-50">
                <div class="px-4 py-6 space-y-4">
                    <a href="#beranda" @click="mobileMenuOpen = false" class="block text-base font-bold text-slate-600 hover:text-primary">Beranda</a>
                    <a href="#layanan" @click="mobileMenuOpen = false" class="block text-base font-bold text-slate-600 hover:text-primary">Layanan</a>
                    <a href="#jadwal" @click="mobileMenuOpen = false" class="block text-base font-bold text-slate-600 hover:text-primary">Jadwal Dokter</a>
                    <a href="#fasilitas" @click="mobileMenuOpen = false" class="block text-base font-bold text-slate-600 hover:text-primary">Fasilitas</a>
                    <div class="pt-4 border-t border-slate-100 grid gap-3">
                         @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="w-full text-center px-5 py-3 bg-slate-800 text-white font-bold rounded-xl">Dashboard</a>
                            @else
                                <a href="{{ route('antrean.monitor') }}" class="w-full text-center px-5 py-3 bg-primary text-white font-bold rounded-xl">Ambil Antrean</a>
                                <a href="{{ route('login') }}" class="w-full text-center px-5 py-3 bg-slate-50 text-slate-700 font-bold rounded-xl border border-slate-200">Masuk Staf</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                
                <!-- Text Content -->
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    @if(isset($pengaturan['announcement_active']) && $pengaturan['announcement_active'] == '1')
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-50 border border-red-100 text-red-600 text-xs font-bold uppercase tracking-wider mb-8 shadow-sm">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                            {{ $pengaturan['announcement_text'] ?? 'Pengumuman' }}
                        </div>
                    @endif

                    <h1 class="text-4xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.1] mb-6">
                        {{ $pengaturan['judul_hero'] ?? 'Judul Hero' }} <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-emerald-600" style="background-image: linear-gradient(to right, var(--primary-color), #059669);">
                            {{ $pengaturan['subjudul_hero'] ?? 'Subjudul' }}
                        </span>
                    </h1>
                    
                    <p class="text-lg text-slate-500 mb-10 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        {{ $pengaturan['deskripsi'] ?? 'Deskripsi aplikasi...' }}
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('antrean.monitor') }}" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl shadow-slate-900/20 hover:bg-slate-800 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Ambil Nomor Antrean
                        </a>
                        @if(!isset($pengaturan['show_pengaduan_cta']) || $pengaturan['show_pengaduan_cta'] == '1')
                            <a href="{{ route('pengaduan.public') }}" class="px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold hover:border-primary hover:text-primary hover:shadow-lg transition-all flex items-center justify-center gap-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                Layanan Pengaduan
                            </a>
                        @endif
                    </div>

                    <!-- Trust Indicators -->
                    <div class="mt-12 pt-8 border-t border-slate-200 grid grid-cols-3 gap-4 text-center lg:text-left">
                        <div>
                            <p class="text-3xl font-black text-slate-900">24/7</p>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Layanan IGD</p>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-slate-900">{{ $stats['dokter_total'] ?? 0 }}+</p>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dokter Ahli</p>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-slate-900">{{ number_format($stats['layanan_total'] ?? 0, 0, ',', '.') }}+</p>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pasien Terlayani</p>
                        </div>
                    </div>
                </div>

                <!-- Visual -->
                <div class="w-full lg:w-1/2 relative hidden lg:block">
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-primary opacity-10 rounded-full blur-3xl blob"></div>
                    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-emerald-500 opacity-10 rounded-full blur-3xl blob" style="animation-delay: 2s"></div>
                    
                    <div class="relative z-10"> 
                         <!-- Composition of Images/Cards -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-4 mt-8">
                                <div class="bg-white p-4 rounded-3xl shadow-lg border border-slate-100 transform rotate-[-2deg] hover:rotate-0 transition-all duration-500">
                                    <div class="h-40 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300 mb-4 overflow-hidden">
                                        <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <h3 class="font-bold text-slate-800">Rekam Medis Digital</h3>
                                    <p class="text-xs text-slate-500 mt-1">Terintegrasi & Aman</p>
                                </div>
                                <div class="bg-primary p-6 rounded-3xl shadow-xl shadow-primary/20 text-white transform rotate-[1deg] hover:rotate-0 transition-all duration-500">
                                    <h3 class="font-bold text-xl mb-2">Akses Mudah</h3>
                                    <p class="text-sm text-white/80 leading-relaxed">Pendaftaran antrean online dari mana saja dan kapan saja.</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="bg-slate-900 p-6 rounded-3xl shadow-xl text-white transform rotate-[2deg] hover:rotate-0 transition-all duration-500">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-400 uppercase font-bold">Waktu Tunggu</p>
                                            <p class="font-bold text-emerald-400">Lebih Cepat</p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-white/10 rounded-full h-2 mb-2">
                                        <div class="bg-emerald-500 w-3/4 h-2 rounded-full"></div>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-3xl shadow-lg border border-slate-100 transform rotate-[-1deg] hover:rotate-0 transition-all duration-500">
                                    <div class="h-48 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-300 mb-4 overflow-hidden relative">
                                        <svg class="w-20 h-20 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-100/50 to-transparent"></div>
                                    </div>
                                    <h3 class="font-bold text-slate-800">Pelayanan Ramah</h3>
                                    <p class="text-xs text-slate-500 mt-1">Sepenuh Hati</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Section -->
    @if(!isset($pengaturan['show_layanan_poli']) || $pengaturan['show_layanan_poli'] == '1')
    <section id="layanan" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block bg-primary-50 w-max mx-auto px-3 py-1 rounded-full">Poliklinik & Spesialis</span>
                <h2 class="text-3xl lg:text-5xl font-black text-slate-900 mb-4">Layanan Medis Unggulan</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">
                    Didukung tenaga medis profesional dan peralatan modern untuk kesembuhan Anda.
                </p>
            </div>

            @if($layanan->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($layanan as $poli)
                <div class="group bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-primary/10 hover:border-primary/20 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                    
                    <div class="w-14 h-14 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-2xl font-black text-primary mb-6 shadow-sm group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300 relative z-10">
                        {{ substr($poli->nama_poli, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 relative z-10">{{ $poli->nama_poli }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-3 relative z-10">
                        {{ $poli->keterangan ?? 'Layanan pemeriksaan kesehatan komprehensif oleh dokter ahli di bidangnya.' }}
                    </p>
                    <a href="#" class="inline-flex items-center gap-2 text-sm font-bold text-primary group-hover:gap-3 transition-all relative z-10">
                        Info Selengkapnya <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-slate-50 rounded-[2.5rem] border border-dashed border-slate-200">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-slate-300">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <p class="text-slate-500 font-medium">Data layanan poliklinik belum tersedia saat ini.</p>
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Jadwal Dokter -->
    @if(!isset($pengaturan['show_jadwal_dokter']) || $pengaturan['show_jadwal_dokter'] == '1')
    <section id="jadwal" class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-slate-900 via-transparent to-slate-900 z-0"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Jadwal Praktik Hari Ini</span>
                    <h2 class="text-3xl lg:text-4xl font-black text-white">Dokter Siaga</h2>
                </div>
                <div class="flex items-center gap-3 bg-white/5 px-5 py-3 rounded-2xl backdrop-blur-sm border border-white/10">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-sm font-bold">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="bg-gradient-to-b from-white/10 to-white/5 backdrop-blur-md border border-white/10 p-1 rounded-[2rem] hover:border-primary/50 transition-colors group">
                        <div class="bg-slate-900/50 rounded-[1.8rem] p-6 h-full">
                            <div class="flex items-center gap-5 mb-6">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center text-2xl font-black text-white shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                    {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-lg text-white mb-1 truncate group-hover:text-primary transition-colors">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider truncate">{{ $jadwal->pegawai->jabatan ?? 'Dokter Umum' }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-black/40 rounded-xl p-4 flex items-center justify-between border border-white/5">
                                <div>
                                    <p class="text-xs text-slate-400 font-medium mb-1">Jam Praktik</p>
                                    <p class="text-sm font-bold text-white tracking-wide">{{ $jadwal->shift->jam_masuk ?? '08:00' }} - {{ $jadwal->shift->jam_keluar ?? '14:00' }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-green-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white/5 border border-white/10 rounded-[2.5rem] p-16 text-center max-w-lg mx-auto backdrop-blur-sm">
                    <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 text-white/30">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white">Tidak Ada Jadwal</h3>
                    <p class="text-slate-400 leading-relaxed">Belum ada dokter yang dijadwalkan bertugas untuk hari ini. Silakan cek kembali nanti atau hubungi informasi.</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Fasilitas -->
    @if(!isset($pengaturan['show_fasilitas']) || $pengaturan['show_fasilitas'] == '1')
    <section id="fasilitas" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block bg-primary-50 w-max mx-auto px-3 py-1 rounded-full">Sarana & Prasarana</span>
                <h2 class="text-3xl lg:text-4xl font-black text-slate-900">Fasilitas Penunjang</h2>
            </div>

            @if($fasilitas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($fasilitas as $item)
                <div class="bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 group">
                    <div class="h-64 overflow-hidden relative">
                         <div class="absolute inset-0 bg-slate-200 animate-pulse"></div>
                         @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 relative z-10" alt="{{ $item->nama_fasilitas }}">
                         @else
                            <div class="absolute inset-0 bg-slate-200 flex items-center justify-center text-slate-400 z-10 group-hover:bg-slate-300 transition-colors">
                                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                         @endif
                         
                         <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent z-20"></div>
                         <div class="absolute bottom-0 left-0 right-0 p-8 z-30 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                             @if($item->jenis == 'unggulan')
                                <span class="bg-primary text-white text-[10px] font-bold px-2 py-1 rounded mb-3 inline-block shadow-lg">UNGGULAN</span>
                             @endif
                             <h3 class="text-2xl font-bold text-white mb-2">{{ $item->nama_fasilitas }}</h3>
                             <div class="h-1 w-12 bg-primary rounded-full group-hover:w-full transition-all duration-500"></div>
                         </div>
                    </div>
                    <div class="p-8">
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-3">
                            {{ $item->deskripsi }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-white rounded-[2.5rem] border border-dashed border-slate-200">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <p class="text-slate-400 font-medium">Informasi fasilitas belum tersedia.</p>
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- FAQ Section -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
             <div class="text-center mb-16">
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block bg-primary-50 w-max mx-auto px-3 py-1 rounded-full">Informasi Umum</span>
                <h2 class="text-3xl lg:text-4xl font-black text-slate-900">Pertanyaan Sering Diajukan</h2>
            </div>
            
            <div class="space-y-4" x-data="{ active: null }">
                <!-- FAQ Item 1 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden transition-all duration-300" :class="active === 1 ? 'shadow-lg bg-white ring-1 ring-primary/20' : ''">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full px-8 py-5 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-slate-800 text-lg">Bagaimana cara mendaftar antrean online?</span>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center transition-colors" :class="active === 1 ? 'bg-primary text-white' : 'bg-white text-slate-400 border border-slate-200'">
                            <svg class="w-5 h-5 transform transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>
                    <div x-show="active === 1" x-collapse>
                        <div class="px-8 pb-8 text-slate-500 leading-relaxed border-t border-slate-100 pt-4">
                            Anda dapat mengambil nomor antrean melalui menu "Antrean" di halaman ini atau datang langsung ke kiosk mandiri di lokasi kami. Cukup pilih poliklinik tujuan dan dapatkan tiket antrean Anda secara instan.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden transition-all duration-300" :class="active === 2 ? 'shadow-lg bg-white ring-1 ring-primary/20' : ''">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full px-8 py-5 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-slate-800 text-lg">Apakah menerima pasien BPJS?</span>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center transition-colors" :class="active === 2 ? 'bg-primary text-white' : 'bg-white text-slate-400 border border-slate-200'">
                            <svg class="w-5 h-5 transform transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>
                    <div x-show="active === 2" x-collapse>
                        <div class="px-8 pb-8 text-slate-500 leading-relaxed border-t border-slate-100 pt-4">
                            Ya, kami melayani pasien BPJS Kesehatan. Pastikan kartu BPJS Anda aktif dan membawa surat rujukan dari Faskes 1 jika diperlukan untuk pemeriksaan spesialis.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden transition-all duration-300" :class="active === 3 ? 'shadow-lg bg-white ring-1 ring-primary/20' : ''">
                    <button @click="active = (active === 3 ? null : 3)" class="w-full px-8 py-5 flex items-center justify-between text-left focus:outline-none">
                        <span class="font-bold text-slate-800 text-lg">Jam berapa pelayanan dibuka?</span>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center transition-colors" :class="active === 3 ? 'bg-primary text-white' : 'bg-white text-slate-400 border border-slate-200'">
                            <svg class="w-5 h-5 transform transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>
                    <div x-show="active === 3" x-collapse>
                        <div class="px-8 pb-8 text-slate-500 leading-relaxed border-t border-slate-100 pt-4">
                            Pendaftaran dibuka mulai pukul 07:00 WIB. Pelayanan poliklinik dimulai pukul 08:00 WIB hingga selesai. Layanan IGD tersedia 24 jam setiap hari untuk keadaan darurat.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita -->
    <section id="berita" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block bg-primary-50 w-max px-3 py-1 rounded-full">Artikel & Informasi</span>
                    <h2 class="text-3xl lg:text-4xl font-black text-slate-900">Kabar Terbaru</h2>
                </div>
                @if($beritaTerbaru->count() > 0)
                <a href="#" class="hidden sm:inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-primary transition-colors bg-white px-5 py-2.5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md">
                    Lihat Arsip Berita <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                @endif
            </div>

            @if($beritaTerbaru->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($beritaTerbaru as $berita)
                <div class="group cursor-pointer bg-white rounded-[2rem] p-4 shadow-sm hover:shadow-2xl transition-all duration-300 border border-slate-100">
                    <div class="bg-slate-100 rounded-[1.5rem] overflow-hidden aspect-[16/10] mb-6 relative">
                        @if($berita->thumbnail)
                            <img src="{{ asset('storage/' . $berita->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $berita->judul }}">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-slate-300 bg-slate-50">
                                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-white/95 backdrop-blur text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm text-slate-600">
                            {{ $berita->created_at->format('d M Y') }}
                        </div>
                    </div>
                    <div class="px-2 pb-2">
                        <div class="flex items-center gap-2 text-[10px] font-bold text-primary mb-3 uppercase tracking-wide">
                            <span class="bg-primary-50 px-2 py-1 rounded-md">{{ $berita->kategori }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-primary transition-colors line-clamp-2 leading-tight">
                            {{ $berita->judul }}
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-4">
                            {{ Str::limit(strip_tags($berita->konten), 100) }}
                        </p>
                        <span class="text-xs font-bold text-slate-400 group-hover:text-primary transition-colors flex items-center gap-1">
                            Baca Selengkapnya <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-slate-200">
                <p class="text-slate-400">Belum ada berita yang dipublikasikan.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-24 pb-12 border-t border-slate-800 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
                <div class="lg:col-span-2">
                    <a href="#" class="inline-flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-emerald-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg shadow-primary/20" style="background-image: linear-gradient(135deg, var(--primary-color), #2563eb);">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight">{{ $pengaturan['nama_aplikasi'] ?? 'SATRIA' }}</span>
                    </a>
                    <p class="text-slate-400 leading-relaxed max-w-sm mb-8">
                        {{ $pengaturan['deskripsi'] ?? 'Sistem Informasi Kesehatan' }}
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Navigasi</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#beranda" class="hover:text-primary transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 bg-slate-600 rounded-full"></span> Beranda</a></li>
                        <li><a href="#layanan" class="hover:text-primary transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 bg-slate-600 rounded-full"></span> Layanan Medis</a></li>
                        <li><a href="#jadwal" class="hover:text-primary transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 bg-slate-600 rounded-full"></span> Jadwal Dokter</a></li>
                        <li><a href="#fasilitas" class="hover:text-primary transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 bg-slate-600 rounded-full"></span> Fasilitas</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Kontak Kami</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="mt-1.5">{{ $pengaturan['alamat'] ?? '-' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <span>{{ $pengaturan['telepon'] ?? '-' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span>{{ $pengaturan['email'] ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs font-bold text-slate-600 uppercase tracking-widest text-center md:text-left">
                    &copy; {{ date('Y') }} {{ $pengaturan['footer_text'] ?? 'Sistem Kesehatan' }}. Hak Cipta Dilindungi Undang-undang.
                </p>
                <div class="flex items-center gap-6 text-xs font-bold text-slate-500 uppercase tracking-widest">
                    <a href="#" class="hover:text-white transition-colors">Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>