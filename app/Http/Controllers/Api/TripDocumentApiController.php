<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TripDocumentApiController extends Controller
{
    public function getDocumentsByType(Request $request)
    {
        $type = $request->type;
        $user = $request->user();

    
        $documents = $user->trip()
            ->with(['documents' => function ($query) use ($type) {
                $query->where('type', $type);
            }])
            ->get()
            ->pluck('documents')
            ->flatten()
            ->values();
    
        return response()->json($documents, 200);
    }
}
