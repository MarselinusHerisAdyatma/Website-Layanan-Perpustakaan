<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\DatabaseConnectionHelper;

class CheckDatabaseConnections
{
    public function handle(Request $request, Closure $next)
    {
        // Cek hanya jika belum di-cache (5 menit)
        if (!Cache::has('db_connection_checked')) {
            DatabaseConnectionHelper::setDatabaseConnections();

            // Simpan penanda agar tidak cek ulang terus-menerus
            Cache::put('db_connection_checked', true, now()->addMinutes(2));
        }

        return $next($request);
    }
}
