<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
use App\Services\RdwService;

// Home route - redirect authenticated users to cars, guests to login
Route::get('/', function () {
    return auth()->check() 
        ? redirect()->route('cars.index') 
        : redirect()->route('login');
})->name('home');

// Authenticated routes for car management
Route::middleware('auth')->group(function () {
    Route::post('/cars/check-kenteken', [CarController::class, 'checkKenteken'])->name('cars.checkKenteken');
    Route::resource('cars', CarController::class);
});

// Test route to fetch vehicle data by license plate
Route::get('/test-rdw/{kenteken}', function (string $kenteken) {
    $vehicle = RdwService::getByPlate($kenteken);
    
    if ($vehicle) {
        return response()->json([
            'success' => true,
            'data' => $vehicle
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Kenteken niet gevonden'
    ], 404);
});
