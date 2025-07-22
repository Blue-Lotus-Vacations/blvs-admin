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
        $request->validate(['text' => 'required|string|max:500']);
        Quote::create($request->only('text'));

        return redirect()->route('quotes.index')->with('success', 'Quote added successfully.');
    }

    public function edit(Quote $quote)
    {
        return view('pages.quotes.edit', compact('quote'));
    }

    public function update(Request $request, Quote $quote)
    {
        $request->validate(['text' => 'required|string|max:500']);
        $quote->update($request->only('text'));

        return redirect()->route('quotes.index')->with('success', 'Quote updated.');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('quotes.index')->with('success', 'Quote deleted.');
    }
}
