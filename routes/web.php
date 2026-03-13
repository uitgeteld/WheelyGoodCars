<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('cars', [CarController::class, 'index'])->name('cars.index');

Route::middleware('auth')->group(function () {
    Route::get('/cars/my', [CarController::class, 'myListings'])->name('cars.myListings');
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');    
    Route::delete('/cars/{id}', [CarController::class, 'destroy'])->name('cars.destroy');
    Route::post('/cars/{id}/status', [CarController::class, 'status'])->name('cars.status');
});

Route::get('cars/{car}', [CarController::class, 'show'])->name('cars.show');
