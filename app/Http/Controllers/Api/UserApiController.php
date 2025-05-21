<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        // Example dummy trip (replace with real DB data)
        $trip = [
            'title' => 'Trip to Singapore',
            'start_date' => '2025-06-10',
            'end_date' => '2025-06-17',
        ];

        $documents = [
            'visa' => true,
            'tickets' => true,
            'hotels' => false,
            'insurance' => true,
            'itinerary' => true,
            'emergency_contacts' => true,
            'medical_info' => false,
        ];

        return response()->json([
            'name' => $user->name,
            'trip' => $trip,
            'documents' => $documents,
        ]);
    }
}
