<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center justify-between">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold text-gray-900">Users</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all users in your system including their name, email, and role.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('users.create') }}" class="inline-block rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                    Add User
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="mt-4 bg-green-100 text-green-800 p-3 rounded shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                <th class="relative py-3.5 pl-3 pr-4 sm:pr-0 text-right">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($users as $user)
                            <tr>
                                <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                    <div class="flex items-center">
                                        <div class="size-10 shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff" alt="{{ $user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="mt-1 text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-700">
                                    {{ $user->email }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-700">
                                    {{ $user->is_admin ? 'Admin' : 'Staff' }}
                                </td>
                                <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>