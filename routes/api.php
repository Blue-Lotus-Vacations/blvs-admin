<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->get('/user', [UserApiController::class, 'show']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
