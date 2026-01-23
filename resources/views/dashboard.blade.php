<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <!-- Welcome Banner -->
    <div class="relative bg-teal-600 rounded-xl shadow-lg mb-8 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-teal-700 to-teal-500 opacity-90"></div>
        <div class="relative p-8 flex items-center justify-between z-10">
            <div class="text-white">
                <h3 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-teal-100 text-lg">Sistem Administrasi Terintegrasi Kesehatan Indonesia (SATRIA) siap membantu pelayanan Anda.</p>
                <div class="mt-4 flex items-center gap-2">
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-semibold backdrop-blur-sm">
                        Role: {{ ucfirst(Auth::user()->role) }}
                    </span>
                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-semibold backdrop-blur-sm">
                        {{ \Carbon\Carbon::now()->format('H:i') }} WIB
                    </span>
                </div>
            </div>
            <div class="hidden md:block">
                <svg class="w-32 h-32 text-white/20 transform rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('info'))
        <div class="mb-6 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded shadow-sm" role="alert">
            <p class="font-bold">Info</p>
            <p>{{ session('info') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
            <p class="font-bold">Gagal!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Absensi Widget (Untuk Pegawai) -->
    @php
        $isPegawai = \App\Models\Pegawai::where('user_id', Auth::id())->exists();
        $jadwalHariIni = null;
        if($isPegawai) {
            $pegawai = \App\Models\Pegawai::where('user_id', Auth::id())->first();
            $jadwalHariIni = \App\Models\JadwalJaga::where('pegawai_id', $pegawai->id)
                            ->whereDate('tanggal', \Carbon\Carbon::today())
                            ->with('shift')
                            ->first();
        }
    @endphp

    @if($isPegawai && $jadwalHariIni)
    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-blue-100 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center mb-4 md:mb-0">
            <div class="p-3 bg-blue-100 rounded-full text-blue-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h4 class="text-lg font-bold text-gray-800">Jadwal Jaga Hari Ini</h4>
                <p class="text-gray-600">
                    Shift: <span class="font-semibold">{{ $jadwalHariIni->shift->nama_shift }}</span> 
                    ({{ $jadwalHariIni->shift->jam_mulai }} - {{ $jadwalHariIni->shift->jam_selesai }})
                </p>
                <p class="text-sm {{ $jadwalHariIni->status_kehadiran == 'Hadir' ? 'text-green-600 font-bold' : 'text-orange-500' }}">
                    Status: {{ $jadwalHariIni->status_kehadiran }}
                </p>
            </div>
        </div>
        <div>
            @if($jadwalHariIni->status_kehadiran != 'Hadir')
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition transform hover:scale-105">
                    Absen Masuk
                </button>
            </form>
            @else
            <button disabled class="bg-gray-300 text-gray-500 font-bold py-2 px-6 rounded-lg cursor-not-allowed">
                Sudah Absen
            </button>
            @endif
        </div>
    </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Pasien Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pasien</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPasien }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-full">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('pasien.index') }}" class="text-sm text-blue-600 font-medium hover:text-blue-800 flex items-center">
                    Lihat Data <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Antrean Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-teal-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Antrean Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $antreanHariIni }}</p>
                </div>
                <div class="p-3 bg-teal-50 rounded-full">
                    <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
            </div>
             <div class="mt-4">
                <a href="{{ route('antrean.index') }}" class="text-sm text-teal-600 font-medium hover:text-teal-800 flex items-center">
                    Kelola Antrean <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Obat Menipis Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Stok Kritis</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $obatMenipis }}</p>
                </div>
                <div class="p-3 bg-red-50 rounded-full">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div class="mt-4">
                 @if($obatMenipis > 0)
                    <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-1 rounded">Segera Restock!</span>
                @else
                    <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded">Stok Aman</span>
                @endif
            </div>
        </div>

        <!-- Surat Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Surat Masuk</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $suratMasuk }}</p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-full">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('surat.index') }}" class="text-sm text-indigo-600 font-medium hover:text-indigo-800 flex items-center">
                    Cek Arsip <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <h3 class="text-xl font-bold text-gray-800 mb-4">Akses Cepat</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        
        <a href="{{ route('antrean.index') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md hover:bg-teal-50 transition-all group">
            <div class="p-3 bg-teal-100 rounded-full mb-3 group-hover:bg-teal-200 transition-colors">
                <svg class="w-6 h-6 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-teal-700 text-center">Ambil Antrean</span>
        </a>

        <a href="{{ route('pasien.create') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md hover:bg-blue-50 transition-all group">
            <div class="p-3 bg-blue-100 rounded-full mb-3 group-hover:bg-blue-200 transition-colors">
                <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-700 text-center">Daftar Pasien</span>
        </a>

        <a href="{{ route('rekam-medis.create') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md hover:bg-purple-50 transition-all group">
            <div class="p-3 bg-purple-100 rounded-full mb-3 group-hover:bg-purple-200 transition-colors">
                <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-purple-700 text-center">Periksa Medis</span>
        </a>

         <a href="{{ route('obat.index') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md hover:bg-red-50 transition-all group">
            <div class="p-3 bg-red-100 rounded-full mb-3 group-hover:bg-red-200 transition-colors">
                <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-red-700 text-center">Cek Stok</span>
        </a>

    </div>
</x-app-layout>
