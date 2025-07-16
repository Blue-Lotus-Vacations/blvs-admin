<nav class="bg-white border-b border-gray-200 px-4 py-2.5 fixed left-0 right-0 top-0 z-50">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-2">
            <!-- Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen"
                class=" top-4 left-4 z-50 bg-white p-2 rounded-lg shadow-md focus:outline-none">
                <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center ml-2">
                <img src="{{ asset('assets/logo.png') }}" class="h-8 mr-2" alt="BLVS Admin">
                <span class="text-xl font-semibold">BLVS Admin Panel</span>
            </a>
        </div>

        <!-- User Info -->
        <div class="flex items-center space-x-4">
            @auth
            <div class="text-right">
                <div class="text-sm font-semibold">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <img
                class="w-8 h-8 rounded-full"
                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                alt="User Avatar" />
            @endauth
        </div>
    </div>
</nav>