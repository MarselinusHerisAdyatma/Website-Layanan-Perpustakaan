<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class DatabaseConnectionHelper
{

        // Cek hanya jika belum dicek (misalnya dalam 5 menit)
        // Cek koneksi ke Inlislite via SSH
        // try {
        //     DB::connection('mysql_inlislite_ssh')->getPdo();
        //     session(['inlislite_connection' => 'mysql_inlislite_ssh']);
        // } catch (\Exception $e) {
        //     Log::warning('[INLISLITE] Gagal koneksi SSH: ' . $e->getMessage());
        //     session(['inlislite_connection' => null]); // Tidak fallback ke lokal
        // }

        // // Cek koneksi ke eLib Remote
        // try {
        //     DB::connection('sqlsrv_elib_remote')->getPdo();
        //     session(['elib_connection' => 'sqlsrv_elib_remote']);
        // } catch (\Exception $e) {
        //     Log::warning('[ELIB] Gagal koneksi Remote: ' . $e->getMessage());
        //     session(['elib_connection' => null]); // Tidak fallback ke lokal

        // }

                // Cek hanya jika belum dicek (misalnya dalam 5 menit)
        // if (!Cache::has('inlislite_checked')) {
        //     try {
        //         DB::connection('mysql_inlislite_ssh')->getPdo();
        //         session(['inlislite_connection' => 'mysql_inlislite_ssh']);
        //     } catch (\Exception $e) {
        //         try {
        //             DB::connection('mysql_inlislite_local')->getPdo();
        //             session(['inlislite_connection' => 'mysql_inlislite_local']);
        //         } catch (\Exception $ex) {
        //             session(['inlislite_connection' => null]);
        //         }
        //     }
        //     Cache::put('inlislite_checked', true, 300); // Cache selama 5 menit
        // }

        // if (!Cache::has('elib_checked')) {
        //     try {
        //         DB::connection('sqlsrv_elib_remote')->getPdo();
        //         session(['elib_connection' => 'sqlsrv_elib_remote']);
        //     } catch (\Exception $e) {
        //         try {
        //             DB::connection('sqlsrv_elib_local')->getPdo();
        //             session(['elib_connection' => 'sqlsrv_elib_local']);
        //         } catch (\Exception $ex) {
        //             session(['elib_connection' => null]);
        //         }
        //     }
        //     Cache::put('elib_checked', true, 300); // Cache 5 menit
        // }

                // Cek koneksi ke Inlislite via SSH
//     public static function setDatabaseConnections()
//     {
//         $now = now();

//         // ===== INLISLITE =====
//         if (!Session::has('inlislite_last_check') || $now->diffInSeconds(Session::get('inlislite_last_check')) >= 20) {
//     try {
//         DB::connection('mysql_inlislite_ssh')->getPdo();
//         session([
//             'inlislite_connection' => 'mysql_inlislite_ssh',
//             'inlislite_last_check' => $now,
//         ]);
//     } catch (\Exception $e) {
//         Log::warning('[INLISLITE] Gagal koneksi SSH: ' . $e->getMessage());

//         try {
//             DB::connection('mysql_inlislite_local')->getPdo();
//             session([
//                 'inlislite_connection' => 'mysql_inlislite_local',
//                 'inlislite_last_check' => $now,
//             ]);
//         } catch (\Exception $ex) {
//             Log::error('[INLISLITE] Gagal koneksi lokal juga: ' . $ex->getMessage());
//             session([
//                 'inlislite_connection' => null,
//                 'inlislite_last_check' => $now,
//             ]);
//         }
//     }
// } else {
//     // Sudah pernah dicek dalam 5 menit terakhir, tapi coba PING koneksi aktif
//     $currentConnection = Session::get('inlislite_connection');
//     try {
//         DB::connection($currentConnection)->getPdo(); // Test ping
//     } catch (\Exception $e) {
//         Log::warning("[INLISLITE] Koneksi aktif '$currentConnection' mati: " . $e->getMessage());

//         // Coba koneksi remote
//         try {
//             DB::connection('mysql_inlislite_ssh')->getPdo();
//             session([
//                 'inlislite_connection' => 'mysql_inlislite_ssh',
//                 'inlislite_last_check' => $now,
//             ]);
//         } catch (\Exception $ex) {
//             // Coba koneksi lokal sebagai fallback terakhir
//             try {
//                 DB::connection('mysql_inlislite_local')->getPdo();
//                 session([
//                     'inlislite_connection' => 'mysql_inlislite_local',
//                     'inlislite_last_check' => $now,
//                 ]);
//             } catch (\Exception $lastEx) {
//                 Log::error('[INLISLITE] Gagal semua koneksi: ' . $lastEx->getMessage());
//                 session([
//                     'inlislite_connection' => null,
//                     'inlislite_last_check' => $now,
//                 ]);
//             }
//         }
//     }
// }

//     }




    public static function setDatabaseConnections()
    {
        $now = now();

        // ===================== INLISLITE =====================
        $inlisliteConnection = Session::get('inlislite_connection');
        $inlisliteLastCheck = Session::get('inlislite_last_check');

        if (!$inlisliteLastCheck || $now->diffInSeconds($inlisliteLastCheck) >= 20) {
            self::checkInlisliteConnection($now);
        } else {
            try {
                DB::connection($inlisliteConnection)->getPdo();
            } catch (\Exception $e) {
                Log::warning("[INLISLITE] Koneksi '$inlisliteConnection' gagal: " . $e->getMessage());
                self::checkInlisliteConnection($now);
            }
        }

        // ===================== ELIB =====================
        $elibConnection = Session::get('elib_connection');
        $elibLastCheck = Session::get('elib_last_check');

        if (!$elibLastCheck || $now->diffInSeconds($elibLastCheck) >= 20) {
            self::checkElibConnection($now);
        } else {
            try {
                DB::connection($elibConnection)->getPdo();
            } catch (\Exception $e) {
                Log::warning("[ELIB] Koneksi '$elibConnection' gagal: " . $e->getMessage());
                self::checkElibConnection($now);
            }
        }
    }

    private static function checkInlisliteConnection($now)
    {
        try {
            DB::connection('mysql_inlislite_ssh')->getPdo();
            session([
                'inlislite_connection' => 'mysql_inlislite_ssh',
                'inlislite_last_check' => $now,
            ]);
        } catch (\Exception $e) {
            Log::warning('[INLISLITE] SSH gagal: ' . $e->getMessage());

            try {
                DB::connection('mysql_inlislite_local')->getPdo();
                session([
                    'inlislite_connection' => 'mysql_inlislite_local',
                    'inlislite_last_check' => $now,
                ]);
            } catch (\Exception $ex) {
                Log::error('[INLISLITE] Lokal juga gagal: ' . $ex->getMessage());
                session([
                    'inlislite_connection' => null,
                    'inlislite_last_check' => $now,
                ]);
            }
        }
    }

    private static function checkElibConnection($now)
    {
        try {
            DB::connection('sqlsrv_elib_remote')->getPdo();
            session([
                'elib_connection' => 'sqlsrv_elib_remote',
                'elib_last_check' => $now,
            ]);
        } catch (\Exception $e) {
            Log::warning('[ELIB] Remote gagal: ' . $e->getMessage());

            try {
                DB::connection('sqlsrv_elib_local')->getPdo();
                session([
                    'elib_connection' => 'sqlsrv_elib_local',
                    'elib_last_check' => $now,
                ]);
            } catch (\Exception $ex) {
                Log::error('[ELIB] Lokal juga gagal: ' . $ex->getMessage());
                session([
                    'elib_connection' => null,
                    'elib_last_check' => $now,
                ]);
            }
        }
    }
    
}
