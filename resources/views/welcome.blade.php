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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: {{ $pengaturan['primary_color'] ?? '#2563eb' }};
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .hero-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(#eff6ff 2px, transparent 2px), radial-gradient(#eff6ff 2px, transparent 2px);
            background-size: 32px 32px;
            background-position: 0 0, 16px 16px;
        }

        .text-primary { color: var(--primary-color); }
        .bg-primary { background-color: var(--primary-color); }
        .border-primary { border-color: var(--primary-color); }
        .hover-text-primary:hover { color: var(--primary-color); }
        .hover-bg-primary:hover { background-color: var(--primary-color); }
        .focus-ring-primary:focus { --tw-ring-color: var(--primary-color); }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800 selection:bg-blue-600 selection:text-white overflow-x-hidden">

    <!-- Announcement Bar -->
    @if(($pengaturan['announcement_active'] ?? '0') == '1')
    <div class="bg-primary text-white text-sm font-medium py-2.5 px-4 text-center relative z-[60]">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
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
                    <div class="relative flex items-center justify-center w-10 h-10 bg-primary rounded-xl shadow-lg shadow-blue-500/20 text-white">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold text-slate-900 leading-none tracking-tight">{{ $pengaturan['nama_aplikasi'] }}</span>
                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest mt-1">Layanan Terpadu</span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-sm font-bold text-slate-600 hover-text-primary transition-colors">Beranda</a>
                    <a href="#jadwal" class="text-sm font-bold text-slate-600 hover-text-primary transition-colors">Jadwal</a>
                    <a href="#layanan" class="text-sm font-bold text-slate-600 hover-text-primary transition-colors">Layanan</a>
                    <a href="#fasilitas" class="text-sm font-bold text-slate-600 hover-text-primary transition-colors">Fasilitas</a>
                    
                    <div class="h-5 w-px bg-slate-200 mx-2"></div>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">
                                <span>Dashboard</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:border-blue-500 hover-text-primary transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                <span>Masuk Staff</span>
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-blue-100 text-primary text-xs font-bold uppercase tracking-wider mb-8 shadow-sm animate-fade-in-up">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary"></span>
                </span>
                Sistem Pelayanan Digital Terkini
            </div>
            
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-slate-900 tracking-tight mb-8 leading-[1.1] max-w-5xl mx-auto">
                {{ $pengaturan['judul_hero'] }} <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">{{ $pengaturan['subjudul_hero'] }}</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-500 mb-12 max-w-3xl mx-auto leading-relaxed font-medium">
                {{ $pengaturan['deskripsi'] }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('antrean.monitor') }}" class="px-8 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-blue-600/20 hover:opacity-90 transition-all transform hover:-translate-y-1 w-full sm:w-auto flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Ambil Antrean</span>
                </a>
                <a href="#jadwal" class="px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl shadow-lg border border-slate-200 hover:border-blue-300 hover-text-primary transition-all w-full sm:w-auto flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span>Lihat Jadwal</span>
                </a>
            </div>
        </div>
        
        <!-- Decorative blobs -->
        <div class="absolute top-0 left-0 -ml-20 -mt-20 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-cyan-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </section>

    <!-- Jadwal Dokter Hari Ini (Dynamic) -->
    <section id="jadwal" class="py-20 bg-white border-b border-slate-100 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Jadwal Praktik</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Dokter Hari Ini</h2>
                    <p class="mt-2 text-slate-500 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="hidden md:block h-1 w-24 bg-primary rounded-full mb-2"></div>
            </div>

            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="group relative bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-50 to-white border border-blue-100 flex items-center justify-center text-primary font-extrabold text-2xl shadow-inner">
                                {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-lg group-hover-text-primary transition-colors">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                                <p class="text-sm text-slate-500 font-medium">{{ $jadwal->pegawai->jabatan ?? 'Dokter Umum' }}</p>
                                <div class="flex items-center gap-2 mt-3 text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg inline-flex">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $jadwal->shift->jam_masuk ?? '08:00' }} - {{ $jadwal->shift->jam_keluar ?? '14:00' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-50 rounded-3xl p-12 text-center border border-slate-200 border-dashed">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Tidak Ada Jadwal</h3>
                    <p class="text-slate-500 mt-2">Belum ada dokter yang dijadwalkan untuk hari ini.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Layanan Section (Dynamic) -->
    <section id="layanan" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Poliklinik & Unit</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Layanan Medis</h2>
                <p class="mt-4 text-slate-500 text-lg">Pelayanan kesehatan komprehensif dengan fasilitas modern.</p>
            </div>

            @if($layanan->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($layanan as $poli)
                <div class="group bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 relative overflow-hidden border border-slate-100 hover:border-blue-200">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                    
                    <div class="w-14 h-14 bg-white border border-slate-100 rounded-2xl flex items-center justify-center mb-6 shadow-sm relative z-10 group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="text-xl font-bold">{{ substr($poli->nama_poli, 0, 1) }}</span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 mb-3 relative z-10">{{ $poli->nama_poli }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6 relative z-10">
                        {{ $poli->keterangan ?? 'Layanan medis profesional.' }}
                    </p>
                    
                    <a href="#" class="inline-flex items-center text-sm font-bold text-slate-400 group-hover-text-primary transition-colors relative z-10">
                        Info Lengkap <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    <!-- Fasilitas / Keunggulan -->
    <section id="fasilitas" class="py-24 bg-white border-t border-slate-200">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-primary font-bold tracking-widest uppercase text-xs mb-2 block">Fasilitas Unggulan</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6">Kenyamanan Anda Prioritas Kami.</h2>
                    <p class="text-slate-500 text-lg leading-relaxed mb-8">
                        Kami menyediakan fasilitas kesehatan dengan standar tinggi untuk memastikan setiap pasien mendapatkan penanganan yang cepat, tepat, dan nyaman.
                    </p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="font-bold text-slate-700">Ruang Tunggu Nyaman & Ber-AC</span>
                        </li>
                         <li class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="font-bold text-slate-700">Apotek Terlengkap & Terintegrasi</span>
                        </li>
                         <li class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="font-bold text-slate-700">Laboratorium Modern</span>
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-3xl transform rotate-3 opacity-20 blur-lg"></div>
                    <div class="relative bg-slate-900 rounded-3xl p-8 md:p-12 text-white overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                        <h3 class="text-2xl font-bold mb-4">Gawat Darurat 24 Jam</h3>
                        <p class="text-slate-300 mb-8">Layanan UGD kami siap sedia menangani kondisi kritis dengan tim medis yang sigap.</p>
                        <a href="tel:{{ $pengaturan['telepon'] }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-900 font-bold rounded-xl hover:bg-blue-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>Panggil Ambulans</span>
                        </a>
                    </div>
                </div>
            </div>
         </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <h2 class="text-2xl font-extrabold text-white mb-6">{{ $pengaturan['nama_aplikasi'] }}</h2>
                    <p class="text-slate-400 mb-6 max-w-sm leading-relaxed">
                        {{ $pengaturan['deskripsi'] }}
                    </p>
                </div>
                <div>
                     <h4 class="font-bold text-white mb-6">Kontak</h4>
                     <ul class="space-y-4 text-sm">
                        <li>{{ $pengaturan['alamat'] }}</li>
                        <li>{{ $pengaturan['telepon'] }}</li>
                        <li>{{ $pengaturan['email'] }}</li>
                     </ul>
                </div>
                <div>
                     <h4 class="font-bold text-white mb-6">Menu</h4>
                     <ul class="space-y-4 text-sm">
                        <li><a href="#beranda" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#jadwal" class="hover:text-white transition-colors">Jadwal Dokter</a></li>
                        <li><a href="#layanan" class="hover:text-white transition-colors">Layanan</a></li>
                     </ul>
                </div>
             </div>
             <div class="border-t border-slate-800 pt-8 text-center text-sm text-slate-500">
                 &copy; {{ date('Y') }} {{ $pengaturan['nama_aplikasi'] }}. All rights reserved.
             </div>
        </div>
    </footer>
</body>
</html>