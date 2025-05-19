<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Customers</h1>
        <a href="{{ route('customers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Customer</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Phone</th>
                <th class="p-3 text-left">Country</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr class="border-t">
                    <td class="p-3">{{ $customer->name }}</td>
                    <td class="p-3">{{ $customer->email }}</td>
                    <td class="p-3">{{ $customer->phone }}</td>
                    <td class="p-3">{{ $customer->country }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('customers.edit', $customer) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('customers.destroy', $customer) }}">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this customer?')" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-3">No customers found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $customers->links() }}</div>
</x-app-layout>
