<x-app-layout>
<div class="px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Trips</h1>
        <a href="{{ route('trips.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + New Trip
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Start Date</th>
                    <th class="px-6 py-3">End Date</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @foreach($trips as $trip)
                    <tr>
                        <td class="px-6 py-4">{{ $trip->id }}</td>
                        <td class="px-6 py-4">{{ $trip->title }}</td>
                        <td class="px-6 py-4">{{ $trip->user->name }}</td>
                        <td class="px-6 py-4">{{ $trip->start_date }}</td>
                        <td class="px-6 py-4">{{ $trip->end_date }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('trips.edit', $trip) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <form action="{{ route('trips.destroy', $trip) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($trips->isEmpty())
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No trips found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $trips->links() }}
    </div>
</div>
</x-app-layout>
