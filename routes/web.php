<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\TripDocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Other admin routes
    Route::resource('users', UserController::class);
    Route::resource('trips', TripController::class);
    Route::resource('documents', DocumentController::class);
    Route::delete('/admin/trip-documents/{id}', [TripDocumentController::class, 'destroy'])->name('trip-documents.destroy');


});

require __DIR__ . '/auth.php';
