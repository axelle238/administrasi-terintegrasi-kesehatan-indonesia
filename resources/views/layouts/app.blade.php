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
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css'])
        @livewireStyles
        
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            [x-cloak] { display: none !important; }
            
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background-color: rgba(156, 163, 175, 0.5);
                border-radius: 20px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background-color: rgba(107, 114, 128, 0.8);
            }
            
            .glass-card {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.5);
            }
            .dark .glass-card {
                background: rgba(17, 24, 39, 0.7);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-slate-800 dark:text-gray-100 transition-colors duration-300 selection:bg-teal-500 selection:text-white">
        
        <div class="flex h-screen overflow-hidden">
            
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex flex-col flex-1 w-0 overflow-hidden relative">
                
                <!-- Background Pattern -->
                <div class="absolute inset-0 z-0 pointer-events-none opacity-40 dark:opacity-20 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#334155_1px,transparent_1px)] [background-size:20px_20px]"></div>

                <!-- Topbar -->
                @include('layouts.topbar')

                <!-- Scrollable Body -->
                <div class="flex-1 overflow-y-auto focus:outline-none relative z-10 custom-scrollbar">
                    
                    <div class="flex flex-col min-h-full">
                        <!-- Main Content -->
                        <main class="w-full grow p-4 md:p-8 space-y-6">
                            @if (isset($header))
                                <!-- Mobile Header (Visible only on small screens if needed) -->
                                <div class="md:hidden mb-4 flex justify-between items-center">
                                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $header }}</h2>
                                </div>
                            @endif

                            {{ $slot }}
                        </main>

                        <!-- Footer -->
                        <footer class="mt-auto border-t border-gray-200 dark:border-gray-800 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm p-6">
                            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                <div>
                                    &copy; {{ date('Y') }} <span class="font-bold text-teal-600 dark:text-teal-400">SATRIA</span> Enterprise System.
                                </div>
                                <div class="flex items-center gap-6">
                                    <span class="hover:text-teal-500 cursor-pointer transition-colors">Documentation</span>
                                    <span class="hover:text-teal-500 cursor-pointer transition-colors">Support</span>
                                    <span class="font-mono bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">v2.1.0</span>
                                </div>
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