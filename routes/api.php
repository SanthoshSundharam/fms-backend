<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\AdminController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Farmer routes (for users)
    Route::get('/farmers', [FarmerController::class, 'index']);
    Route::post('/farmers', [FarmerController::class, 'store']);
    Route::get('/farmers/{id}', [FarmerController::class, 'show']);
    Route::post('/farmers/{id}', [FarmerController::class, 'update']); // POST for form-data with files
    Route::delete('/farmers/{id}', [FarmerController::class, 'destroy']);

    // Admin routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'getAllUsers']);
        Route::get('/farmers', [AdminController::class, 'getAllFarmers']);
        Route::get('/users/{userId}/farmers', [AdminController::class, 'getUserFarmers']);
        Route::get('/statistics', [AdminController::class, 'getStatistics']);
    });
});