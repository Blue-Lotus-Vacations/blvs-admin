<?php 

// app/Http/Controllers/TopFolderController.php

namespace App\Http\Controllers;

use App\Models\TopFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TopFolderController extends Controller
{
    public function index()
    {
        $topFolders = TopFolder::orderBy('global_rank')->get();
        return view('pages.top_folders.index', compact('topFolders'));
    }

    public function create()
    {
        return view('pages.top_folders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agent' => 'required|string|max:255',
            'folder_count' => 'required|integer',
            'trend' => 'required|in:up,down,stable',
            'global_rank' => 'nullable|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('top-folders', 'public');
        }

        TopFolder::create($data);
        return redirect()->route('top-folders.index')->with('success', 'Top Folder added.');
    }

    public function edit(TopFolder $topFolder)
    {
        return view('pages.top_folders.edit', compact('topFolder'));
    }

    public function update(Request $request, TopFolder $topFolder)
    {
        $data = $request->validate([
            'agent' => 'required|string|max:255',
            'folder_count' => 'required|integer',
            'trend' => 'required|in:up,down,stable',
            'global_rank' => 'nullable|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($topFolder->image) Storage::disk('public')->delete($topFolder->image);
            $data['image'] = $request->file('image')->store('top-folders', 'public');
        }

        $topFolder->update($data);
        return redirect()->route('top-folders.index')->with('success', 'Top Folder updated.');
    }

    public function destroy(TopFolder $topFolder)
    {
        if ($topFolder->image) Storage::disk('public')->delete($topFolder->image);
        $topFolder->delete();
        return redirect()->route('top-folders.index')->with('success', 'Top Folder deleted.');
    }
}
