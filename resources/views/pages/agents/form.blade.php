@csrf
<div class="mb-4">
    <label class="block text-sm font-medium">Agent Name</label>
    <input type="text" name="name" value="{{ old('name', $agent->name ?? '') }}" class="w-full border p-2 rounded" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium">Folder Count</label>
    <input type="number" name="folder_count" value="{{ old('folder_count', $agent->folder_count ?? 0) }}" class="w-full border p-2 rounded" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium">Profit (in pence)</label>
    <input type="number" name="profit" value="{{ old('profit', $agent->profit ?? 0) }}" class="w-full border p-2 rounded" required>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium">Trend</label>
    <select name="trend" class="w-full border p-2 rounded">
        <option value="">Stable</option>
        <option value="up" {{ old('trend', $agent->trend ?? '') == 'up' ? 'selected' : '' }}>Up</option>
        <option value="down" {{ old('trend', $agent->trend ?? '') == 'down' ? 'selected' : '' }}>Down</option>
    </select>
</div>

<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
