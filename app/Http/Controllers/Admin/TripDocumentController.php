<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\TripDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TripDocumentController extends Controller
{

    public function docs(Request $request, Trip $trip)
    {
        $trip->load('documents');
        return view('pages.trips.docs.index', compact('trip'));
    }

    public function show(Trip $trip, TripDocument $document)
    {
        return view('pages.trips.docs.show', compact('trip', 'document'));
    }

    public function create(Request $request, Trip $trip)
    {
        return view('pages.trips.docs.create', compact('trip'));
    }

    public function store(Request $request, Trip $trip)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:8048',
        ]);

        // Store the file
        $path = $request->file('document')->store('trip_documents', 'public');

        $trip->documents()->create([
            'type' => $request->type,
            'file_path' => $path,
            'name' => $request->name,
            'description' => $request->description,
        ]);


        return redirect()->route('trips.docs', $trip)->with('success', 'Document uploaded successfully.');
    }

    public function edit(Trip $trip , TripDocument $document)
    {
        return view('pages.trips.docs.edit', compact('document' , 'trip'));
    }

    public function update(Request $request, Trip $trip, TripDocument $document)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|string|max:255',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:8048',
        ]);

        // Update the file if a new one is uploaded
        if ($request->hasFile('document')) {
            // Delete the old file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Store the new file
            $path = $request->file('document')->store('trip_documents', 'public');
            $document->file_path = $path;
        }

        $document->update([
            'type' => $request->type,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('trips.docs', $trip)->with('success', 'Document updated successfully.');
    }


    public function destroy($id)
    {
        $document = TripDocument::findOrFail($id);

        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}
