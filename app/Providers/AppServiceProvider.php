<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Role tunggal
        Blade::if('role', function ($role) {
            return Auth::check() && Auth::user()->role === $role;
        });

        // Multi role
        Blade::if('anyrole', function (...$roles) {
            return Auth::check() && in_array(Auth::user()->role, $roles);
        });
    }
}
