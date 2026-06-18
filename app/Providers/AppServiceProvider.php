<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Baris ini yang tadi ketinggalan

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
        // Memaksa HTTPS jika diakses lewat Ngrok
        if (str_contains(request()->getHost(), 'ngrok')) {
            URL::forceScheme('https');
        }
    }
}