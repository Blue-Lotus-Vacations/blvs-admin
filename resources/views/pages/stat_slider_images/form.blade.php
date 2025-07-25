@csrf

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Image</label>
    <input type="file" name="image" class="w-full border p-2 rounded" {{ isset($statSliderImage) ? '' : 'required' }}>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Alt Text</label>
    <input type="text" name="alt" class="w-full border p-2 rounded" value="{{ old('alt', $statSliderImage->alt ?? '') }}">
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Overlay Text</label>
    <input type="text" name="overlay_text" class="w-full border p-2 rounded" value="{{ old('overlay_text', $statSliderImage->overlay_text ?? '') }}">
</div>

<button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
