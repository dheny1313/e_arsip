<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Berikan semua hak akses HANYA untuk super_admin
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
            // PENTING: Gunakan 'null', JANGAN 'false'!
            // Jika return null, Laravel akan melempar pengecekan ke Policy untuk role lain (seperti Staff).
        });
    }
}
