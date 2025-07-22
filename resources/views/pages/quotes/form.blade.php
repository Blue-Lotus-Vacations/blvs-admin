@csrf
<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Quote Text</label>
    <textarea name="text" rows="4" class="w-full border p-2 rounded" required>{{ old('text', $quote->text ?? '') }}</textarea>
</div>

<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
