@csrf
@php $agent = $agent ?? null; @endphp

<div class="mb-4">
    <label class="block text-sm font-medium">Agent Name</label>
    <input type="text" name="name" value="{{ old('name', $agent->name ?? '') }}" class="w-full border p-2 rounded" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium">Agent Image</label>
    <input type="file" name="image" class="w-full border p-2 rounded">
    @if($agent && $agent->image)
        <img src="{{ $agent->image }}" class="mt-2 h-20 rounded">
    @endif
</div>


<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
