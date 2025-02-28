<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

Route::middleware(['auth'])->group(function () {
    // Home routes
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/transfer/quick', [HomeController::class, 'quickTransfer'])->name('transfer.quick');
    
    // Profile route (we'll implement this later)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
