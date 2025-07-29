<x-app-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Motivational Quotes</h2>
            <a href="{{ route('quotes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Quote</a>
        </div>

        @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
        @endif

        <table class="w-full table-auto border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Quote</th>
                    <th class="p-2 text-left">Background Image</th>
                    <th class="p-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotes as $quote)
                <tr class="border-t">
                    <td class="p-2 text-gray-800">{{ $quote->text }}</td>

                    <td class="p-2">
                        @if ($quote->backgroundImage)
                        @php
                        $path = public_path(parse_url($quote->backgroundImage, PHP_URL_PATH));
                        $sizeKB = file_exists($path) ? round(filesize($path) / 1024, 2) : null;
                        @endphp

                        <div class="flex items-center space-x-2">
                            @if ($sizeKB)
                            <span class="text-xs text-gray-500">{{ $sizeKB }} KB</span>
                            @else
                            <span class="text-xs text-red-500 italic">Size unknown</span>
                            @endif

                            <img src="{{ $quote->backgroundImage }}" alt="Background" class="h-20 w-auto rounded shadow" />
                        </div>
                        @else
                        <span class="text-gray-400 italic">No image</span>
                        @endif
                    </td>


                    <td class="p-2 text-center">
                        <a href="{{ route('quotes.edit', $quote) }}" class="text-blue-600 hover:underline mr-4">Edit</a>
                        <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this quote?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="mt-4">{{ $quotes->links() }}</div>
    </div>
</x-app-layout>