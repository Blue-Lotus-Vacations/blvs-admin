<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Create New Trip</h2>

        <form action="{{ route('trips.store') }}" method="POST" enctype="multipart/form-data">



            @csrf
            <div>
                <label class="block font-medium text-sm text-gray-700">User</label>
                <select name="user_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    @foreach($users as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Title</label>
                <input type="text" name="title" class="mt-1 block w-full rounded border-gray-300 shadow-sm" value="{{ old('title') }}">
                @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-medium text-sm text-gray-700">Start Date</label>
                    <input type="date" name="start_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm" value="{{ old('start_date') }}">
                    @error('start_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="w-1/2">
                    <label class="block font-medium text-sm text-gray-700">End Date</label>
                    <input type="date" name="end_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm" value="{{ old('end_date') }}">
                    @error('end_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <div>
                <label class="block font-medium text-sm text-gray-700">Location</label>
                <input type="text" name="location" class="mt-1 block w-full rounded border-gray-300 shadow-sm" value="{{ old('location') }}">
                @error('location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block font-medium text-sm text-gray-700">Description (optional)</label>
                <textarea name="description" class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium mb-2">Trip Documents</h3>

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

                @foreach ($documentTypes as $type)
                <label class="block font-medium text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $type)) }}</label>
                <input
                    type="file"
                    name="documents[{{ $type }}][]"
                    multiple
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                @endforeach

            </div>



            <div class="flex justify-end">
                <a href="{{ route('trips.index') }}" class="mr-3 text-gray-600 hover:underline">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Trip</button>
            </div>
        </form>
    </div>


</x-app-layout>