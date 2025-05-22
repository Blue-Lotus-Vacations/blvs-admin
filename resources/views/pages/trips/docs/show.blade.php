<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Document Details</h2>

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

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name:</label>
            <p class="text-gray-800">{{ $document->name }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Document Type:</label>
            <p class="text-gray-800">{{ $documentTypes[$document->type] ?? ucfirst($document->type) }}</p>
        </div>

        @if($document->description)
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description:</label>
            <p class="text-gray-800">{{ $document->description }}</p>
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Uploaded Document:</label>
            @if($document->file_path)
                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                    View Document
                </a>
            @else
                <p class="text-gray-500">No document uploaded.</p>
            @endif
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('trips.docs', $trip) }}" class="text-gray-600 hover:underline">Back to Documents</a>
            <a href="{{ route('trips.documents.edit', [$trip, $document]) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
        </div>
    </div>
</x-app-layout>
