<div class="space-y-4">
    <div>
        <label class="block text-sm mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
               class="w-full border-gray-300 rounded px-3 py-2">
        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
               class="w-full border-gray-300 rounded px-3 py-2">
        @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm mb-1">Password</label>
        <input type="password" name="password"
               class="w-full border-gray-300 rounded px-3 py-2" {{ isset($user) ? '' : 'required' }}>
        @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_admin" id="is_admin"
               {{ old('is_admin', $user->is_admin ?? false) ? 'checked' : '' }}>
        <label for="is_admin" class="text-sm">Is Admin</label>
    </div>

    <div>
        <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">{{ $submit }}</button>
        <a href="{{ route('admin.users.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
    </div>
</div>
