<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\RecurringExpenseController;
use App\Http\Controllers\BudgetAlertController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Auth routes (add these)
require __DIR__.'/auth.php';
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Expenses
    Route::resource('expenses', ExpenseController::class);
    Route::resource('recurring-expenses', RecurringExpenseController::class);
    
    // Budget & Goals
    Route::get('/budget-alerts', [BudgetAlertController::class, 'index'])->name('budget-alerts');
    Route::resource('savings-goals', SavingsGoalController::class);
    Route::resource('wishlist', WishListController::class);
    
    // History & Export
    Route::get('/expense-history', [ExpenseController::class, 'history'])->name('expenses.history');
    Route::get('/export-data', [DashboardController::class, 'export'])->name('export-data');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('categories', AdminCategoryController::class);
});
