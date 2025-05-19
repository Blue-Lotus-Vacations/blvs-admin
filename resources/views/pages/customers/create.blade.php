<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">Add New Customer</h1>

<form method="POST" action="{{ route('customers.store') }}" class="space-y-6 max-w-xl">
    @csrf
    @include('pages.customers._form', ['submit' => 'Create Customer'])
</form>
</x-app-layout>
