<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DatabaseConnectionHelper
{
    public static function setDatabaseConnections()
    {
        // Cek koneksi ke Inlislite Online
        try {
            DB::connection('mysql_inlislite_online')->getPdo();
            session(['inlislite_connection' => 'mysql_inlislite_online']);
        } catch (\Exception $e) {
            Log::warning('[INLISLITE] Gagal koneksi ONLINE: ' . $e->getMessage());
            session(['inlislite_connection' => 'mysql_inlislite_local']);
        }

        // Cek koneksi ke eLib Online
        try {
            DB::connection('sqlsrv_elib_online')->getPdo();
            session(['elib_connection' => 'sqlsrv_elib_online']);
        } catch (\Exception $e) {
            Log::warning('[ELIB] Gagal koneksi ONLINE: ' . $e->getMessage());
            session(['elib_connection' => 'sqlsrv_elib_local']);
        }
    }
    
}
