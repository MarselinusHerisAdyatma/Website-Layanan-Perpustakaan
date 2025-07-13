<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DatabaseConnectionHelper
{
    public static function setDatabaseConnections()
    {
        // Cek koneksi ke Inlislite via SSH
        try {
            DB::connection('mysql_inlislite_ssh')->getPdo();
            session(['inlislite_connection' => 'mysql_inlislite_ssh']);
        } catch (\Exception $e) {
            Log::warning('[INLISLITE] Gagal koneksi SSH: ' . $e->getMessage());
            session(['inlislite_connection' => null]); // Tidak fallback ke lokal
        }

        // Cek koneksi ke eLib Remote
        try {
            DB::connection('sqlsrv_elib_remote')->getPdo();
            session(['elib_connection' => 'sqlsrv_elib_remote']);
        } catch (\Exception $e) {
            Log::warning('[ELIB] Gagal koneksi Remote: ' . $e->getMessage());
            session(['elib_connection' => null]); // Tidak fallback ke lokal
        }
    }
}

