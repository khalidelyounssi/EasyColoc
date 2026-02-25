<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettlementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ExpenseController;

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
    Route::post('/colocation/{colocation}/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::post('/colocation/{colocation}/invite', [InvitationController::class, 'send'])->name('invitations.send');
    Route::get('/invitations/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/colocation/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/invitations/{token}/reject', [InvitationController::class, 'reject'])->name('invitations.reject');
    Route::post('/colocations/{colocation}/pay/{receiver}', [SettlementController::class, 'payAllBetween'])->name('settlements.pay_all');
    Route::delete('/colocation/{colocation}/member/{user}', [ColocationController::class, 'removeMember'])->name('colocation.member.remove');
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
