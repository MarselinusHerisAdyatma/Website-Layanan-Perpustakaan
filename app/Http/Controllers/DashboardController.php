<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\PeminjamanBuku;
use App\Models\Visitor;
use App\Models\Profession;
use App\Models\Koleksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // $inlisliteConnection = session('mysql_inlislite_local');
        // $elibConnection = session('sqlsrv_elib_local');

        $inlisliteConnection = session('mysql_inlislite_ssh');
        $elibConnection = session('sqlsrv_elib_remote');

        // $inlisliteConnection = session('inlislite_connection', 'mysql_inlislite_local');
        // $elibConnection = session('elib_connection', 'sqlsrv_elib_local');

        $filter = $request->get('filter', 'fakultas');
        $selectedYear = $request->get('tahun', 'all');
        $selectedMonth = $request->get('bulan', 'all');

        // ------------------- PENGUNJUNG (KODE ASLI ANDA) -------------------
        try {
            $query = DB::connection($inlisliteConnection)
                ->table('memberguesses as mg')
                ->leftJoin('members as m', 'mg.NoAnggota', '=', 'm.MemberNo')
                ->leftJoin('master_fakultas as mf', 'm.Fakultas_id', '=', 'mf.id')
                ->leftJoin('master_jurusan as mj', 'm.Jurusan_id', '=', 'mj.id')
                ->leftJoin('master_program_studi as mp', 'm.ProgramStudi_id', '=', 'mp.id');

            if ($selectedYear !== 'all') {
                $query->whereYear('mg.CreateDate', $selectedYear);
            }
            if ($selectedMonth !== 'all') {
                $query->whereMonth('mg.CreateDate', $selectedMonth);
            }

            $totalPengunjung = $query->count();

            $topPengunjung = (clone $query)
                ->selectRaw("
                    CASE 
                        WHEN ? = 'fakultas' THEN IFNULL(mf.Nama, 'Tidak diketahui')
                        WHEN ? = 'prodi' THEN IFNULL(mp.Nama, 'Tidak diketahui')
                        ELSE 'Tidak diketahui'
                    END as kategori", [$filter, $filter])
                ->selectRaw("COUNT(*) as total")
                ->groupBy('kategori')
                ->orderByDesc('total')
                ->limit(5)
                ->pluck('total', 'kategori')
                ->toArray();

            $pengunjungTerbanyak = (object) collect($topPengunjung)->map(fn($val, $key) => [
                'kategori' => Str::title($key),
                'jumlah' => $val
            ])->first();

            $pengunjungPerTahun = DB::connection($inlisliteConnection)
                ->table('memberguesses')
                ->selectRaw('YEAR(CreateDate) as tahun, COUNT(*) as jumlah')
                ->groupBy('tahun')
                ->orderBy('tahun')
                ->pluck('jumlah', 'tahun')
                ->toArray();
        } catch (\Exception $e) {
            $totalPengunjung = 0;
            $topPengunjung = [];
            $pengunjungTerbanyak = null;
            $pengunjungPerTahun = [];
        }

        // ------------------- PEMINJAMAN (LOGIKA BARU) -------------------
        try {
            $baseQueryFrom = "
                FROM [Library].[dbo].[CMCirculation] c
                INNER JOIN Library.dbo.CPatron p ON c.ID = p.ID
                INNER JOIN Library.dbo.CLevel l ON p.[Level] = l.LvlCode
            ";
            $facultyCase = "CASE WHEN l.[Desc] = 'Karyawan' THEN 'Karyawan' WHEN CHARINDEX(' - ', l.[Desc]) > 0 THEN LEFT(l.[Desc], CHARINDEX(' - ', l.[Desc]) - 1) ELSE COALESCE(l.[Desc], '—') END";
            $where = "WHERE 1=1";
            $bindings = [];

            if ($selectedYear !== 'all') {
                $where .= " AND YEAR(c.ChkODate) = ?";
                $bindings[] = $selectedYear;
            }
            if ($selectedMonth !== 'all') {
                $where .= " AND MONTH(c.ChkODate) = ?";
                $bindings[] = $selectedMonth;
            }

            $countSql = "SELECT COUNT(*) as total $baseQueryFrom $where";
            $totalPeminjam = DB::connection($elibConnection)->selectOne($countSql, $bindings)->total ?? 0;

            $topFakultasSql = "
                SELECT TOP 5 $facultyCase as kategori, COUNT(*) as total
                $baseQueryFrom $where
                GROUP BY $facultyCase
                ORDER BY total DESC
            ";
            $topPeminjam = collect(DB::connection($elibConnection)->select($topFakultasSql, $bindings))
                ->pluck('total', 'kategori')->toArray();

            $peminjamTerbanyak = (object) collect($topPeminjam)->map(fn($val, $key) => [
                'borrower_faculty' => Str::title($key),
                'jumlah' => $val
            ])->first();

            $peminjamPerTahun = DB::connection($elibConnection)
                ->table('CMCirculation')
                ->selectRaw('YEAR(ChkODate) as tahun, COUNT(*) as jumlah')
                ->groupBy(DB::raw('YEAR(ChkODate)'))
                ->orderBy(DB::raw('YEAR(ChkODate)'))
                ->pluck('jumlah', 'tahun')->toArray();
        } catch (\Exception $e) {
            $totalPeminjam = 0;
            $topPeminjam = [];
            $peminjamTerbanyak = null;
            $peminjamPerTahun = [];
        }

        $tahunList = DB::connection($elibConnection)
            ->table('CMCirculation')
            ->selectRaw('DISTINCT YEAR(ChkODate) as tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        $bulanList = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
        ];
        
        $namaKategoriFilter = ($filter === 'prodi') ? 'Program Studi' : 'Fakultas';

        return view('dashboard.index', compact(
            'filter', 'selectedYear', 'selectedMonth', 'tahunList', 'bulanList',
            'totalPengunjung', 'totalPeminjam',
            'topPengunjung', 'pengunjungTerbanyak', 'pengunjungPerTahun',
            'topPeminjam', 'peminjamTerbanyak', 'peminjamPerTahun',
            'namaKategoriFilter'
        ));
    }

    // public function setKoneksi(Request $request)
    // {
    //     Session::put('inlislite_connection', $request->inlislite_connection);
    //     Session::put('elib_connection', $request->elib_connection);
    //     return back()->with('success', 'Koneksi berhasil diubah.');
    // }
}