<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use App\Helpers\DatabaseConnectionHelper;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();

        // Jalankan pengecekan koneksi DB dinamis (cek + fallback)
        if (!app()->runningInConsole()) {
            DatabaseConnectionHelper::setDatabaseConnections();
        }
    }
}
