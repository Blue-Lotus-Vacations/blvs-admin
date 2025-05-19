<nav class="bg-white border-b border-gray-200 px-4 py-2.5 fixed left-0 right-0 top-0 z-50">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-2">
            <!-- Sidebar Toggle -->
            <button
                data-drawer-target="drawer-navigation"
                data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 text-gray-600 rounded-lg md:hidden hover:bg-gray-100 focus:ring-2 focus:ring-gray-200"
            >
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        fill-rule="evenodd"
                        d="M3 5h14a1 1 0 110 2H3a1 1 0 010-2zm0 5h14a1 1 0 110 2H3a1 1 0 010-2zm0 5h14a1 1 0 110 2H3a1 1 0 010-2z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                <span class="sr-only">Toggle sidebar</span>
            </button>

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <img src="/logo.svg" class="h-8 mr-2" alt="BLOVA Logo">
                <span class="text-xl font-semibold">BLOVA Admin</span>
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
                    alt="User Avatar"
                />
            @endauth
        </div>
    </div>
</nav>
