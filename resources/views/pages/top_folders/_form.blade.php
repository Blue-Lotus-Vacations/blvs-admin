<!-- resources/views/pages/top-folders/_form.blade.php -->
@csrf
<div class="mb-4">
    <label class="block font-medium">Agent Name</label>
    <input type="text" name="agent" value="{{ old('agent', $topFolder->agent ?? '') }}" required class="w-full border rounded p-2">
</div>

<div class="mb-4">
    <label class="block font-medium">Folder Count</label>
    <input type="number" name="folder_count" value="{{ old('folder_count', $topFolder->folder_count ?? 0) }}" required class="w-full border rounded p-2">
</div>

<div class="mb-4">
    <label class="block font-medium">Trend</label>
    <select name="trend" class="w-full border rounded p-2">
        @foreach(['up', 'down', 'stable'] as $option)
            <option value="{{ $option }}" @selected(old('trend', $topFolder->trend ?? '') == $option)>
                {{ ucfirst($option) }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block font-medium">Global Rank</label>
    <input type="number" name="global_rank" value="{{ old('global_rank', $topFolder->global_rank ?? '') }}" class="w-full border rounded p-2">
</div>

<div class="mb-4">
    <label class="block font-medium">Image</label>
    <input type="file" name="image" class="w-full border p-2 rounded">
    @if (!empty($topFolder->image))
        <img src="{{ asset('storage/' . $topFolder->image) }}" alt="" class="mt-2 w-32 h-auto">
    @endif
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
