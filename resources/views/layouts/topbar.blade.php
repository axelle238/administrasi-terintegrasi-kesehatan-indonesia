<header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-teal-600 shadow-md">
    <div class="flex items-center">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none md:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <div class="relative mx-4 lg:mx-0 hidden md:block">
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">
                @if(isset($header))
                    {{ $header }}
                @else
                    Dashboard SATRIA
                @endif
            </h1>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <!-- Date Display (Enterprise Feature) -->
        <div class="hidden md:flex flex-col text-right mr-4">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Hari Ini</span>
            <span class="text-sm font-bold text-gray-700">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
        </div>

        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen" class="relative block w-10 h-10 overflow-hidden rounded-full shadow focus:outline-none border-2 border-teal-100 hover:border-teal-500 transition-colors">
                <div class="w-full h-full flex items-center justify-center bg-teal-600 text-white font-bold text-lg">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </button>

            <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

            <div x-show="dropdownOpen" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl py-1" style="display: none;">
                <div class="px-4 py-2 border-b">
                    <p class="text-sm text-gray-900 font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
                
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-600 hover:text-white">Profile</a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-teal-600 hover:text-white">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
