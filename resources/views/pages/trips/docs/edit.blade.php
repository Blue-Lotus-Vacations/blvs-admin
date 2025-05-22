<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Document</h2>

        @php
        $documentTypes = [
            'flight_ticket' => 'Flight Tickets',
            'excursion_voucher' => 'Excursion Vouchers',
            'hotel_voucher' => 'Hotel Vouchers',
            'transfer_voucher' => 'Transfer Vouchers',
            'railway_ticket' => 'Railway Tickets',
            'cruise_ticket' => 'Cruise Tickets',
            'park_ticket' => 'Park Tickets',
        ];
        @endphp

        <form action="{{ route('trips.documents.update', [$trip, $document]) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-sm text-gray-700">Name</label>
                <input type="text" name="name" class="mt-1 block w-full rounded border-gray-300 shadow-sm"
                    value="{{ old('name', $document->name) }}">
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-medium text-sm text-gray-700">Doc Type</label>
                    <select name="type" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option disabled value="">Select Document Type</option>
                        @foreach($documentTypes as $key => $label)
                            <option value="{{ $label }}" {{ old('type', $document->type) === $label ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Description (optional)</label>
                <textarea name="description" class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('description', $document->description) }}</textarea>
                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Replace Document (optional)</label>
                <input
                    type="file"
                    name="document"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                @error('document') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                @if($document->file_path)
                    <p class="mt-2 text-sm text-gray-600">
                        Current file: <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-600 hover:underline">View document</a>
                    </p>
                @endif
            </div>

            <div class="flex justify-end">
                <a href="{{ route('trips.show', $trip) }}" class="mr-3 text-gray-600 hover:underline">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Document</button>
            </div>
        </form>
    </div>
</x-app-layout>
