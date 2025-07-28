@php $ranker = $topRanker ?? null; @endphp

<div class="mb-4">
    <label class="block text-sm font-medium">Agent Name</label>
    <input type="text" name="agent" class="w-full border p-2 rounded" value="{{ old('agent', $ranker->agent ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium">Folder Count</label>
    <input type="number" name="folder_count" class="w-full border p-2 rounded" value="{{ old('folder_count', $ranker->folder_count ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium">Profit (in pence)</label>
    <input type="number" name="profit" class="w-full border p-2 rounded" value="{{ old('profit', $ranker->profit ?? '') }}" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium">Trend</label>
    <select name="trend" class="w-full border p-2 rounded" required>
        @foreach(['up', 'down', 'stable'] as $option)
            <option value="{{ $option }}" @if(old('trend', $ranker->trend ?? '') === $option) selected @endif>
                {{ ucfirst($option) }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium">Global Rank</label>
    <input type="number" name="global_rank" class="w-full border p-2 rounded" value="{{ old('global_rank', $ranker->global_rank ?? '') }}">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium">Agent Image</label>
    <input type="file" name="image" class="w-full border p-2 rounded">
    @if($ranker && $ranker->image)
        <img src="{{ $ranker->image }}" class="mt-2 h-20 rounded">
    @endif
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
