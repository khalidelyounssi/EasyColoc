<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    SettlementController,
    DashboardController,
    InvitationController,
    ExpenseController,
    AdminController,
    ColocationController,
    CategoryController,
    MembershipController
};

Route::get('/', fn() => view('welcome'));

// 2. (Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //   (Colocations)
    Route::prefix('colocation')->group(function () {
        Route::get('/create', [ColocationController::class, 'create'])->name('colocation.create');
        Route::post('/', [ColocationController::class, 'store'])->name('colocation.store');
        Route::get('/{colocation}', [ColocationController::class, 'show'])->name('colocation.show');
        Route::delete('/{colocation}/member/{user}', [ColocationController::class, 'removeMember'])->name('colocation.member.remove');
    });

    // Expenses & Settlements)
    Route::post('/colocation/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::post('/colocations/{colocation}/pay/{receiver}', [SettlementController::class, 'payAllBetween'])->name('settlements.pay_all');
    Route::post('/colocations/{colocation}/categories', [CategoryController::class, 'store'])->name('categories.store');

    //  (Invitations)
    Route::post('/colocation/{colocation}/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::get('/invitations/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::get('/invitations/{token}/reject', [InvitationController::class, 'reject'])->name('invitations.reject');

    //  (Memberships)
    Route::post('/colocations/{colocation}/members/{user}/transfer', [MembershipController::class, 'transfer'])->name('members.transfer');
    Route::post('/colocations/{colocation}/leave', [MembershipController::class, 'leave'])->name('members.leave');
    Route::post('/colocations/{colocation}/members/{user}/kick', [MembershipController::class, 'kickMember'])->name('members.kick');

    //  (Profile)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::middleware(['can:admin-access'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/users/{user}/toggle-ban', [AdminController::class, 'toggleBan'])->name('admin.users.toggle-ban');
    });
});

require __DIR__.'/auth.php';