<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        $user->load('trip', 'trip.documents');

        // Example dummy trip (replace with real DB data)
        $trip = [
            'id' => $user->trip->id,
            'user_id' => $user->trip->user_id,
            'title' => $user->trip->title,
            'location' => $user->trip->location,
            'start_date' => $user->trip->start_date,
            'end_date' =>   $user->trip->end_date,
            'description' => $user->trip->description,
            'created_at' => $user->trip->created_at,
            'updated_at' => $user->trip->updated_at,
        ];

        $documents = [
            'Flight Tickets' => count($user->trip->documents->where('type', 'Flight Tickets')->all()) > 0 ? true : false,
            'Excursion Vouchers' => $user->trip->documents->where('type', 'Excursion Vouchers')->all(),
            'Hotel Vouchers' => $user->trip->documents->where('type', 'Hotel Vouchers')->all(),
            'Transfer Vouchers' => $user->trip->documents->where('type', 'Transfer Vouchers')->all(),
            'Railway Tickets' => $user->trip->documents->where('type', 'Railway Tickets')->all(),
            'Cruise Tickets' => $user->trip->documents->where('type', 'Cruise Tickets')->all(),
            'Park Tickets' => $user->trip->documents->where('type', 'Park Tickets')->all(),
        ];


        return response()->json([
            'name' => $user->name,
            'user' => $user,
            'trip' => $trip,
            'documents' => $documents,
        ]);
    }
}
