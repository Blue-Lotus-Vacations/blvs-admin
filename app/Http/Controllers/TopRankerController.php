<?php

namespace App\Http\Controllers;

use App\Models\TopRanker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TopRankerController extends Controller
{
    public function index()
    {
        $rankers = TopRanker::orderBy('global_rank')->limit(5)->get();
        return view('pages.top_rankers.index', compact('rankers'));
    }

    public function create()
    {
        return view('pages.top_rankers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'agent' => 'required|string|max:255',
            'folder_count' => 'required|integer',
            'profit' => 'required|integer',
            'trend' => 'required|in:up,down,stable',
            'global_rank' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['agent', 'folder_count', 'profit', 'trend', 'global_rank']);

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('top-rankers', 'public');
        }

        TopRanker::create($data);
        return redirect()->route('top-rankers.index')->with('success', 'Top ranker added.');
    }

    public function edit(TopRanker $topRanker)
    {
        return view('pages.top_rankers.edit', compact('topRanker'));
    }

    public function update(Request $request, TopRanker $topRanker)
    {
        $request->validate([
            'agent' => 'required|string|max:255',
            'folder_count' => 'required|integer',
            'profit' => 'required|integer',
            'trend' => 'required|in:up,down,stable',
            'global_rank' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['agent', 'folder_count', 'profit', 'trend', 'global_rank']);

        if ($request->hasFile('image')) {
            if ($topRanker->image && file_exists(public_path($topRanker->image))) {
                unlink(public_path($topRanker->image));
            }
            $data['image'] = '/storage/' . $request->file('image')->store('top-rankers', 'public');
        }

        $topRanker->update($data);
        return redirect()->route('top-rankers.index')->with('success', 'Top ranker updated.');
    }

    public function destroy(TopRanker $topRanker)
    {
        if ($topRanker->image && file_exists(public_path($topRanker->image))) {
            unlink(public_path($topRanker->image));
        }

        $topRanker->delete();
        return redirect()->route('top-rankers.index')->with('success', 'Top ranker deleted.');
    }
}
