<x-layout.admin>
    <h1 class="text-2xl font-semibold mb-4">Add New User</h1>

    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6 max-w-lg">
        @csrf
        @include('pages.users._form', ['submit' => 'Create User'])
    </form>
</x-layout.admin>
