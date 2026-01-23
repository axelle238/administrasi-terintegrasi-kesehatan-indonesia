<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') === 'true',
          sidebarOpen: false,
          toggleDarkMode() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('darkMode', this.darkMode);
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
      x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SATRIA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css'])
        @livewireStyles
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }
            
            /* Custom Scrollbar for Sidebar */
            .sidebar-scroll::-webkit-scrollbar {
                width: 6px;
            }
            .sidebar-scroll::-webkit-scrollbar-track {
                background: transparent;
            }
            .sidebar-scroll::-webkit-scrollbar-thumb {
                background-color: rgba(156, 163, 175, 0.5);
                border-radius: 20px;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 dark:bg-gray-900 text-slate-800 dark:text-gray-100 transition-colors duration-300">
        
        <div class="flex h-screen overflow-hidden bg-slate-50 dark:bg-gray-900">
            
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex flex-col flex-1 w-0 overflow-hidden">
                
                <!-- Topbar (Fixed at top of content area) -->
                @include('layouts.topbar')

                <!-- Scrollable Body -->
                <div class="flex-1 overflow-y-auto focus:outline-none sidebar-scroll">
                    
                    <div class="flex flex-col min-h-full">
                        <!-- Main Content -->
                        <main class="w-full grow p-4 md:p-8">
                            @if (isset($header))
                                <!-- Mobile Header (Visible only on small screens) -->
                                <div class="md:hidden mb-6 flex justify-between items-center">
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $header }}</h2>
                                </div>
                            @endif

                            {{ $slot }}
                        </main>

                        <!-- Footer -->
                        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 p-4 px-8 text-center md:text-left text-xs text-gray-500 dark:text-gray-400 flex flex-col md:flex-row justify-between items-center gap-2 mt-auto transition-colors duration-300">
                            <div>
                                &copy; {{ date('Y') }} <span class="font-semibold text-teal-600 dark:text-teal-400">SATRIA</span>. 
                                Sistem Administrasi Terintegrasi Kesehatan Indonesia.
                            </div>
                            <div class="flex items-center gap-4">
                                <span>v2.0.0</span>
                                <span class="hidden md:inline text-gray-300 dark:text-gray-600">|</span>
                                <span class="font-medium uppercase tracking-wider text-[10px] text-teal-600 dark:text-teal-400">Terintegrasi & Paripurna</span>
                            </div>
                        </footer>
                    </div>

                </div>
            </div>
        </div>

        <livewire:components.toast-notification />
        
        <!-- Scripts -->
        @vite(['resources/js/app.js'])
        @livewireScripts
    </body>
</html>