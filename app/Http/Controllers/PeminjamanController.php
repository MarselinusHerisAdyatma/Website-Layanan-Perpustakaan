<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $connection = session('elib_connection', 'sqlsrv_elib_local');

        // Setup Paginasi
        $page = $request->get('page', 1);
        $perPage = 25;
        $offset = ($page - 1) * $perPage;

        // Mendefinisikan logika CASE untuk Fakultas dan Jurusan agar bisa dipakai ulang
        $facultyCase = "CASE WHEN l.[Desc] = 'Karyawan' THEN 'Karyawan' WHEN CHARINDEX(' - ', l.[Desc]) > 0 THEN LEFT(l.[Desc], CHARINDEX(' - ', l.[Desc]) - 1) ELSE COALESCE(l.[Desc], '—') END";
        $jurusanCase = "CASE WHEN l.[Desc] = 'Karyawan' THEN '—' WHEN CHARINDEX(' - ', l.[Desc]) > 0 THEN SUBSTRING(l.[Desc], CHARINDEX(' - ', l.[Desc]) + 3, LEN(l.[Desc])) ELSE '—' END";

        // --- FILTER LENGKAP DIKEMBALIKAN SESUAI PERMINTAAN ---
        $where = "WHERE 1=1";
        $bindings = [];

        // Filter pencarian
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $where .= "
                AND (
                    p.FName COLLATE Latin1_General_CI_AI LIKE ? OR
                    t.TitKey COLLATE Latin1_General_CI_AI LIKE ? OR
                    c.ItemNo LIKE ?
                )
            ";
            array_push($bindings, $search, $search, $search);
        }

        // Filter tanggal kembali
        if ($request->filled('tanggal_kembali')) {
            $where .= " AND CONVERT(date, c.ChkIDate) = ?";
            $bindings[] = $request->tanggal_kembali;
        }

        // Filter tahun
        if ($request->filled('tahun') && $request->tahun !== 'all') {
            $where .= " AND YEAR(c.ChkODate) = ?";
            $bindings[] = $request->tahun;
        }

        // --- UBAH BAGIAN FILTER FAKULTAS INI ---
        if ($request->filled('fakultas')) {
            // Memaksa perbandingan menjadi case-insensitive dengan UPPER()
            $where .= " AND UPPER($facultyCase) = ?";
            // Mengubah nilai dari request menjadi huruf besar juga
            $bindings[] = strtoupper($request->fakultas);
        }

        // --- UBAH BAGIAN FILTER JURUSAN INI JUGA ---
        if ($request->filled('jurusan')) {
            // Terapkan logika yang sama untuk jurusan
            $where .= " AND UPPER($jurusanCase) = ?";
            $bindings[] = strtoupper($request->jurusan);
        }

        // Query dasar dengan semua join yang diperlukan untuk filter dan select
        $baseQueryFrom = "
            FROM [Library].[dbo].[CMCirculation] c
            INNER JOIN Library.dbo.CPatron p ON c.ID = p.ID
            INNER JOIN Library.dbo.CLevel l ON p.[Level] = l.LvlCode
            LEFT JOIN CItem i ON c.ItemNo = i.ItemNo
            LEFT JOIN ETitBib b ON i.ItemBib = b.TBBibId
            LEFT JOIN ETit t ON b.TBTitId = t.TitId
        ";

        // Query untuk menghitung total data yang sesuai filter
        $countSql = "
            SELECT COUNT(*) AS total
            FROM [Library].[dbo].[CMCirculation] c
            INNER JOIN Library.dbo.CPatron p ON c.ID = p.ID
            INNER JOIN Library.dbo.CLevel l ON p.[Level] = l.LvlCode
            $where
        ";
        $total = DB::connection($connection)->selectOne($countSql, $bindings)->total ?? 0;

        // Query utama untuk mengambil data dengan paginasi
        $sql = "
            SELECT 
                COALESCE(p.FName, '—') AS borrower_name,
                $facultyCase AS borrower_faculty,
                $jurusanCase AS borrower_jurusan,
                COALESCE(t.TitKey, '—') AS book_title,
                c.ChkODate AS loan_date,
                c.ChkIDate AS return_date,
                CASE 
                    WHEN c.ChkIDate IS NULL THEN 'Dipinjam'
                    ELSE 'Dikembalikan'
                END AS status
            $baseQueryFrom
            $where
            ORDER BY c.ChkODate DESC
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY
        ";

        $pagedDataBindings = $bindings;
        $pagedDataBindings[] = $offset;
        $pagedDataBindings[] = $perPage;

        $pagedData = collect(DB::connection($connection)->select($sql, $pagedDataBindings));

        // Membuat objek paginasi Laravel
        $peminjaman = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        // Mengambil data untuk dropdown filter dari query dasar (tanpa filter where)
        $allDataForFilter = collect(DB::connection($connection)->select("
            SELECT DISTINCT
                $facultyCase AS fakultas,
                $jurusanCase AS jurusan,
                YEAR(c.ChkODate) as tahun
            FROM [Library].[dbo].[CMCirculation] c
            INNER JOIN Library.dbo.CPatron p ON c.ID = p.ID
            INNER JOIN Library.dbo.CLevel l ON p.[Level] = l.LvlCode
        "));
        
        // Tentukan daftar kata yang tidak ingin diubah (misalnya singkatan)
        $pengecualianKapital = ['FISIP', 'FEB', 'FKIP', 'PPG', 'PDD', 'SD', 'IPA', 'IPS', 'D2', 'D3', 'D4'];

        $formatFunction = function ($item) use ($pengecualianKapital) {
            $formatted = Str::title(strtolower(trim($item)));
            foreach ($pengecualianKapital as $acronym) {
                $pattern = '/\b' . preg_quote($acronym, '/') . '\b/i';
                $formatted = preg_replace($pattern, $acronym, $formatted);
            }
            return $formatted;
        };

        // Terapkan fungsi format ke setiap baris data di tabel
        $peminjaman->getCollection()->transform(function ($data) use ($formatFunction) {
            $data->borrower_name = Str::title(strtolower($data->borrower_name)); // Nama orang tetap Title Case biasa
            $data->borrower_faculty = $formatFunction($data->borrower_faculty);
            $data->borrower_jurusan = $formatFunction($data->borrower_jurusan);
            $data->book_title = Str::title(strtolower($data->book_title)); // Judul buku juga Title Case biasa
            return $data;
        });

        // Mengambil dan memformat data untuk dropdown filter
        $allDataForFilter = collect(DB::connection($connection)->select(" SELECT DISTINCT $facultyCase AS fakultas, $jurusanCase AS jurusan, YEAR(c.ChkODate) as tahun FROM [Library].[dbo].[CMCirculation] c INNER JOIN Library.dbo.CPatron p ON c.ID = p.ID INNER JOIN Library.dbo.CLevel l ON p.[Level] = l.LvlCode "));
        
        $fakultasList = $allDataForFilter->pluck('fakultas')->filter(fn($val) => $val !== '—')->unique()->map($formatFunction)->sort()->values();
        $jurusanList  = $allDataForFilter->pluck('jurusan')->filter(fn($val) => $val !== '—')->unique()->map($formatFunction)->sort()->values();
        $tahunList    = $allDataForFilter->pluck('tahun')->unique()->sortDesc()->values();

        return view('superadmin.data_peminjaman', compact(
            'peminjaman', 'fakultasList', 'jurusanList', 'tahunList'
        ));
    }
}