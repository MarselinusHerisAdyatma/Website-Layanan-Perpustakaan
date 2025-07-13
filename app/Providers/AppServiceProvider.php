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

        // Cek dan set koneksi database jika belum ada di session
        if (!app()->runningInConsole()) {
            if (!session()->has('inlislite_connection') || !session()->has('elib_connection')) {
                DatabaseConnectionHelper::setDatabaseConnections();
            }
        }
    }
}
