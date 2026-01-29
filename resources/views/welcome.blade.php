<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $pengaturan['deskripsi'] }}">
    <title>{{ $pengaturan['nama_aplikasi'] }} - {{ $pengaturan['tagline'] }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: {{ $pengaturan['primary_color'] ?? '#0ea5e9' }}; /* Sky 500 default */
            --secondary-color: #0f172a; /* Slate 900 */
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        
        .glass-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .text-primary { color: var(--primary-color); }
        .bg-primary { background-color: var(--primary-color); }
        
        .service-card {
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800">

    <!-- Top Bar (Informasi Darurat & Jam) -->
    <div class="bg-slate-900 text-white text-xs py-2.5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5 font-medium">
                    <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Gawat Darurat: <span class="font-bold text-sky-400">{{ $pengaturan['telepon'] }}</span>
                </span>
                <span class="hidden sm:inline text-slate-600">|</span>
                <span class="flex items-center gap-1.5 font-medium">
                    <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $pengaturan['email'] }}
                </span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-slate-400">Jam Operasional: Senin - Sabtu, 08:00 - 14:00</span>
                @if(($pengaturan['announcement_active'] ?? '0') == '1')
                    <span class="bg-red-600 text-white px-2 py-0.5 rounded text-[10px] font-bold animate-pulse">PENTING</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Header / Navigation -->
    <header class="fixed w-full z-50 glass-header top-[40px] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:shadow-sky-500/30 transition-all">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-black text-slate-800 leading-none">{{ $pengaturan['nama_aplikasi'] }}</span>
                        <span class="text-[10px] font-bold text-sky-600 uppercase tracking-widest mt-1">Sistem Kesehatan Terpadu</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden lg:flex items-center gap-8">
                    <a href="#beranda" class="text-sm font-bold text-slate-600 hover:text-sky-600 transition-colors">Beranda</a>
                    <a href="#layanan" class="text-sm font-bold text-slate-600 hover:text-sky-600 transition-colors">Layanan</a>
                    <a href="#jadwal" class="text-sm font-bold text-slate-600 hover:text-sky-600 transition-colors">Jadwal Dokter</a>
                    <a href="#fasilitas" class="text-sm font-bold text-slate-600 hover:text-sky-600 transition-colors">Fasilitas</a>
                    <a href="#berita" class="text-sm font-bold text-slate-600 hover:text-sky-600 transition-colors">Informasi</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="hidden lg:flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-900/10 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:border-sky-500 hover:text-sky-600 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                Masuk Staf
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Wrapper to offset fixed header -->
    <main class="pt-[120px]">
        
        <!-- Hero Section -->
        <section id="beranda" class="relative pb-20 hero-pattern overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-10 lg:pt-20">
                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="w-full lg:w-1/2 text-center lg:text-left">
                        @if(($pengaturan['announcement_active'] ?? '0') == '1')
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 border border-orange-100 text-orange-600 text-[11px] font-bold uppercase tracking-wider mb-8 animate-fade-in-up">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                            </span>
                            {{ $pengaturan['announcement_text'] }}
                        </div>
                        @endif

                        <h1 class="text-5xl lg:text-7xl font-black text-slate-900 tracking-tight leading-[1.1] mb-6">
                            {{ $pengaturan['judul_hero'] }} <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-blue-600">{{ $pengaturan['subjudul_hero'] }}</span>
                        </h1>
                        
                        <p class="text-lg text-slate-500 mb-10 max-w-xl mx-auto lg:mx-0 leading-relaxed font-medium">
                            {{ $pengaturan['deskripsi'] }}
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('antrean.monitor') }}" class="px-8 py-4 bg-sky-500 text-white text-sm font-bold rounded-2xl shadow-xl shadow-sky-500/20 hover:bg-sky-600 hover:shadow-sky-600/30 transition-all flex items-center justify-center gap-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                Ambil Antrean
                            </a>
                            @if(($pengaturan['show_pengaduan_cta'] ?? '1') == '1')
                            <a href="{{ route('pengaduan.public') }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-2xl hover:border-sky-500 hover:text-sky-600 transition-all flex items-center justify-center gap-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                                Layanan Pengaduan
                            </a>
                            @endif
                        </div>

                        <!-- Mini Stats -->
                        <div class="mt-12 flex items-center justify-center lg:justify-start gap-8 pt-8 border-t border-slate-200">
                            <div>
                                <p class="text-3xl font-black text-slate-900">24/7</p>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">IGD Siaga</p>
                            </div>
                            <div class="w-px h-10 bg-slate-200"></div>
                            <div>
                                <p class="text-3xl font-black text-slate-900">15+</p>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Dokter Ahli</p>
                            </div>
                            <div class="w-px h-10 bg-slate-200"></div>
                            <div>
                                <p class="text-3xl font-black text-slate-900">100%</p>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Terintegrasi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Visual -->
                    <div class="w-full lg:w-1/2 relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-sky-200 to-blue-100 rounded-[3rem] transform rotate-3 scale-95 opacity-50 -z-10"></div>
                        <div class="bg-white rounded-[2.5rem] shadow-2xl p-6 border border-slate-100 relative overflow-hidden">
                             <!-- Placeholder Illustration representing Health Dashboard/Care -->
                             <div class="aspect-[4/3] bg-slate-100 rounded-2xl flex items-center justify-center relative overflow-hidden group">
                                <svg class="w-32 h-32 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent"></div>
                                <!-- Floating UI Elements -->
                                <div class="absolute bottom-6 left-6 right-6 bg-white/90 backdrop-blur p-4 rounded-xl shadow-lg border border-white/50 flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Pendaftaran Online Berhasil</p>
                                        <p class="text-xs text-slate-500">Silakan datang sesuai jadwal.</p>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Layanan Medis -->
        @if(($pengaturan['show_layanan_poli'] ?? '1') == '1')
        <section id="layanan" class="py-24 bg-white relative">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-slate-50 -z-10"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                    <div>
                        <span class="text-sky-500 font-bold tracking-widest uppercase text-xs mb-2 block">Layanan Kami</span>
                        <h2 class="text-3xl md:text-4xl font-black text-slate-900">Poliklinik & Spesialis</h2>
                    </div>
                    <p class="text-slate-500 max-w-md text-right md:text-left">
                        Berbagai layanan medis komprehensif yang ditangani oleh tenaga medis profesional dan berpengalaman.
                    </p>
                </div>

                @if($layanan->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($layanan as $poli)
                    <div class="group bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-sky-100 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-sky-50 to-transparent rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-150"></div>
                        
                        <div class="w-14 h-14 bg-sky-100 text-sky-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-sky-500 group-hover:text-white transition-colors">
                            <span class="text-2xl font-black">{{ substr($poli->nama_poli, 0, 1) }}</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $poli->nama_poli }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3">
                            {{ $poli->keterangan ?? 'Melayani pemeriksaan kesehatan umum, konsultasi, dan tindakan medis dasar sesuai standar operasional prosedur.' }}
                        </p>
                        
                        <a href="#" class="inline-flex items-center text-sm font-bold text-sky-600 hover:text-sky-700 transition-colors">
                            Lihat Detail <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <p class="text-slate-500">Belum ada data layanan poli yang ditambahkan.</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- Jadwal Dokter -->
        @if(($pengaturan['show_jadwal_dokter'] ?? '1') == '1')
        <section id="jadwal" class="py-24 bg-slate-900 text-white relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
                 <svg class="absolute -top-20 -left-20 w-96 h-96 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <span class="text-sky-400 font-bold tracking-widest uppercase text-xs mb-2 block">Jadwal Praktik</span>
                    <h2 class="text-3xl md:text-4xl font-black mb-4">Dokter Bertugas Hari Ini</h2>
                    <div class="inline-flex items-center justify-center gap-3 px-6 py-2 bg-white/10 rounded-full backdrop-blur-sm border border-white/10">
                        <div class="h-2 w-2 bg-green-400 rounded-full animate-pulse"></div>
                        <p class="font-bold text-sm tracking-wide">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>

                @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($jadwalHariIni as $jadwal)
                        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center gap-5">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-400 to-blue-600 flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-sky-500/20">
                                    {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg leading-tight">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                                    <p class="text-sky-300 text-xs font-bold uppercase tracking-wider mt-1">{{ $jadwal->pegawai->jabatan ?? 'Dokter Umum' }}</p>
                                    <div class="mt-3 flex items-center gap-2 text-xs font-medium text-slate-300">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $jadwal->shift->jam_masuk ?? '08:00' }} - {{ $jadwal->shift->jam_keluar ?? '14:00' }} WIB
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-12 text-center max-w-2xl mx-auto">
                        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4 text-white/50">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Tidak Ada Jadwal</h3>
                        <p class="text-slate-400">Belum ada dokter yang dijadwalkan untuk hari ini.</p>
                    </div>
                @endif
                
                <div class="mt-12 text-center">
                    <a href="#" class="inline-flex items-center gap-2 text-sky-400 hover:text-sky-300 font-bold text-sm transition-colors">
                        Lihat Jadwal Lengkap Minggu Ini <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </section>
        @endif

        <!-- Fasilitas & Informasi -->
        @if(($pengaturan['show_fasilitas'] ?? '1') == '1')
        <section id="fasilitas" class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-sky-500 font-bold tracking-widest uppercase text-xs mb-2 block">Fasilitas & Sarana</span>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-900">Penunjang Medis Modern</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="h-48 bg-slate-200 relative overflow-hidden">
                             <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent z-10"></div>
                             <!-- Placeholder Image -->
                             <div class="w-full h-full bg-slate-300 flex items-center justify-center text-slate-400">
                                 <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                             </div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-sky-600 transition-colors">Laboratorium Lengkap</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Dilengkapi peralatan modern untuk pemeriksaan darah, urin, dan tes medis lainnya dengan hasil cepat dan akurat.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="h-48 bg-slate-200 relative overflow-hidden">
                             <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent z-10"></div>
                             <div class="w-full h-full bg-slate-300 flex items-center justify-center text-slate-400">
                                 <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                             </div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-sky-600 transition-colors">Ruang Rawat Inap</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Kamar rawat inap yang bersih, nyaman, dan ber-AC untuk mempercepat pemulihan pasien.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="h-48 bg-slate-200 relative overflow-hidden">
                             <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent z-10"></div>
                             <div class="w-full h-full bg-slate-300 flex items-center justify-center text-slate-400">
                                 <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                             </div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-sky-600 transition-colors">IGD 24 Jam</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Unit Gawat Darurat yang siap sedia 24 jam menangani kasus kegawatdaruratan medis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- Berita & Informasi -->
        <section id="berita" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                 <div class="flex items-center justify-between mb-12">
                     <h2 class="text-3xl font-black text-slate-900">Informasi & Edukasi</h2>
                     @if($beritaTerbaru->count() > 0)
                        <a href="#" class="text-sm font-bold text-sky-600 hover:text-sky-700">Lihat Semua</a>
                     @endif
                 </div>

                 @if($beritaTerbaru->count() > 0)
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                     <!-- News Item Big (First Item) -->
                     <div class="group cursor-pointer">
                         <div class="aspect-video bg-slate-200 rounded-3xl mb-6 relative overflow-hidden">
                             @if($beritaTerbaru[0]->thumbnail)
                                <img src="{{ asset('storage/' . $beritaTerbaru[0]->thumbnail) }}" alt="{{ $beritaTerbaru[0]->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                             @else
                                <div class="absolute inset-0 bg-slate-300 flex items-center justify-center text-slate-400">
                                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                             @endif
                         </div>
                         <div class="flex items-center gap-3 text-xs font-bold text-slate-400 mb-3">
                             <span class="text-sky-600">{{ $beritaTerbaru[0]->kategori }}</span>
                             <span>•</span>
                             <span>{{ $beritaTerbaru[0]->created_at->diffForHumans() }}</span>
                         </div>
                         <h3 class="text-2xl font-black text-slate-900 mb-3 group-hover:text-sky-600 transition-colors">{{ $beritaTerbaru[0]->judul }}</h3>
                         <p class="text-slate-500 text-sm leading-relaxed line-clamp-2">
                             {{ Str::limit(strip_tags($beritaTerbaru[0]->konten), 150) }}
                         </p>
                     </div>

                     <!-- News List (Remaining Items) -->
                     <div class="flex flex-col gap-8">
                         @foreach($beritaTerbaru->skip(1) as $berita)
                         <div class="flex gap-6 group cursor-pointer">
                             <div class="w-32 h-24 bg-slate-200 rounded-xl flex-shrink-0 overflow-hidden relative">
                                 @if($berita->thumbnail)
                                    <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                                 @else
                                    <div class="absolute inset-0 bg-slate-300 flex items-center justify-center text-slate-400">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                 @endif
                             </div>
                             <div>
                                 <div class="flex items-center gap-3 text-xs font-bold text-slate-400 mb-2">
                                     <span class="text-sky-600">{{ $berita->kategori }}</span>
                                     <span>•</span>
                                     <span>{{ $berita->created_at->diffForHumans() }}</span>
                                 </div>
                                 <h4 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-sky-600 transition-colors leading-tight">{{ $berita->judul }}</h4>
                                 <p class="text-slate-500 text-xs line-clamp-2">{{ Str::limit(strip_tags($berita->konten), 80) }}</p>
                             </div>
                         </div>
                         @endforeach
                     </div>
                 </div>
                 @else
                    <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                        <div class="w-16 h-16 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                        <h3 class="text-slate-800 font-bold mb-1">Belum Ada Informasi</h3>
                        <p class="text-slate-500 text-sm">Berita dan artikel kesehatan akan segera ditampilkan di sini.</p>
                    </div>
                 @endif
            </div>
        </section>

        <!-- CTA / Footer Info -->
        <section class="py-20 bg-gradient-to-br from-sky-600 to-blue-700 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-5xl font-black mb-6">Layanan Kesehatan Digital</h2>
                <p class="text-sky-100 text-lg max-w-2xl mx-auto mb-10">
                    Akses layanan kesehatan kini lebih mudah dan cepat melalui sistem terintegrasi kami.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('antrean.monitor') }}" class="px-8 py-4 bg-white text-blue-700 text-sm font-bold rounded-2xl hover:bg-slate-100 transition shadow-xl">
                        Ambil Antrean Online
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 mb-16">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-sky-500 rounded-lg flex items-center justify-center text-white font-black text-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tighter">{{ $pengaturan['nama_aplikasi'] }}</span>
                    </div>
                    <p class="text-slate-400 leading-relaxed max-w-md mb-8">
                        {{ $pengaturan['deskripsi'] }}
                    </p>
                    <div class="flex gap-4">
                        <!-- Social Placeholders -->
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Menu Cepat</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#beranda" class="hover:text-sky-400 transition-colors">Beranda</a></li>
                        <li><a href="#jadwal" class="hover:text-sky-400 transition-colors">Jadwal Dokter</a></li>
                        <li><a href="#layanan" class="hover:text-sky-400 transition-colors">Layanan Medis</a></li>
                        <li><a href="#fasilitas" class="hover:text-sky-400 transition-colors">Fasilitas</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-sky-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $pengaturan['alamat'] }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $pengaturan['telepon'] }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $pengaturan['email'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 text-center">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">
                    &copy; {{ date('Y') }} {{ $pengaturan['footer_text'] }}. Dikembangkan oleh SATRIA.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>