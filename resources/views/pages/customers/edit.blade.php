<x-app-layout>
<h1 class="text-2xl font-semibold mb-4">Edit Customer</h1>

<form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-6 max-w-xl">
    @csrf @method('PUT')
    @include('pages.customers._form', ['submit' => 'Update Customer'])
</form>
</x-app-layout>
