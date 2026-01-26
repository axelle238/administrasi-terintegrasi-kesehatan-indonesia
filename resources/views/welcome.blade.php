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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .pattern-grid {
            background-image: linear-gradient(to right, #f1f5f9 1px, transparent 1px),
            linear-gradient(to bottom, #f1f5f9 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="antialiased bg-white text-slate-800 selection:bg-blue-600 selection:text-white overflow-x-hidden">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="relative flex items-center justify-center w-10 h-10 bg-blue-600 rounded-xl shadow-lg shadow-blue-600/20 text-white">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-bold text-slate-900 leading-none tracking-tight">{{ $pengaturan['nama_aplikasi'] }}</span>
                        <span class="text-[10px] font-semibold text-blue-600 uppercase tracking-widest mt-1">Layanan Kesehatan Terpadu</span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="#jadwal" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Jadwal Dokter</a>
                    <a href="#layanan" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Layanan Poli</a>
                    <a href="#keunggulan" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Fasilitas</a>
                    
                    <div class="h-5 w-px bg-slate-200 mx-2"></div>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-full hover:bg-slate-800 transition shadow-lg shadow-slate-900/20">
                                <span>Dashboard</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-full hover:border-blue-600 hover:text-blue-600 transition-all">
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
    <section id="beranda" class="relative pt-32 pb-24 lg:pt-48 lg:pb-40 overflow-hidden pattern-grid">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-8 shadow-sm animate-fade-in-up">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                </span>
                Sistem Pelayanan Digital
            </div>
            
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-slate-900 tracking-tight mb-8 leading-[1.1] max-w-5xl mx-auto">
                {{ $pengaturan['judul_hero'] }} <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-teal-500">{{ $pengaturan['subjudul_hero'] }}</span>
            </h1>
            
            <p class="text-lg md:text-xl text-slate-500 mb-12 max-w-3xl mx-auto leading-relaxed font-medium">
                {{ $pengaturan['deskripsi'] }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
                <a href="{{ route('antrean.monitor') }}" class="group relative px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl shadow-xl shadow-blue-600/30 hover:bg-blue-700 transition-all transform hover:-translate-y-1 w-full sm:w-auto overflow-hidden">
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></div>
                    <div class="flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        <span>Ambil Antrean & Daftar</span>
                    </div>
                </a>
                <a href="{{ route('antrean.monitor') }}" class="px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl shadow-lg border border-slate-200 hover:border-blue-300 hover:text-blue-600 transition-all w-full sm:w-auto flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    <span>Layar Monitor</span>
                </a>
            </div>
        </div>
        
        <!-- Decorative blobs -->
        <div class="absolute top-0 left-0 -ml-20 -mt-20 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-teal-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </section>

    <!-- Jadwal Dokter Hari Ini (Dynamic) -->
    <section id="jadwal" class="py-16 bg-white border-b border-slate-100 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-blue-600 font-bold tracking-widest uppercase text-xs mb-2 block">Jadwal Praktik</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Dokter Bertugas Hari Ini</h2>
                    <p class="mt-2 text-slate-500">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            @if(isset($jadwalHariIni) && count($jadwalHariIni) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jadwalHariIni as $jadwal)
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:shadow-md transition-all">
                        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl flex-shrink-0">
                            {{ substr($jadwal->pegawai->user->name ?? 'D', 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $jadwal->pegawai->user->name ?? 'Dokter' }}</h4>
                            <p class="text-sm text-blue-600 font-medium">{{ $jadwal->pegawai->jabatan ?? 'Dokter Umum' }}</p>
                            <div class="flex items-center gap-2 mt-2 text-xs text-slate-500">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                {{ $jadwal->shift->jam_masuk ?? '08:00' }} - {{ $jadwal->shift->jam_keluar ?? '14:00' }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-50 rounded-2xl p-8 text-center border border-slate-200 border-dashed">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <p class="text-slate-500 font-medium">Belum ada jadwal dokter yang dipublikasikan untuk hari ini.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Layanan Section (Dynamic) -->
    <section id="layanan" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="max-w-2xl">
                    <span class="text-blue-600 font-bold tracking-widest uppercase text-xs mb-2 block">Poliklinik & Unit</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Layanan Medis Tersedia</h2>
                    <p class="mt-4 text-slate-500 text-lg">Kami menyediakan berbagai layanan kesehatan profesional yang didukung oleh tenaga medis berpengalaman.</p>
                </div>
                <a href="#keunggulan" class="hidden md:inline-flex items-center font-bold text-blue-600 hover:text-blue-700 transition-colors">
                    Lihat fasilitas lainnya <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            @if($layanan->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($layanan as $poli)
                <div class="group relative bg-white rounded-2xl p-8 hover:bg-white border border-slate-200 hover:border-blue-100 hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-50 border border-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <!-- Icon Placeholder (Initials) -->
                        <span class="text-xl font-bold">{{ substr($poli->nama_poli, 0, 1) }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">{{ $poli->nama_poli }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        {{ $poli->keterangan ?? 'Layanan medis profesional untuk kebutuhan kesehatan Anda.' }}
                    </p>
                    <div class="flex items-center text-sm font-bold text-slate-400 group-hover:text-blue-600 transition-colors">
                        <span>Lihat Detail</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white border border-slate-200 border-dashed rounded-3xl p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Belum ada layanan</h3>
                <p class="text-slate-500 mt-2">Data poliklinik belum ditambahkan ke dalam sistem.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section id="keunggulan" class="py-24 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-blue-600 font-bold tracking-widest uppercase text-xs mb-2 block">Mengapa Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Keunggulan Sistem {{ $pengaturan['nama_aplikasi'] }}</h2>
                <p class="mt-4 text-slate-500 text-lg">Platform terintegrasi yang dirancang untuk efisiensi, kecepatan, dan kenyamanan pasien serta tenaga medis.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @if(isset($pengaturan['fitur']) && count($pengaturan['fitur']) > 0)
                    @foreach($pengaturan['fitur'] as $fitur)
                    <div class="bg-slate-50 p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            @if(($fitur['icon'] ?? '') == 'clipboard-document-list')
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            @elseif(($fitur['icon'] ?? '') == 'beaker')
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            @elseif(($fitur['icon'] ?? '') == 'chart-bar')
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            @else
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $fitur['title'] ?? 'Fitur Unggulan' }}</h3>
                        <p class="text-slate-500 leading-relaxed">
                            {{ $fitur['desc'] ?? 'Deskripsi fitur belum ditambahkan.' }}
                        </p>
                    </div>
                    @endforeach
                @else
                    <!-- Default Features if empty -->
                     <div class="bg-slate-50 p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Terintegrasi</h3>
                        <p class="text-slate-500 leading-relaxed">Seluruh data pasien, rekam medis, dan apotek saling terhubung dalam satu sistem yang utuh.</p>
                     </div>
                     <div class="bg-slate-50 p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Real-time</h3>
                        <p class="text-slate-500 leading-relaxed">Pemantauan antrean dan stok obat dilakukan secara waktu nyata untuk akurasi data.</p>
                     </div>
                     <div class="bg-slate-50 p-8 rounded-3xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Mudah Digunakan</h3>
                        <p class="text-slate-500 leading-relaxed">Antarmuka yang ramah pengguna memudahkan staff medis dan pasien dalam berinteraksi.</p>
                     </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-600 rounded-full blur-3xl opacity-20"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold mb-6">Siap Meningkatkan Layanan Kesehatan?</h2>
            <p class="text-slate-300 text-lg mb-10 max-w-2xl mx-auto">Kami berkomitmen memberikan pelayanan terbaik dengan dukungan teknologi terkini demi kesehatan masyarakat Indonesia.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-slate-900 font-bold rounded-xl hover:bg-slate-100 transition shadow-lg">Login Petugas</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-600 rounded-xl text-white">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        </div>
                        <span class="text-2xl font-bold text-slate-900 tracking-tight">{{ $pengaturan['nama_aplikasi'] }}</span>
                    </div>
                    <p class="text-slate-500 leading-relaxed mb-6 max-w-md">
                        {{ $pengaturan['deskripsi'] }}
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-blue-600 hover:text-white transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-blue-600 hover:text-white transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.072 3.269.156 5.023 1.938 5.179 5.206.06 1.265.072 1.644.072 4.85s-.012 3.584-.072 4.85c-.156 3.268-1.91 5.049-5.179 5.206-1.265.06-1.644.072-4.85.072-3.204 0-3.584-.012-4.85-.072-3.269-.156-5.023-1.938-5.179-5.206-.06-1.265-.072-1.644-.072-4.85s.012-3.584.072-4.85c.156-3.268 1.91-5.049 5.179-5.206 1.265-.06 1.644-.072 4.85-.072zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6">Tautan Cepat</h4>
                    <ul class="space-y-4 text-sm text-slate-500">
                        <li><a href="#beranda" class="hover:text-blue-600 transition-colors">Beranda</a></li>
                        <li><a href="#layanan" class="hover:text-blue-600 transition-colors">Layanan Poli</a></li>
                        <li><a href="#keunggulan" class="hover:text-blue-600 transition-colors">Fasilitas</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-600 transition-colors">Login Staff</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6">Kontak Kami</h4>
                    <ul class="space-y-4 text-sm text-slate-500">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span>{{ $pengaturan['alamat'] }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span>{{ $pengaturan['telepon'] }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span>{{ $pengaturan['email'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-sm text-slate-400">
                    &copy; {{ date('Y') }} {{ $pengaturan['nama_aplikasi'] }}. Hak Cipta Dilindungi Undang-undang.
                </div>
                <div class="text-sm text-slate-400">
                    Dikembangkan dengan ❤️ untuk Indonesia Sehat
                </div>
            </div>
        </div>
    </footer>
</body>
</html>