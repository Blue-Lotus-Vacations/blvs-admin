<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Agents</h2>
            <a href="{{ route('agents.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Agent</a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full table-auto border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Agent</th>
                    <th class="p-2 text-left">Image</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agents as $agent)
                    <tr class="border-t">
                        <td class="p-2">{{ $agent->name }}</td>
                        <td class="p-2">
                        @if ($agent->image)
                            <img src="{{ $agent->image }}" class="h-16 rounded" />
                        @else
                            <span class="text-gray-400 italic">No image</span>
                        @endif
                        </td>
                        <td class="p-2 flex gap-2">
                            <a href="{{ route('agents.edit', $agent) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('agents.destroy', $agent) }}" method="POST" onsubmit="return confirm('Delete this agent?');">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
