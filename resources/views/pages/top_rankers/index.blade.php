<x-app-layout>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Top Rankers</h2>

        <a href="{{ route('top-rankers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Add Ranker</a>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Agent</th>
                    <th class="p-2">Folder</th>
                    <th class="p-2">Profit (£)</th>
                    <th class="p-2">Trend</th>
                    <th class="p-2">Rank</th>
                    <th class="p-2">Image</th>
                    <th class="p-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rankers as $r)
                <tr class="border-t">
                    <td class="p-2">{{ $r->agent }}</td>
                    <td class="p-2">{{ $r->folder_count }}</td>
                    <td class="p-2">£{{ number_format($r->profit / 100, 2) }}</td>
                    <td class="p-2 capitalize">{{ $r->trend }}</td>
                    <td class="p-2">{{ $r->global_rank }}</td>
                    <td class="p-2">
                        @if ($r->image)
                            <img src="{{ $r->image }}" class="h-16 rounded" />
                        @else
                            <span class="text-gray-400 italic">No image</span>
                        @endif
                    </td>
                    <td class="p-2 text-center">
                        <a href="{{ route('top-rankers.edit', $r) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('top-rankers.destroy', $r) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this ranker?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
