<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::latest()->paginate(10);
        return view('pages.quotes.index', compact('quotes'));
    }

    public function create()
    {
        return view('pages.quotes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'backgroundImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('backgroundImage')) {
            $path = $request->file('backgroundImage')->store('quote-backgrounds', 'public');
        }

        Quote::create([
            'text' => $request->input('text'),
            'backgroundImage' => $path ? '/storage/' . $path : null,
        ]);

        return redirect()->route('quotes.index')->with('success', 'Quote added successfully.');
    }

    public function edit(Quote $quote)
    {
        return view('pages.quotes.edit', compact('quote'));
    }

    public function update(Request $request, Quote $quote)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'backgroundImage' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('backgroundImage')) {
            // delete old file if exists
            if ($quote->backgroundImage && file_exists(public_path($quote->backgroundImage))) {
                unlink(public_path($quote->backgroundImage));
            }

            $path = $request->file('backgroundImage')->store('quote-backgrounds', 'public');
            $quote->backgroundImage = '/storage/' . $path;
        }

        $quote->text = $request->input('text');
        $quote->save();

        return redirect()->route('quotes.index')->with('success', 'Quote updated.');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('quotes.index')->with('success', 'Quote deleted.');
    }
}
