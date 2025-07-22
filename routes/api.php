<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TripDocumentApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->get('/user', [UserApiController::class, 'show']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//Trip Details Of a User
Route::middleware('auth:sanctum')->get('/trip-details', [UserApiController::class, 'tripDetails']);

//Validate TOKEN
Route::middleware('auth:sanctum')->get('/validate-token', function () {
    return response()->json(['message' => 'Token is valid'], 200);
});

//Get Documents by type
Route::middleware('auth:sanctum')->get('/customer/documents', [TripDocumentApiController::class, 'getDocumentsByType']);

Route::get('/dashboard/agents', [DashboardController::class, 'agents']);
Route::get('/dashboard/quotes', [DashboardController::class, 'quotes']);