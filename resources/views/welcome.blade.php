<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $app_settings['app_name'] ?? config('app.name') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-gray-50 text-slate-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm fixed w-full z-10 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="bg-teal-600 text-white p-2 rounded-lg shadow-md">
                        <!-- Heroicon: Shield Check -->
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-teal-700 uppercase tracking-tight">SATRIA</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-teal-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-teal-500">Dashboard</a>
                        @else
                            <a href="{{ route('antrean.monitor') }}" class="font-semibold text-gray-600 hover:text-teal-600 hidden md:block">Monitor Antrean</a>
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-teal-600 text-white rounded-md font-semibold hover:bg-teal-700 transition">Log in</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-12 bg-gradient-to-br from-teal-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-4">
                    Layanan Kesehatan <br> <span class="text-teal-600">Terintegrasi & Paripurna</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Selamat datang di <strong>SATRIA</strong> (Sistem Administrasi Terintegrasi Kesehatan Indonesia). Solusi kesehatan digital yang menghubungkan pasien, tenaga medis, dan fasilitas kesehatan dalam satu ekosistem yang efisien.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('antrean.monitor') }}" class="px-6 py-3 bg-teal-600 text-white font-bold rounded-lg shadow-lg hover:bg-teal-700 transition text-center">
                        Lihat Antrean Live
                    </a>
                    <a href="#layanan" class="px-6 py-3 bg-white text-teal-600 font-bold rounded-lg shadow border border-teal-100 hover:bg-gray-50 transition text-center">
                        Info Layanan
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <!-- Illustration Placeholder -->
                <div class="relative w-80 h-80 bg-teal-100 rounded-full flex items-center justify-center shadow-inner">
                    <svg class="w-40 h-40 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    <div class="absolute -bottom-4 -right-4 bg-white p-4 rounded-xl shadow-lg border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 p-2 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Status Pelayanan</p>
                                <p class="font-bold text-gray-800">BUKA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Layanan Kami</h2>
                <p class="text-gray-500 mt-2">Berbagai poli layanan kesehatan tersedia untuk Anda.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Poli Umum -->
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Poli Umum</h3>
                    <p class="text-gray-600 text-sm">Pemeriksaan kesehatan dasar, pengobatan penyakit umum, dan rujukan.</p>
                </div>

                <!-- Poli Gigi -->
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Poli Gigi</h3>
                    <p class="text-gray-600 text-sm">Pemeriksaan gigi, tambal, cabut gigi, dan pembersihan karang gigi.</p>
                </div>

                <!-- Poli KIA -->
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Poli KIA</h3>
                    <p class="text-gray-600 text-sm">Kesehatan Ibu dan Anak, Imunisasi, KB, dan pemeriksaan kehamilan.</p>
                </div>

                <!-- Farmasi -->
                <div class="p-6 bg-gray-50 rounded-xl hover:shadow-md transition border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Farmasi & Laboratorium</h3>
                    <p class="text-gray-600 text-sm">Layanan obat lengkap dan pemeriksaan laboratorium dasar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} {{ $app_settings['app_name'] ?? 'Puskesmas Jagakarsa' }}. All rights reserved.</p>
            <p class="text-sm mt-2">{{ $app_settings['app_address'] ?? 'Jl. Jagakarsa Raya No. 1' }} | Telp: {{ $app_settings['app_phone'] ?? '-' }}</p>
        </div>
    </footer>
</body>
</html>