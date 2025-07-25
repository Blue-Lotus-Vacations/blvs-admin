<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Stat Slider Images</h2>
            <a href="{{ route('stat-slider-images.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Image</a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Preview</th>
                    <th class="p-2">Alt</th>
                    <th class="p-2">Overlay Text</th>
                    <th class="p-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $image)
                    <tr class="border-t">
                        <td class="p-2"><img src="{{ $image->url }}" alt="{{ $image->alt }}" class="h-20 w-auto rounded shadow" /></td>
                        <td class="p-2">{{ $image->alt }}</td>
                        <td class="p-2">{{ $image->overlay_text }}</td>
                        <td class="p-2 text-center">
                            <a href="{{ route('stat-slider-images.edit', $image) }}" class="text-blue-600 hover:underline mr-4">Edit</a>
                            <form method="POST" action="{{ route('stat-slider-images.destroy', $image) }}" class="inline-block" onsubmit="return confirm('Delete this image?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $images->links() }}</div>
    </div>
</x-app-layout>
