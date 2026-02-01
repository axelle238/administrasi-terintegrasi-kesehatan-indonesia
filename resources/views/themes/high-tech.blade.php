<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"> <!-- Prevent zoom for app-feel -->
    <meta name="description" content="{{ $pengaturan['app_description'] ?? 'Sistem Administrasi Kesehatan Terintegrasi' }}">
    <meta name="theme-color" content="#10b981"> <!-- Emerald-500 -->
    <title>{{ $pengaturan['app_name'] ?? 'SATRIA' }} - {{ $pengaturan['app_tagline'] ?? 'Health System' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-heading: 'Outfit', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --color-primary: {{ $pengaturan['primary_color'] ?? '#10b981' }};
        }
        
        body { 
            font-family: var(--font-body); 
            background-color: #f8fafc; /* Slate 50 */
            color: #334155; 
            overflow-x: hidden; 
            padding-bottom: 80px; /* Space for bottom nav on mobile */
        }
        
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-heading); }

        /* Hide Scrollbar but keep functionality */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Glassmorphism Light */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.6); /* Slate-200 */
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }

        /* Animations */
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* Custom Shapes (Green Tint) */
        .blob-bg {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23ECFDF5' d='M44.7,-76.4C58.9,-69.2,71.8,-59.1,79.6,-46.3C87.4,-33.5,90.1,-18,88.6,-3.3C87.1,11.4,81.5,25.3,73.1,37.8C64.7,50.3,53.5,61.4,40.7,69.6C27.9,77.8,13.5,83.1,-0.4,83.8C-14.3,84.5,-28.3,80.6,-40.3,72.3C-52.3,64,-62.3,51.3,-69.8,37.5C-77.3,23.7,-82.3,8.8,-80.7,-5.4C-79.1,-19.6,-70.9,-33.1,-60.7,-44.6C-50.5,-56.1,-38.3,-65.6,-25.3,-73.4C-12.3,-81.2,-1.5,-87.3,11.7,-85.3C24.9,-83.3,30.5,-68.6,44.7,-76.4Z' transform='translate(100 100)' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right top;
            background-size: contain;
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased selection:bg-emerald-500 selection:text-white" x-data="{ scrolled: false }">

    <!-- Navbar Desktop (Sticky Glass) -->
    <nav :class="{ 'py-3 shadow-sm': scrolled, 'py-5': !scrolled }" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 glass hidden md:block" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    </div>
                    <div>
                        <h1 class="font-black text-xl text-slate-800 tracking-tight leading-none">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</h1>
                        <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Healthcare</p>
                    </div>
                </a>

                <!-- Menu -->
                <div class="flex items-center gap-8">
                    @foreach(['Beranda', 'Layanan', 'Jadwal', 'Fasilitas', 'Berita'] as $item)
                        <a href="#{{ strtolower($item) }}" class="text-sm font-bold text-slate-500 hover:text-emerald-600 transition-colors">{{ $item }}</a>
                    @endforeach
                </div>

                <!-- CTA -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider hover:bg-slate-800 transition-all shadow-lg">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800">Masuk Staff</a>
                        <a href="{{ route('antrean.monitor') }}" class="px-6 py-2.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-xs font-bold uppercase tracking-wider hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all shadow-lg">
                            Ambil Antrean
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Top Bar -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100 px-4 py-3 flex justify-between items-center md:hidden">
        <a href="#" class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            </div>
            <span class="font-black text-lg text-slate-800">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</span>
        </a>
        @auth
            <a href="{{ url('/dashboard') }}" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </a>
        @else
            <a href="{{ route('login') }}" class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-full">Login</a>
        @endauth
    </div>

    <!-- MAIN HERO SECTION -->
    <header id="beranda" class="relative pt-24 pb-16 md:pt-32 md:pb-24 overflow-hidden blob-bg">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Text Content -->
                <div class="flex-1 text-center lg:text-left space-y-6">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-emerald-100 shadow-sm animate-fade-in-up">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                        </span>
                        <span class="text-xs font-bold text-slate-600 uppercase tracking-wide">{{ $pengaturan['app_tagline'] ?? 'Layanan Kesehatan Modern' }}</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight tracking-tight animate-fade-in-up" style="animation-delay: 0.1s">
                        Sehat Lebih Mudah <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-600">Bersama Kami</span>
                    </h1>
                    
                    <p class="text-slate-500 text-lg leading-relaxed max-w-xl mx-auto lg:mx-0 animate-fade-in-up" style="animation-delay: 0.2s">
                        Akses layanan kesehatan terpadu mulai dari pendaftaran antrean, konsultasi dokter, hingga riwayat medis dalam satu genggaman.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start animate-fade-in-up" style="animation-delay: 0.3s">
                        <a href="{{ route('antrean.monitor') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-slate-900 text-white font-bold text-sm uppercase tracking-wider shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                            <div class="p-1 bg-white/20 rounded-full"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg></div>
                            Daftar Berobat
                        </a>
                        <a href="#jadwal" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white border border-slate-200 text-slate-700 font-bold text-sm uppercase tracking-wider hover:bg-slate-50 hover:border-slate-300 transition-all flex items-center justify-center gap-2">
                            <span>Cek Jadwal Dokter</span>
                        </a>
                    </div>

                    <!-- Trust Markers -->
                    <div class="pt-8 flex items-center justify-center lg:justify-start gap-6 opacity-70 grayscale hover:grayscale-0 transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.4s">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                            <span class="text-xs font-bold">Terverifikasi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg></div>
                            <span class="text-xs font-bold">Data Aman</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center text-rose-600"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg></div>
                            <span class="text-xs font-bold">Pelayanan Ramah</span>
                        </div>
                    </div>
                </div>

                <!-- Illustration/Image -->
                <div class="flex-1 w-full relative animate-float hidden lg:block">
                    <div class="relative z-10 bg-white p-4 rounded-[2.5rem] shadow-2xl border border-slate-100 max-w-md mx-auto rotate-2 hover:rotate-0 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1638202993928-7267aad84c31?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Doctor" class="w-full h-auto rounded-[2rem] object-cover aspect-[4/5]">
                        
                        <!-- Floating Card -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl border border-slate-50 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Waktu Tunggu</p>
                                <p class="text-lg font-black text-slate-800">~15 Menit</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative Circles -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-200/20 rounded-full blur-3xl -z-10"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- QUICK MENU (COLORFUL GRID) -->
    <section class="py-8 px-6 lg:px-8 -mt-8 relative z-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                <!-- Card 1 -->
                <a href="#layanan" class="group bg-white p-6 rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-500 flex items-center justify-center text-2xl mb-4 group-hover:bg-teal-500 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg">Poliklinik</h3>
                    <p class="text-xs text-slate-400 mt-1">Layanan Spesialis</p>
                </a>
                
                <!-- Card 2 -->
                <a href="{{ route('antrean.monitor') }}" class="group bg-white p-6 rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg">Daftar Online</h3>
                    <p class="text-xs text-slate-400 mt-1">Tanpa Antre Lama</p>
                </a>

                <!-- Card 3 -->
                <a href="#jadwal" class="group bg-white p-6 rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-lime-50 text-lime-600 flex items-center justify-center text-2xl mb-4 group-hover:bg-lime-500 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg">Jadwal Dokter</h3>
                    <p class="text-xs text-slate-400 mt-1">Cek Ketersediaan</p>
                </a>

                <!-- Card 4 -->
                <a href="#" class="group bg-white p-6 rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl mb-4 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg">Farmasi</h3>
                    <p class="text-xs text-slate-400 mt-1">Info Obat</p>
                </a>
            </div>
        </div>
    </section>

    <!-- JADWAL DOKTER -->
    @if(($pengaturan['show_jadwal_dokter'] ?? '1') == '1')
    <section id="jadwal" class="py-16 md:py-24 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-emerald-600 font-bold tracking-widest uppercase text-xs mb-2 block">Dokter Kami</span>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900">Jadwal Praktik Hari Ini</h2>
            </div>

            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4 hover:shadow-lg transition-all duration-300">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 overflow-hidden shrink-0">
                            @if($jadwal->pegawai->foto_profil ?? false)
                                <img src="{{ Storage::url($jadwal->pegawai->foto_profil) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-xl">
                                    {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-slate-800 truncate">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                            <p class="text-xs text-slate-500 uppercase tracking-wide font-bold mb-2">{{ $jadwal->pegawai->poli->nama_poli ?? 'Umum' }}</p>
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase">
                                {{ $jadwal->shift->jam_masuk ?? '00:00' }} - {{ $jadwal->shift->jam_keluar ?? '00:00' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-12 text-center rounded-[2.5rem] border border-dashed border-slate-200">
                    <p class="text-slate-400 font-bold">Tidak ada jadwal dokter untuk hari ini.</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- STATS BANNER -->
    <section class="py-16 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-4xl font-black text-white mb-1">{{ $stats['dokter_total'] ?? 0 }}</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Dokter Ahli</p>
                </div>
                <div>
                    <p class="text-4xl font-black text-white mb-1">{{ $layanan->count() }}</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Poliklinik</p>
                </div>
                <div>
                    <p class="text-4xl font-black text-white mb-1">{{ $stats['pasien_total'] ?? 0 }}</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pasien Terdaftar</p>
                </div>
                <div>
                    <p class="text-4xl font-black text-white mb-1">24<span class="text-emerald-500">/</span>7</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Layanan UGD</p>
                </div>
            </div>
        </div>
    </section>

    <!-- BERITA SLIDER (Simple Grid) -->
    <section id="berita" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <h2 class="text-2xl md:text-3xl font-black text-slate-900">Info Sehat</h2>
                <a href="#" class="text-sm font-bold text-emerald-600 hover:underline">Lihat Semua</a>
            </div>

            @if(isset($beritaTerbaru) && count($beritaTerbaru) > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($beritaTerbaru as $berita)
                    <article class="group cursor-pointer">
                        <div class="rounded-3xl overflow-hidden mb-4 relative h-48 bg-slate-100">
                            @if($berita->thumbnail)
                                <img src="{{ Storage::url($berita->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @endif
                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider text-slate-800">
                                {{ $berita->kategori ?? 'Umum' }}
                            </div>
                        </div>
                        <h3 class="font-bold text-lg text-slate-800 leading-tight mb-2 group-hover:text-emerald-600 transition-colors line-clamp-2">
                            {{ $berita->judul }}
                        </h3>
                        <p class="text-slate-500 text-sm line-clamp-2">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                    </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 border border-dashed border-slate-200 rounded-3xl">
                    <p class="text-slate-400">Belum ada berita terbaru.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-50 pt-16 pb-32 md:pb-16 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div class="space-y-4">
                    <h4 class="font-black text-lg text-slate-800">{{ $pengaturan['app_name'] ?? 'SATRIA' }}</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $pengaturan['app_address'] ?? 'Alamat instansi kesehatan.' }}</p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 mb-4">Layanan</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-emerald-600">Poliklinik</a></li>
                        <li><a href="#" class="hover:text-emerald-600">Unit Gawat Darurat</a></li>
                        <li><a href="#" class="hover:text-emerald-600">Rawat Inap</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-slate-500">
                        <li>{{ $pengaturan['app_phone'] ?? '-' }}</li>
                        <li>{{ $pengaturan['app_email'] ?? '-' }}</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-200 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">
                &copy; {{ date('Y') }} {{ $pengaturan['footer_text'] ?? 'Sistem Kesehatan Terintegrasi' }}
            </div>
        </div>
    </footer>

    <!-- MOBILE BOTTOM NAVIGATION (APP STYLE) -->
    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200 pb-safe md:hidden shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
        <div class="grid grid-cols-4 h-16">
            <a href="#beranda" class="flex flex-col items-center justify-center gap-1 text-slate-400 hover:text-emerald-600 active:text-emerald-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            <a href="{{ route('antrean.monitor') }}" class="flex flex-col items-center justify-center gap-1 text-slate-400 hover:text-emerald-600 active:text-emerald-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                <span class="text-[10px] font-bold">Daftar</span>
            </a>
            <a href="#jadwal" class="flex flex-col items-center justify-center gap-1 text-slate-400 hover:text-emerald-600 active:text-emerald-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <span class="text-[10px] font-bold">Jadwal</span>
            </a>
            <a href="{{ url('/dashboard') }}" class="flex flex-col items-center justify-center gap-1 text-slate-400 hover:text-emerald-600 active:text-emerald-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                <span class="text-[10px] font-bold">Akun</span>
            </a>
        </div>
    </div>

</body>
</html>
