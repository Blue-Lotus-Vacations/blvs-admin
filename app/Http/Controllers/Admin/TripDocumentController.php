<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TripDocumentController extends Controller
{
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
