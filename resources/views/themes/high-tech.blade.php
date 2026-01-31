<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $pengaturan['app_description'] ?? 'Sistem Administrasi Kesehatan Terintegrasi Indonesia' }}">
    <meta name="theme-color" content="{{ $pengaturan['primary_color'] ?? '#0f172a' }}">
    <title>{{ $pengaturan['app_name'] ?? 'SATRIA' }} - {{ $pengaturan['app_tagline'] ?? 'Kesehatan Masa Depan' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-display: 'Outfit', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --color-primary: {{ $pengaturan['primary_color'] ?? '#3b82f6' }};
        }
        
        body { font-family: var(--font-body); background-color: #0f172a; color: #e2e8f0; overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-display); }
        
        /* High-Tech Background */
        .tech-bg {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(56, 189, 248, 0.15) 0px, transparent 50%), 
                radial-gradient(at 100% 0%, rgba(139, 92, 246, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
            background-attachment: fixed;
        }

        /* Glassmorphism */
        .glass-panel {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }
        
        .glass-card {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.6), rgba(15, 23, 42, 0.8));
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            border-color: rgba(56, 189, 248, 0.3);
            box-shadow: 0 20px 40px -5px rgba(56, 189, 248, 0.15);
        }

        /* Animations */
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0px); } }
        
        .animate-pulse-glow { animation: pulseGlow 3s infinite; }
        @keyframes pulseGlow { 0% { box-shadow: 0 0 0 0 rgba(56, 189, 248, 0.4); } 70% { box-shadow: 0 0 0 15px rgba(56, 189, 248, 0); } 100% { box-shadow: 0 0 0 0 rgba(56, 189, 248, 0); } }

        /* Grid Background Pattern */
        .grid-pattern {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="tech-bg selection:bg-cyan-500 selection:text-white" x-data="{ scrolled: false, mobileMenu: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navbar -->
    <nav :class="{ 'bg-slate-900/90 backdrop-blur-md border-b border-white/5 py-4': scrolled, 'bg-transparent py-6': !scrolled }" class="fixed w-full z-50 transition-all duration-300 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="relative w-10 h-10 flex items-center justify-center">
                        <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-xl transform rotate-6 group-hover:rotate-12 transition-transform opacity-80 blur-sm"></div>
                        <div class="relative w-full h-full bg-slate-900 border border-white/10 rounded-xl flex items-center justify-center text-cyan-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                    </div>
                    <div>
                        <h1 class="font-black text-xl text-white tracking-tight leading-none font-display">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</h1>
                        <p class="text-[9px] font-bold text-cyan-400 uppercase tracking-[0.2em] opacity-80">Layanan Kesehatan Terpadu</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-1">
                    @foreach(['Beranda', 'Layanan', 'Jadwal', 'Fasilitas', 'Berita'] as $item)
                        <a href="#{{ strtolower($item) }}" class="px-4 py-2 text-xs font-bold text-slate-300 hover:text-white hover:bg-white/5 rounded-lg transition-all uppercase tracking-wider">{{ $item }}</a>
                    @endforeach
                </div>

                <!-- CTA -->
                <div class="hidden md:flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-white/10 border border-white/10 text-white text-xs font-bold rounded-xl hover:bg-white/20 hover:border-white/20 transition-all flex items-center gap-2 backdrop-blur-sm">
                                Dashboard Utama
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </a>
                        @else
                            <a href="{{ route('antrean.monitor') }}" class="px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-xs font-bold rounded-xl hover:shadow-[0_0_20px_rgba(6,182,212,0.5)] transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Ambil Antrean
                            </a>
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-slate-300 hover:text-white text-xs font-bold transition-colors">
                                Masuk Staf
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0 grid-pattern opacity-20"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-cyan-500/20 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-violet-500/20 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            @if(($pengaturan['announcement_active'] ?? '0') == '1')
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-cyan-900/30 border border-cyan-500/30 text-cyan-400 text-[10px] font-bold uppercase tracking-widest mb-8 backdrop-blur-sm animate-fade-in">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse-glow"></span>
                    {{ $pengaturan['announcement_text'] ?? 'Sistem Operasional Normal' }}
                </div>
            @endif

            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight leading-tight mb-6 font-display animate-fade-in">
                {{ $pengaturan['hero_title'] ?? 'Masa Depan' }} <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-500 to-violet-500">
                    {{ $pengaturan['hero_subtitle'] ?? 'Layanan Kesehatan' }}
                </span>
            </h1>
            
            <p class="text-lg text-slate-400 mb-10 max-w-2xl mx-auto leading-relaxed animate-fade-in" style="animation-delay: 0.1s">
                {{ $pengaturan['app_description'] ?? 'Platform kesehatan terintegrasi berbasis teknologi tinggi untuk pelayanan yang presisi, cepat, dan aman.' }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in" style="animation-delay: 0.2s">
                <a href="{{ route('antrean.monitor') }}" class="px-8 py-4 bg-white text-slate-900 rounded-2xl font-bold hover:bg-cyan-50 transition-all transform hover:-translate-y-1 hover:shadow-[0_0_30px_rgba(255,255,255,0.3)] flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    Daftar Rawat Jalan
                </a>
                @if(($pengaturan['show_pengaduan_cta'] ?? '1') == '1')
                    <a href="{{ route('pengaduan.public') }}" class="px-8 py-4 glass-panel text-white border border-white/10 rounded-2xl font-bold hover:bg-white/10 transition-all flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                        Layanan Pengaduan
                    </a>
                @endif
            </div>

            <!-- Stats Grid -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-4 animate-fade-in" style="animation-delay: 0.4s">
                <div class="glass-card p-6 rounded-2xl text-center">
                    <p class="text-3xl font-black text-white mb-1">{{ $stats['dokter_total'] ?? '24' }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Dokter Spesialis</p>
                </div>
                <div class="glass-card p-6 rounded-2xl text-center">
                    <p class="text-3xl font-black text-cyan-400 mb-1">{{ $stats['layanan_total'] ?? '15k' }}+</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pasien Terlayani</p>
                </div>
                <div class="glass-card p-6 rounded-2xl text-center">
                    <p class="text-3xl font-black text-violet-400 mb-1">24/7</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Layanan IGD</p>
                </div>
                <div class="glass-card p-6 rounded-2xl text-center">
                    <p class="text-3xl font-black text-emerald-400 mb-1">100%</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rekam Digital</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan / Services (Klaster ILP) -->
    @if(($pengaturan['show_layanan_poli'] ?? '1') == '1')
    <section id="layanan" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-cyan-400 font-bold tracking-[0.2em] uppercase text-xs mb-2 block">Integrasi Layanan Primer</span>
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Layanan Berbasis Klaster</h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Pendekatan baru pelayanan kesehatan yang berfokus pada siklus hidup manusia untuk penanganan yang lebih komprehensif.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Klaster 1 -->
                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                    <div class="w-12 h-12 bg-cyan-500/20 rounded-xl flex items-center justify-center text-cyan-400 mb-6 group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Klaster Ibu & Anak</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Pelayanan terpadu untuk kesehatan ibu hamil, bersalin, nifas, bayi, balita, hingga anak prasekolah.</p>
                    <ul class="space-y-2 text-sm text-slate-300">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Poli KIA / KB</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> MTBS</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span> Imunisasi</li>
                    </ul>
                </div>

                <!-- Klaster 2 -->
                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 mb-6 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Klaster Usia Dewasa</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Skrining dan penanganan kesehatan untuk usia sekolah, remaja, dewasa, hingga lanjut usia (lansia).</p>
                    <ul class="space-y-2 text-sm text-slate-300">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> Poli Umum</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> Poli Lansia</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> Poli Gigi</li>
                    </ul>
                </div>

                <!-- Klaster 3 -->
                <div class="glass-card p-8 rounded-3xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                    <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center text-orange-400 mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Penanggulangan Penyakit</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Pencegahan, kewaspadaan dini, dan pengendalian penyakit menular serta tidak menular.</p>
                    <ul class="space-y-2 text-sm text-slate-300">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> Surveilans</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> Laboratorium</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> Pojok Infeksi</li>
                    </ul>
                </div>
            </div>

            <!-- Daftar Poli Dynamic -->
            @if(isset($layanan) && count($layanan) > 0)
            <div class="mt-16">
                <h3 class="text-2xl font-bold text-white text-center mb-8">Poliklinik Tersedia</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach($layanan as $poli)
                        <div class="px-6 py-3 glass-panel rounded-xl border border-white/5 text-slate-300 hover:text-white hover:border-cyan-500/50 transition-all cursor-default">
                            {{ $poli->nama_poli }}
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Jadwal Dokter (Live Dashboard Style) -->
    @if(($pengaturan['show_jadwal_dokter'] ?? '1') == '1')
    <section id="jadwal" class="py-24 relative overflow-hidden bg-slate-900/50 border-y border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <span class="text-violet-400 font-bold tracking-[0.2em] uppercase text-xs mb-2 block">Jadwal Langsung</span>
                    <h2 class="text-3xl md:text-4xl font-black text-white">Dokter Siaga Hari Ini</h2>
                </div>
                <div class="flex items-center gap-3 bg-white/5 px-5 py-3 rounded-xl backdrop-blur-sm border border-white/10">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-sm font-bold text-white">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="glass-card p-6 rounded-2xl group cursor-default">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-xl font-black text-white shadow-lg">
                                {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-white truncate">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                                <p class="text-xs font-bold text-violet-400 uppercase tracking-wider truncate">{{ $jadwal->pegawai->poli->nama_poli ?? 'Umum' }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-white/5">
                            <span class="text-xs text-slate-400">Jam Praktik</span>
                            <span class="text-sm font-bold text-white bg-white/5 px-3 py-1 rounded-lg">{{ $jadwal->shift->jam_masuk ?? '08:00' }} - {{ $jadwal->shift->jam_keluar ?? '14:00' }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="glass-panel p-12 text-center rounded-3xl">
                    <p class="text-slate-400">Jadwal dokter belum tersedia untuk hari ini.</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Fasilitas Unggulan -->
    @if(($pengaturan['show_fasilitas'] ?? '1') == '1')
    <section id="fasilitas" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-400 font-bold tracking-[0.2em] uppercase text-xs mb-2 block">Sarana & Prasarana</span>
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Fasilitas Unggulan</h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Dilengkapi dengan peralatan medis modern berstandar internasional untuk menunjang akurasi diagnosa dan kenyamanan pasien.</p>
            </div>

            @if(isset($fasilitas) && count($fasilitas) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($fasilitas as $f)
                    <div class="glass-card rounded-3xl overflow-hidden group">
                        <div class="h-64 relative overflow-hidden">
                            @if($f->gambar)
                                <img src="{{ Storage::url($f->gambar) }}" alt="{{ $f->nama_fasilitas }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-slate-800 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-80"></div>
                            <div class="absolute bottom-6 left-6 right-6">
                                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">{{ $f->nama_fasilitas }}</h3>
                                <p class="text-sm text-slate-300 line-clamp-2 leading-relaxed">{{ $f->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="glass-panel p-12 text-center rounded-3xl">
                    <p class="text-slate-400">Data fasilitas belum ditambahkan.</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Berita / Informasi -->
    <section id="berita" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-emerald-400 font-bold tracking-[0.2em] uppercase text-xs mb-2 block">Informasi Terkini</span>
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Berita & Artikel</h2>
            </div>
            
             @if(isset($beritaTerbaru) && count($beritaTerbaru) > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($beritaTerbaru as $berita)
                    <div class="glass-card rounded-2xl overflow-hidden flex flex-col h-full group">
                        <div class="h-48 bg-slate-800 relative overflow-hidden">
                             @if($berita->thumbnail)
                                <img src="{{ Storage::url($berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-800 text-slate-600">
                                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-slate-900/80 backdrop-blur text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">{{ $berita->kategori ?? 'Umum' }}</span>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="text-xs text-slate-400 mb-3 flex items-center gap-2">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                {{ $berita->created_at->translatedFormat('d F Y') }}
                            </div>
                            <h3 class="text-lg font-bold text-white mb-3 leading-tight group-hover:text-cyan-400 transition-colors">{{ $berita->judul }}</h3>
                            <p class="text-sm text-slate-400 line-clamp-3 mb-4 flex-1">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                            <a href="#" class="inline-flex items-center gap-2 text-sm font-bold text-cyan-400 hover:text-cyan-300 transition-colors">
                                Baca Selengkapnya <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="glass-panel p-12 text-center rounded-3xl">
                    <p class="text-slate-400">Belum ada berita terbaru.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 pt-24 pb-12 border-t border-white/5 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div class="lg:col-span-2">
                    <a href="#" class="flex items-center gap-3 mb-6">
                         <div class="w-10 h-10 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight font-display">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</span>
                    </a>
                    <p class="text-slate-400 leading-relaxed max-w-sm mb-8">
                        {{ $pengaturan['app_address'] ?? 'Alamat instansi kesehatan...' }}
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:bg-cyan-500 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:bg-cyan-500 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    </div>
                </div>
                
                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6 font-display">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm font-medium text-slate-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-cyan-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $pengaturan['app_phone'] ?? '(021) 1234-5678' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-cyan-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $pengaturan['app_email'] ?? 'info@satria.health' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest text-center md:text-left">
                    &copy; {{ date('Y') }} {{ $pengaturan['footer_text'] ?? 'SATRIA Health System' }}. Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center gap-6 text-xs font-bold text-slate-500 uppercase tracking-widest">
                    <a href="#" class="hover:text-white transition-colors">Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>