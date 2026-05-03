<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::get('/register/create', [RegisterController::class, 'create'])->name('register.create');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/register/{register}/edit', [RegisterController::class, 'edit'])->name('register.edit');
    Route::put('/register/{register}', [RegisterController::class, 'update'])->name('register.update');
    Route::delete('/register/{register}', [RegisterController::class, 'destroy'])->name('register.destroy');
    Route::get('/register/export-pdf', [RegisterController::class, 'exportPdf'])->name('register.export-pdf');
});
