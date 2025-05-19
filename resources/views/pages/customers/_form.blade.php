<div class="space-y-4">
    <div>
        <label class="block text-sm mb-1">Full Name</label>
        <input type="text" name="name" value="{{ old('name', $customer->name ?? '') }}"
            class="w-full border-gray-300 rounded px-3 py-2">
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $customer->email ?? '') }}"
            class="w-full border-gray-300 rounded px-3 py-2">
        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $customer->phone ?? '') }}"
            class="w-full border-gray-300 rounded px-3 py-2">
        @error('phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Country</label>
        <input type="text" name="country" value="{{ old('country', $customer->country ?? '') }}"
            class="w-full border-gray-300 rounded px-3 py-2">
        @error('country') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Notes</label>
        <textarea name="notes" rows="3"
            class="w-full border-gray-300 rounded px-3 py-2">{{ old('notes', $customer->notes ?? '') }}</textarea>
        @error('notes') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">{{ $submit }}</button>
        <a href="{{ route('customers.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
    </div>
</div>
