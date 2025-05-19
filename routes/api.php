<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerApiController;

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->get('/customer', [CustomerApiController::class, 'show']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
