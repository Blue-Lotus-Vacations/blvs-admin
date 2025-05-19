<aside
    id="drawer-navigation"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0"
    aria-label="Sidebar"
>
    <div class="h-full px-4 py-6 overflow-y-auto bg-white">
        <ul class="space-y-2">

            @php
                $currentRoute = request()->route()->getName();
            @endphp

            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ $currentRoute === 'admin.dashboard' ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM4 10h12a6 6 0 11-12 0z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'admin.users') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zM4 14a6 6 0 1112 0H4z" />
                    </svg>
                    <span>Users</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.customers.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'admin.customers') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a5 5 0 015 5v2h1a1 1 0 011 1v4H3v-4a1 1 0 011-1h1V8a5 5 0 015-5z" />
                    </svg>
                    <span>Customers</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.trips.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'admin.trips') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 108 8 8 8 0 00-8-8zm-3 9V9h6v2z" />
                    </svg>
                    <span>Trips</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.documents.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'admin.documents') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a1 1 0 011-1h6l4 4v10a1 1 0 01-1 1H5a1 1 0 01-1-1z" />
                    </svg>
                    <span>Documents</span>
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h6v2H5v10h5v2H4a1 1 0 01-1-1V4z" />
                            <path d="M15 8l-3 3m0 0l3 3m-3-3h9" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
