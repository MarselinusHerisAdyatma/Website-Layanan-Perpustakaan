<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Koleksi;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $inlisliteConnection = session('inlislite_connection', 'mysql_inlislite_local');
        $elibConnection = session('elib_connection', 'sqlsrv_elib_local');
        // Mendapatkan bulan dan tahun saat ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // --- MENGHITUNG PENGUNJUNG ---
        try {
            // Pengunjung HARI INI
            $totalPengunjungHariIni = DB::connection($inlisliteConnection)
                ->table('memberguesses')
                ->whereDate('CreateDate', Carbon::today())
                ->count();
            
            // Pengunjung BULAN INI
            $totalPengunjungBulanIni = DB::connection($inlisliteConnection)
                ->table('memberguesses')
                ->whereYear('CreateDate', Carbon::now()->year)
                ->whereMonth('CreateDate', Carbon::now()->month)
                ->count();
        } catch (\Exception $e) {
            $totalPengunjungHariIni = 0;
            $totalPengunjungBulanIni = 0;
        }

        // --- MENGHITUNG PEMINJAM ---
        try {
            $baseQuery = DB::connection($elibConnection)
                ->table('CMCirculation as c')
                ->join('CPatron as p', 'c.ID', '=', 'p.ID')
                ->join('CLevel as l', 'p.Level', '=', 'l.LvlCode');

            // Peminjam HARI INI
            $totalPeminjamHariIni = (clone $baseQuery)
                ->whereDate('c.ChkODate', Carbon::today())
                ->count();

            // Peminjam BULAN INI
            $totalPeminjamBulanIni = (clone $baseQuery)
                ->whereYear('c.ChkODate', Carbon::now()->year)
                ->whereMonth('c.ChkODate', Carbon::now()->month)
                ->count();
        } catch (\Exception $e) {
            $totalPeminjamHariIni = 0;
            $totalPeminjamBulanIni = 0;
        }

        // Mengambil data koleksi
        $koleksi = Koleksi::first();

        // Mengirim semua data ke view
        return view('landing_page', compact(
            'totalPengunjungHariIni',
            'totalPengunjungBulanIni',
            'totalPeminjamHariIni',
            'totalPeminjamBulanIni',
            'koleksi'
        ));
    }
}
