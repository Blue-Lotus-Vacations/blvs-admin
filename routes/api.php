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

// Stat Dashboard 
Route::get('/dashboard/agents', [DashboardController::class, 'agentStats']);
Route::get('/dashboard/quotes', [DashboardController::class, 'quotes']);
Route::get('/dashboard/images', [DashboardController::class, 'statSliderImages']);
Route::get('/dashboard/top-rankers', [DashboardController::class, 'topRankers']);
Route::get('/dashboard/conversion-ratio', [DashboardController::class, 'conversionRatio']);

// routes/api.php
Route::get('/dashboard/top-folders', [DashboardController::class, 'topFolders']);
Route::get('/dashboard/total-profit', [DashboardController::class, 'topProfitLeaders']);//jan to july top 5 profits 