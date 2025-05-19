<x-app-layout>
    <h1 class="text-2xl font-semibold mb-4">Edit User</h1>

    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6 max-w-lg">
        @csrf @method('PUT')
        @include('pages.users._form', ['submit' => 'Update User'])
    </form>
</x-app-layout>
