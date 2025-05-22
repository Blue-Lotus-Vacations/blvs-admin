<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Trip</h2>

        {{-- Update Form --}}
        <form id="trip-update-form" action="{{ route('trips.update', $trip->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-sm text-gray-700">User</label>
                <select name="user_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    @foreach($users as $id => $name)
                    <option value="{{ $id }}" {{ $trip->user_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Title</label>
                <input type="text" name="title" value="{{ old('title', $trip->title) }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label class="block font-medium text-sm text-gray-700">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $trip->start_date) }}"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                    @error('start_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="w-1/2">
                    <label class="block font-medium text-sm text-gray-700">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $trip->end_date) }}"
                        class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                    @error('end_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Location</label>
                <input type="text" name="location" value="{{ old('location', $trip->location) }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                @error('location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Description (optional)</label>
                <textarea name="description" class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('description', $trip->description) }}</textarea>
                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

      

            {{-- Action Buttons --}}
            <div class="flex justify-end pt-4">
                <a href="{{ route('trips.index') }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Trip</button>
            </div>
        </form>
    </div>
    <script>
        document.querySelectorAll(".delete-doc-btn").forEach(button => {
            button.addEventListener("click", function() {
                const form = this.closest("form");
                if (confirm("Are you sure you want to delete this document?")) {
                    fetch(form.action, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": form.querySelector('input[name="_token"]').value,
                                "X-Requested-With": "XMLHttpRequest",
                                "Accept": "application/json"
                            },
                            body: new URLSearchParams(new FormData(form))
                        })
                        .then(res => {
                            if (res.ok) {
                                // Optionally remove the item from UI
                                form.parentElement.remove();
                            } else {
                                alert("Failed to delete.");
                            }
                        });
                }
            });
        });
    </script>

</x-app-layout>