<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $pengaturan['deskripsi'] }}">
    <meta name="theme-color" content="{{ $pengaturan['primary_color'] ?? '#0d9488' }}">
    <title>{{ $pengaturan['nama_aplikasi'] }} - {{ $pengaturan['tagline'] }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* Fallback to Teal-600 if setup is null */
            --primary-color: {{ $pengaturan['primary_color'] ?? '#0d9488' }}; 
            --primary-rgb: {{ hexdec(substr($pengaturan['primary_color'] ?? '#0d9488', 1, 2)) }}, {{ hexdec(substr($pengaturan['primary_color'] ?? '#0d9488', 3, 2)) }}, {{ hexdec(substr($pengaturan['primary_color'] ?? '#0d9488', 5, 2)) }};
        }
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        
        /* Utility Classes for Dynamic Colors */
        .text-primary { color: var(--primary-color); }
        .bg-primary { background-color: var(--primary-color); }
        .bg-primary-50 { background-color: rgba(var(--primary-rgb), 0.05); }
        .bg-primary-100 { background-color: rgba(var(--primary-rgb), 0.1); }
        .bg-primary-10 { background-color: rgba(var(--primary-rgb), 0.1); }
        .border-primary { border-color: var(--primary-color); }
        .ring-primary { --tw-ring-color: var(--primary-color); }
        
        .hover\:bg-primary:hover { background-color: var(--primary-color); }
        .hover\:text-primary:hover { color: var(--primary-color); }
        .group:hover .group-hover\:text-primary { color: var(--primary-color); }
        
        /* Custom Effects */
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .hero-bg {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(var(--primary-rgb), 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.1) 0px, transparent 50%);
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

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-600 selection:bg-primary selection:text-white overflow-x-hidden">

    <!-- Navbar -->
    <nav id="navbar" class="fixed w-full z-50 transition-all duration-300 top-0 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-sm border border-slate-200/60 px-6 py-3 flex justify-between items-center">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30" style="background-image: linear-gradient(135deg, var(--primary-color), #2563eb);">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-black text-xl text-slate-800 tracking-tight leading-none">{{ $pengaturan['nama_aplikasi'] }}</h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sistem Kesehatan</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#beranda" class="text-sm font-bold text-slate-500 hover:text-primary transition-colors">Beranda</a>
                    <a href="#layanan" class="text-sm font-bold text-slate-500 hover:text-primary transition-colors">Layanan</a>
                    <a href="#jadwal" class="text-sm font-bold text-slate-500 hover:text-primary transition-colors">Dokter</a>
                    <a href="#fasilitas" class="text-sm font-bold text-slate-500 hover:text-primary transition-colors">Fasilitas</a>
                    <a href="#berita" class="text-sm font-bold text-slate-500 hover:text-primary transition-colors">Info</a>
                </div>

                <!-- CTA Button -->
                <div class="flex items-center gap-3">
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
                            <a href="{{ route('antrean.monitor') }}" class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/30 flex items-center gap-2 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                Antrean
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                
                <!-- Text Content -->
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    @if(($pengaturan['announcement_active'] ?? '0') == '1')
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-50 border border-red-100 text-red-600 text-[11px] font-bold uppercase tracking-wider mb-8 animate-bounce">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            {{ $pengaturan['announcement_text'] }}
                        </div>
                    @endif

                    <h1 class="text-4xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.15] mb-6">
                        {{ $pengaturan['judul_hero'] }} <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-blue-600" style="background-image: linear-gradient(to right, var(--primary-color), #2563eb);">
                            {{ $pengaturan['subjudul_hero'] }}
                        </span>
                    </h1>
                    
                    <p class="text-lg text-slate-500 mb-10 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        {{ $pengaturan['deskripsi'] }}
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('antrean.monitor') }}" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl hover:bg-slate-800 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Ambil Nomor Antrean
                        </a>
                        @if(($pengaturan['show_pengaduan_cta'] ?? '1') == '1')
                            <a href="{{ route('pengaduan.public') }}" class="px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold hover:border-primary hover:text-primary transition-all flex items-center justify-center gap-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                Layanan Pengaduan
                            </a>
                        @endif
                    </div>

                    <div class="mt-12 pt-8 border-t border-slate-200 flex items-center justify-center lg:justify-start gap-8 text-slate-400">
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-green-100 rounded-lg text-green-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-600">Terpercaya</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-sm font-bold text-slate-600">Cepat & Efisien</span>
                        </div>
                    </div>
                </div>

                <!-- Visual -->
                <div class="w-full lg:w-1/2 relative">
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 bg-primary opacity-20 rounded-full blur-3xl blob"></div>
                    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-blue-500 opacity-20 rounded-full blur-3xl blob" style="animation-delay: 2s"></div>
                    
                    <div class="relative bg-white rounded-[2.5rem] shadow-2xl p-4 sm:p-8 border border-slate-100/50 backdrop-blur-sm transform rotate-2 hover:rotate-0 transition-all duration-500">
                        <div class="bg-slate-50 rounded-3xl overflow-hidden relative aspect-[4/3] group">
                            <!-- Illustration Placeholder -->
                            <div class="absolute inset-0 flex items-center justify-center bg-slate-100">
                                <svg class="w-32 h-32 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            
                            <!-- Overlay Info -->
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-slate-900/80 to-transparent p-6 pt-20">
                                <p class="text-white font-bold text-lg">Pelayanan Prima</p>
                                <p class="text-slate-300 text-sm">Mengutamakan keselamatan dan kenyamanan pasien.</p>
                            </div>
                        </div>

                        <!-- Floating Card -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-green-500/30">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase">Layanan Darurat</p>
                                <p class="text-lg font-black text-slate-900">{{ $pengaturan['telepon'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Section -->
    @if(($pengaturan['show_layanan_poli'] ?? '1') == '1')
    <section id="layanan" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Poliklinik & Spesialis</span>
                <h2 class="text-3xl lg:text-5xl font-black text-slate-900 mb-4">Layanan Medis Unggulan</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">
                    Didukung tenaga medis profesional dan peralatan modern untuk kesembuhan Anda.
                </p>
            </div>

            @if($layanan->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($layanan as $poli)
                <div class="group bg-slate-50 rounded-[2rem] p-8 border border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-primary/5 hover:border-primary/20 transition-all duration-300 relative overflow-hidden">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl font-black text-primary mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        {{ substr($poli->nama_poli, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $poli->nama_poli }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-3">
                        {{ $poli->keterangan ?? 'Layanan pemeriksaan kesehatan komprehensif oleh dokter ahli di bidangnya.' }}
                    </p>
                    <a href="#" class="absolute bottom-8 text-sm font-bold text-primary flex items-center gap-1 group-hover:gap-2 transition-all">
                        Selengkapnya <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <p class="text-slate-400 font-medium">Data layanan poliklinik belum tersedia saat ini.</p>
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Jadwal Dokter -->
    @if(($pengaturan['show_jadwal_dokter'] ?? '1') == '1')
    <section id="jadwal" class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Jadwal Praktik Hari Ini</span>
                    <h2 class="text-3xl lg:text-4xl font-black text-white">Dokter Siaga</h2>
                </div>
                <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full backdrop-blur-sm border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-sm font-bold">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 p-6 rounded-3xl hover:bg-white/10 transition-colors group">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center text-xl font-black text-white shadow-lg" style="background-image: linear-gradient(135deg, var(--primary-color), #2563eb);">
                                {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-lg text-white mb-1 group-hover:text-primary transition-colors">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-4">{{ $jadwal->pegawai->jabatan ?? 'Dokter Umum' }}</p>
                                
                                <div class="bg-black/20 rounded-xl p-3 flex items-center justify-between">
                                    <span class="text-xs text-slate-300 font-medium">Jam Praktik</span>
                                    <span class="text-sm font-bold text-white">{{ $jadwal->shift->jam_masuk ?? '08:00' }} - {{ $jadwal->shift->jam_keluar ?? '14:00' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white/5 border border-white/10 rounded-3xl p-12 text-center max-w-lg mx-auto">
                    <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4 text-white/50">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Tidak Ada Jadwal</h3>
                    <p class="text-slate-400">Belum ada dokter yang dijadwalkan bertugas untuk hari ini.</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Fasilitas -->
    @if(($pengaturan['show_fasilitas'] ?? '1') == '1')
    <section id="fasilitas" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Sarana & Prasarana</span>
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
                            <div class="absolute inset-0 bg-slate-200 flex items-center justify-center text-slate-400 z-10">
                                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                         @endif
                         
                         <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent z-20"></div>
                         <div class="absolute bottom-6 left-6 z-30">
                             @if($item->jenis == 'unggulan')
                                <span class="bg-primary text-white text-[10px] font-bold px-2 py-1 rounded mb-2 inline-block">UNGGULAN</span>
                             @endif
                             <h3 class="text-xl font-bold text-white">{{ $item->nama_fasilitas }}</h3>
                         </div>
                    </div>
                    <div class="p-8">
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-4">
                            {{ $item->deskripsi }}
                        </p>
                        <div class="w-8 h-1 bg-primary rounded-full group-hover:w-16 transition-all duration-300"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-slate-200">
                <p class="text-slate-400">Informasi fasilitas belum tersedia.</p>
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Berita -->
    <section id="berita" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Artikel & Informasi</span>
                    <h2 class="text-3xl lg:text-4xl font-black text-slate-900">Kabar Terbaru</h2>
                </div>
                @if($beritaTerbaru->count() > 0)
                <a href="#" class="hidden sm:inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-primary transition-colors">
                    Lihat Arsip Berita <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                @endif
            </div>

            @if($beritaTerbaru->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($beritaTerbaru as $berita)
                <div class="group cursor-pointer">
                    <div class="bg-slate-100 rounded-3xl overflow-hidden aspect-[16/10] mb-6 relative">
                        @if($berita->thumbnail)
                            <img src="{{ asset('storage/' . $berita->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $berita->judul }}">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-slate-400">
                                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur text-xs font-bold px-3 py-1 rounded-lg shadow-sm">
                            {{ $berita->created_at->format('d M Y') }}
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold text-primary mb-2 uppercase tracking-wide">
                        <span>{{ $berita->kategori }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-primary transition-colors line-clamp-2">
                        {{ $berita->judul }}
                    </h3>
                    <p class="text-slate-500 text-sm leading-relaxed line-clamp-3">
                        {{ Str::limit(strip_tags($berita->konten), 100) }}
                    </p>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <p class="text-slate-400">Belum ada berita yang dipublikasikan.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 pt-24 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
                <div class="lg:col-span-2">
                    <a href="#" class="inline-flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-blue-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-lg shadow-primary/20" style="background-image: linear-gradient(135deg, var(--primary-color), #2563eb);">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight">{{ $pengaturan['nama_aplikasi'] }}</span>
                    </a>
                    <p class="text-slate-400 leading-relaxed max-w-sm mb-8">
                        {{ $pengaturan['deskripsi'] }}
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Navigasi</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#beranda" class="hover:text-primary transition-colors">Beranda</a></li>
                        <li><a href="#layanan" class="hover:text-primary transition-colors">Layanan Medis</a></li>
                        <li><a href="#jadwal" class="hover:text-primary transition-colors">Jadwal Dokter</a></li>
                        <li><a href="#fasilitas" class="hover:text-primary transition-colors">Fasilitas</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider text-sm mb-6">Kontak</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $pengaturan['alamat'] }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $pengaturan['telepon'] }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $pengaturan['email'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 text-center">
                <p class="text-xs font-bold text-slate-600 uppercase tracking-widest">
                    &copy; {{ date('Y') }} {{ $pengaturan['footer_text'] }}. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('py-2');
                navbar.classList.remove('py-4');
            } else {
                navbar.classList.add('py-4');
                navbar.classList.remove('py-2');
            }
        });
    </script>
</body>
</html>
