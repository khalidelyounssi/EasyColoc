<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    Gate::before(function (User $user) {
        if ($user->is_banned) {
            return false; 
        }
    });

    Gate::define('admin-access', function (User $user) {
        return (bool) $user->is_admin === true; 
    });
}
}
