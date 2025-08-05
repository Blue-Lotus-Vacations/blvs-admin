@include('layouts.navigation')
<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 bg-white border-r border-gray-200
           transition-transform duration-300 ease-in-out"
    x-cloak>
    <div class="h-full px-4 py-6 overflow-y-auto bg-white">
        <ul class="space-y-2">

            @php
            $currentRoute = request()->route()->getName();
            @endphp

            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ $currentRoute === 'dashboard' ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM4 10h12a6 6 0 11-12 0z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('users.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'users') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zM4 14a6 6 0 1112 0H4z" />
                    </svg>
                    <span>Users</span>
                </a>
            </li>

            <li>
                <a href="{{ route('call-logs.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'call-logs') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4l2 3h8a2 2 0 012 2v11a2 2 0 01-2 2z" />
                    </svg>
                    <span>Call Logs</span>
                </a>
            </li>

            <li>
                <a href="{{ route('trips.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'trips') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 108 8 8 8 0 00-8-8zm-3 9V9h6v2z" />
                    </svg>
                    <span>Trips</span>
                </a>
            </li>

            <li>
                <a href="{{ route('agents.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'agents') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zM4 14a6 6 0 1112 0H4z" />
                    </svg>
                    <span>Agents</span>
                </a>
            </li>

            <li>
                <a href="{{ route('agent-stats.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'agent-stats') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 7a3 3 0 11-6 0 3 3 0 016 0zM4 14a6 6 0 1112 0H4z" />
                    </svg>
                    <span>Agent Sales</span><!-- Agent Stats  -->
                </a>
            </li>


            <li>
                <a href="{{ route('quotes.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'quotes') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 108 8 8 8 0 00-8-8zm-3 9V9h6v2z" />
                    </svg>
                    <span>Quotes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('stat-slider-images.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 {{ str_starts_with($currentRoute, 'stat-slider-images') ? 'bg-gray-100 font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a8 8 0 108 8 8 8 0 00-8-8zm-3 9V9h6v2z" />
                    </svg>
                    <span>Slider Images</span>
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