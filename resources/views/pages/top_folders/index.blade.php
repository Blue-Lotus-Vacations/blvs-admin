<x-app-layout>
    <div class=" mt-8">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-semibold">Top Folders</h1>
            <a href="{{ route('top-folders.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add</a>
        </div>

        <table class="w-full table-auto border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Agent</th>
                    <th class="p-2 text-left">Folder Count</th>
                    <th class="p-2 text-left">Trend</th>
                    <th class="p-2 text-left">Global Rank</th>
                    <th class="p-2 text-left">Image</th>
                    <th class="p-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topFolders as $topFolder)
                <tr class="border-t">
                    <td class="p-2">{{ $topFolder->agent }}</td>
                    <td class="p-2">{{ $topFolder->folder_count }}</td>
                    <td class="p-2">{{ ucfirst($topFolder->trend) }}</td>
                    <td class="p-2">{{ $topFolder->global_rank ?? '-' }}</td>
                    <td class="p-2">
                        @if($topFolder->image)
                        <img src="{{ asset('storage/' . $topFolder->image) }}" class="w-16 h-auto rounded">
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="p-2 text-center">
                        <a href="{{ route('top-folders.edit', $topFolder) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                        <form action="{{ route('top-folders.destroy', $topFolder) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>