<?php
namespace App\Http\Controllers;

use App\Models\StatSliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StatSliderImageController extends Controller
{
    public function index()
    {
        $images = StatSliderImage::latest()->paginate(10);
        return view('pages.stat_slider_images.index', compact('images'));
    }

    public function create()
    {
        return view('pages.stat_slider_images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt' => 'nullable|string|max:255',
            'overlay_text' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('images', 'public');

        StatSliderImage::create([
            'url' => '/storage/' . $path,
            'alt' => $request->alt,
            'overlay_text' => $request->overlay_text,
        ]);

        return redirect()->route('stat-slider-images.index')->with('success', 'Image uploaded successfully.');
    }

    public function edit(StatSliderImage $statSliderImage)
    {
        return view('pages.stat_slider_images.edit', compact('statSliderImage'));
    }

    public function update(Request $request, StatSliderImage $statSliderImage)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt' => 'nullable|string|max:255',
            'overlay_text' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Delete old file
            if ($statSliderImage->url && file_exists(public_path($statSliderImage->url))) {
                unlink(public_path($statSliderImage->url));
            }

            $path = $request->file('image')->store('images', 'public');
            $statSliderImage->url = '/storage/' . $path;
        }

        $statSliderImage->alt = $request->alt;
        $statSliderImage->overlay_text = $request->overlay_text;
        $statSliderImage->save();

        return redirect()->route('stat-slider-images.index')->with('success', 'Image updated successfully.');
    }

    public function destroy(StatSliderImage $statSliderImage)
    {
        if ($statSliderImage->url && file_exists(public_path($statSliderImage->url))) {
            unlink(public_path($statSliderImage->url));
        }

        $statSliderImage->delete();

        return redirect()->route('stat-slider-images.index')->with('success', 'Image deleted successfully.');
    }
}
