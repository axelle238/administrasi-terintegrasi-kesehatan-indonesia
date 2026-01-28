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
            --primary-color: {{ $pengaturan['primary_color'] ?? '#2563eb' }};
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.05), transparent),
                        radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.05), transparent);
        }

        .text-primary { color: var(--primary-color); }
        .bg-primary { background-color: var(--primary-color); }
        .border-primary { border-color: var(--primary-color); }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }
    </style>
</head>
<body class="antialiased bg-white text-slate-800 selection:bg-blue-600 selection:text-white overflow-x-hidden">

    <!-- Announcement Bar -->
    @if(($pengaturan['announcement_active'] ?? '0') == '1')
    <div class="bg-primary text-white text-[11px] font-bold py-2 px-4 text-center relative z-[60] tracking-widest uppercase">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-3">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
            </span>
            <span>{{ $pengaturan['announcement_text'] }}</span>
        </div>
    </div>
    @endif
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="relative flex items-center justify-center w-11 h-11 bg-primary rounded-2xl shadow-xl shadow-blue-500/20 text-white">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-black text-slate-900 leading-none tracking-tighter">{{ $pengaturan['nama_aplikasi'] }}</span>
                        <span class="text-[9px] font-extrabold text-primary uppercase tracking-[0.3em] mt-1.5">Kesehatan Terintegrasi</span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-10">
                    <a href="#beranda" class="text-xs font-black text-slate-500 hover:text-primary transition-colors uppercase tracking-widest">Beranda</a>
                    <a href="#jadwal" class="text-xs font-black text-slate-500 hover:text-primary transition-colors uppercase tracking-widest">Jadwal</a>
                    <a href="#layanan" class="text-xs font-black text-slate-500 hover:text-primary transition-colors uppercase tracking-widest">Layanan</a>
                    <a href="#fasilitas" class="text-xs font-black text-slate-500 hover:text-primary transition-colors uppercase tracking-widest">Fasilitas</a>
                    
                    <div class="h-4 w-px bg-slate-200 mx-2"></div>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white text-xs font-black rounded-2xl hover:bg-slate-800 transition shadow-xl shadow-slate-900/20 uppercase tracking-widest">
                                <span>Panel Dashboard</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-slate-100 text-slate-800 text-xs font-black rounded-2xl hover:border-primary hover:text-primary transition-all uppercase tracking-widest">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                <span>Akses Staf</span>
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-40 pb-20 lg:pt-56 lg:pb-40 overflow-hidden hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="w-full lg:w-3/5 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white shadow-xl shadow-blue-500/5 border border-blue-50 text-primary text-[10px] font-black uppercase tracking-[0.2em] mb-10">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Sistem Pelayanan Digital Puskesmas
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-slate-900 tracking-tighter mb-10 leading-[0.95]">
                        {{ $pengaturan['judul_hero'] }} <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">{{ $pengaturan['subjudul_hero'] }}</span>
                    </h1>
                    
                    <p class="text-lg md:text-xl text-slate-500 mb-12 max-w-2xl lg:mx-0 mx-auto leading-relaxed font-medium">
                        {{ $pengaturan['deskripsi'] }}
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-5 justify-center lg:justify-start items-center">
                        <a href="{{ route('antrean.monitor') }}" class="px-10 py-5 bg-primary text-white text-sm font-black rounded-3xl shadow-2xl shadow-blue-600/30 hover:scale-105 transition-all transform w-full sm:w-auto flex items-center justify-center gap-3 uppercase tracking-widest">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Ambil Antrean</span>
                        </a>
                        @if(($pengaturan['show_pengaduan_cta'] ?? '1') == '1')
                        <a href="{{ route('pengaduan.public') }}" class="px-10 py-5 bg-white border-2 border-slate-100 text-slate-800 text-sm font-black rounded-3xl hover:border-primary hover:text-primary transition-all w-full sm:w-auto flex items-center justify-center gap-3 uppercase tracking-widest">
                            <span>Layanan Pengaduan</span>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Hero Image Decor -->
                <div class="w-full lg:w-2/5 relative hidden lg:block">
                    <div class="relative z-10 animate-float">
                        <div class="w-full aspect-square bg-gradient-to-br from-blue-600 to-cyan-400 rounded-[4rem] shadow-3xl transform rotate-6 overflow-hidden flex items-center justify-center p-12">
                             <svg class="w-48 h-48 text-white opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-blue-400 rounded-[4rem] blur-3xl opacity-10 -z-10 transform scale-110"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jadwal Dokter Hari Ini (Dynamic) -->
    @if(($pengaturan['show_jadwal_dokter'] ?? '1') == '1')
    <section id="jadwal" class="py-32 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <span class="text-primary font-black tracking-[0.4em] uppercase text-[10px] mb-4 block">Operasional</span>
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Jadwal Praktik Hari Ini</h2>
                <div class="mt-4 flex items-center justify-center gap-3">
                    <div class="h-1.5 w-12 bg-primary rounded-full"></div>
                    <p class="text-slate-500 font-bold uppercase text-xs tracking-widest">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    <div class="h-1.5 w-12 bg-primary rounded-full"></div>
                </div>
            </div>

            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm card-hover relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-[3rem] -mr-6 -mt-6 transition-transform group-hover:scale-110"></div>
                        
                        <div class="flex items-center gap-6 relative z-10">
                            <div class="w-20 h-20 rounded-3xl bg-slate-900 flex items-center justify-center text-white font-black text-3xl shadow-2xl">
                                {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-xl group-hover:text-primary transition-colors leading-tight">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                                <p class="text-xs text-primary font-black uppercase tracking-widest mt-1">{{ $jadwal->pegawai->jabatan ?? 'Dokter Umum' }}</p>
                                <div class="flex items-center gap-2 mt-4 text-[10px] font-black text-slate-400 bg-slate-50 px-3 py-1.5 rounded-xl inline-flex tracking-widest">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $jadwal->shift->jam_masuk ?? '08:00' }} - {{ $jadwal->shift->jam_keluar ?? '14:00' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-widest">Sistem Sedang Diperbarui</h3>
                    <p class="text-slate-500 mt-2 font-medium">Belum ada jadwal dokter yang tersedia untuk hari ini.</p>
                </div>
            @endif
        </div>
    </section>
    @endif

    <!-- Layanan Section (Dynamic) -->
    @if(($pengaturan['show_layanan_poli'] ?? '1') == '1')
    <section id="layanan" class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-24">
                <span class="text-primary font-black tracking-[0.4em] uppercase text-[10px] mb-4 block">Poliklinik & Unit</span>
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Layanan Medis Terintegrasi</h2>
                <p class="mt-6 text-slate-500 text-lg leading-relaxed font-medium">Memberikan pelayanan kesehatan primer dengan kualitas terbaik bagi masyarakat.</p>
            </div>

            @if($layanan->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($layanan as $poli)
                <div class="group bg-slate-50 rounded-[2.5rem] p-10 card-hover border border-transparent hover:border-blue-100 hover:bg-white relative overflow-hidden">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mb-8 shadow-sm group-hover:bg-primary group-hover:text-white transition-all duration-300">
                        <span class="text-2xl font-black">{{ substr($poli->nama_poli, 0, 1) }}</span>
                    </div>
                    
                    <h3 class="text-2xl font-black text-slate-900 mb-4">{{ $poli->nama_poli }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8">
                        {{ $poli->keterangan ?? 'Layanan medis profesional dengan tenaga ahli di bidangnya.' }}
                    </p>
                    
                    <div class="pt-6 border-t border-slate-200/60 mt-auto">
                         <span class="inline-flex items-center text-[10px] font-black text-primary uppercase tracking-widest group-hover:gap-4 transition-all gap-2">
                            Info Detail <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 rounded-[3.5rem] p-10 md:p-20 relative overflow-hidden shadow-3xl">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-cyan-600 rounded-full blur-3xl opacity-20"></div>
                
                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12 text-center lg:text-left">
                    <div>
                        <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-6 tracking-tight">Butuh Bantuan Segera?</h2>
                        <p class="text-slate-400 text-lg max-w-xl font-medium">Tim medis kami siap melayani Anda 24/7 untuk kondisi darurat. Hubungi nomor layanan kami kapan saja.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="tel:{{ $pengaturan['telepon'] }}" class="px-12 py-5 bg-white text-slate-900 text-sm font-black rounded-3xl hover:bg-blue-50 transition-all uppercase tracking-widest shadow-xl">
                            {{ $pengaturan['telepon'] }}
                        </a>
                        <a href="{{ route('pengaduan.public') }}" class="px-12 py-5 bg-blue-600 text-white text-sm font-black rounded-3xl hover:bg-blue-700 transition-all uppercase tracking-widest shadow-xl shadow-blue-600/20">
                            Pengaduan Online
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="grid grid-cols-1 lg:grid-cols-4 gap-16 mb-20 text-center lg:text-left">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 justify-center lg:justify-start mb-8">
                        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white font-black text-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <span class="text-3xl font-black text-slate-900 tracking-tighter">{{ $pengaturan['nama_aplikasi'] }}</span>
                    </div>
                    <p class="text-slate-500 font-medium leading-relaxed max-w-md mx-auto lg:mx-0">
                        {{ $pengaturan['deskripsi'] }}
                    </p>
                </div>
                <div>
                     <h4 class="text-xs font-black text-slate-900 uppercase tracking-[0.3em] mb-8">Hubungi Kami</h4>
                     <ul class="space-y-4 text-sm font-bold text-slate-500">
                        <li class="flex items-start gap-3 justify-center lg:justify-start">
                            <span>{{ $pengaturan['alamat'] }}</span>
                        </li>
                        <li>{{ $pengaturan['telepon'] }}</li>
                        <li class="text-primary">{{ $pengaturan['email'] }}</li>
                     </ul>
                </div>
                <div>
                     <h4 class="text-xs font-black text-slate-900 uppercase tracking-[0.3em] mb-8">Navigasi</h4>
                     <ul class="space-y-4 text-sm font-bold text-slate-500">
                        <li><a href="#beranda" class="hover:text-primary transition-colors">Beranda</a></li>
                        <li><a href="#jadwal" class="hover:text-primary transition-colors">Jadwal Dokter</a></li>
                        <li><a href="#layanan" class="hover:text-primary transition-colors">Layanan Medis</a></li>
                     </ul>
                </div>
             </div>
             <div class="pt-8 border-t border-slate-100 text-center">
                 <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]">
                    &copy; {{ date('Y') }} {{ $pengaturan['footer_text'] }}. Digital Transformation by SATRIA.
                 </p>
             </div>
        </div>
    </footer>
</body>
</html>
