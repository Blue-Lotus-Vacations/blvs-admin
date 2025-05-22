<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Documents </h1>
            <a href="{{ route('trips.documents.create' , $trip ) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Upload New Document
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
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">File Type</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @foreach($trip->documents as $tripdoc)
                    <tr>
                        <td class="px-6 py-4">{{ $tripdoc->name }}</td>
                        <td class="px-6 py-4">{{ $tripdoc->description }}</td>
                        <td class="px-6 py-4">{{ $tripdoc->type }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('trips.documents.show', [$trip , $tripdoc]) }}" class="text-green-600 hover:underline mr-3">view</a>

                            <a href="{{ route('trips.documents.edit',[ $trip ,$tripdoc]) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <form action="{{ route('trip.documents.destroy', $tripdoc->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    @if($trip->documents->isEmpty())
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No Docs found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>