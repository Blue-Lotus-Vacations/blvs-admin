<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\TripDocumentController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CallLogController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\StatSliderImageController;
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
    Route::get('/trips/{trip}/documents', [TripDocumentController::class, 'docs'])->name('trips.docs');
    Route::get('/trips/{trip}/documents/create', [TripDocumentController::class, 'create'])->name('trips.documents.create');
    Route::post('/trips/{trip}/documents', [TripDocumentController::class, 'store'])->name('trips.documents.store');
    Route::get('/trips/{trip}/documents/{document}/edit', [TripDocumentController::class, 'edit'])->name('trips.documents.edit');
    Route::put('/trips/{trip}/documents/{document}', [TripDocumentController::class, 'update'])->name('trips.documents.update');
    Route::delete('/trips/documents/{id}', [TripDocumentController::class, 'destroy'])->name('trip.documents.destroy');
    Route::get('/trips/{trip}/documents/{document}', [TripDocumentController::class, 'show'])->name('trips.documents.show');

    Route::get('/call-logs', [CallLogController::class, 'index'])->name('call-logs.index');
    Route::resource('agents', AgentController::class)->except(['show']);
    Route::resource('quotes', QuoteController::class)->except(['show']);

    Route::resource('stat-slider-images', StatSliderImageController::class);


});

require __DIR__ . '/auth.php';
