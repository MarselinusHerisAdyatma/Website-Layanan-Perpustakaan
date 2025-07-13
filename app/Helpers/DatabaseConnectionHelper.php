<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class DatabaseConnectionHelper
{
    public static function setDatabaseConnections()
    {
        // Cek hanya jika belum dicek (misalnya dalam 5 menit)
        if (!Cache::has('inlislite_checked')) {
            try {
                DB::connection('mysql_inlislite_ssh')->getPdo();
                session(['inlislite_connection' => 'mysql_inlislite_ssh']);
            } catch (\Exception $e) {
                try {
                    DB::connection('mysql_inlislite_local')->getPdo();
                    session(['inlislite_connection' => 'mysql_inlislite_local']);
                } catch (\Exception $ex) {
                    session(['inlislite_connection' => null]);
                }
            }
            Cache::put('inlislite_checked', true, 300); // Cache selama 5 menit
        }

        if (!Cache::has('elib_checked')) {
            try {
                DB::connection('sqlsrv_elib_remote')->getPdo();
                session(['elib_connection' => 'sqlsrv_elib_remote']);
            } catch (\Exception $e) {
                try {
                    DB::connection('sqlsrv_elib_local')->getPdo();
                    session(['elib_connection' => 'sqlsrv_elib_local']);
                } catch (\Exception $ex) {
                    session(['elib_connection' => null]);
                }
            }
            Cache::put('elib_checked', true, 300); // Cache 5 menit
        }
    }
}
