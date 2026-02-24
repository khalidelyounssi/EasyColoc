<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\ColocationController;

Route::middleware(['auth'])->group(function () {
    Route::get('/colocation/create', [ColocationController::class, 'create'])->name('colocation.create');
    
    Route::post('/colocation', [ColocationController::class, 'store'])->name('colocation.store');
    Route::get('/colocation/{colocation}', [ColocationController::class, 'show'])->name('colocation.show');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
