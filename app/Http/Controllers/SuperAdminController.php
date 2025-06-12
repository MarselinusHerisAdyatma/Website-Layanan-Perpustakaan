<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBuku;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'fakultas');
        $selectedYear = $request->get('tahun', 'all');

        $tahunList = DB::table('peminjaman_buku')
            ->selectRaw('YEAR(tanggal_pinjam) as tahun')
            ->distinct()
            ->orderBy('tahun', 'asc')
            ->pluck('tahun');

        // Grafik bar: total peminjam per tahun
        $peminjamChart = DB::table('peminjaman_buku')
            ->selectRaw('YEAR(tanggal_pinjam) as tahun, COUNT(*) as total')
            ->when($selectedYear !== 'all', fn($q) => $q->whereYear('tanggal_pinjam', $selectedYear))
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->pluck('total', 'tahun');

        // Grafik line: jumlah peminjam per bulan (kalau tahun dipilih saja)
        $peminjamPerBulan = DB::table('peminjaman_buku')
            ->selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->when($selectedYear !== 'all', fn($q) => $q->whereYear('tanggal_pinjam', $selectedYear))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Total peminjam (bisa filter per tahun atau semua)
        $totalPeminjam = DB::table('peminjaman_buku')
            ->when($selectedYear !== 'all', fn($q) => $q->whereYear('tanggal_pinjam', $selectedYear))
            ->count();

        // Peminjam terbanyak
        $peminjamTerbanyak = DB::table('peminjaman_buku')
            ->select($filter, DB::raw('COUNT(*) as jumlah'))
            ->when($selectedYear !== 'all', fn($q) => $q->whereYear('tanggal_pinjam', $selectedYear))
            ->groupBy($filter)
            ->orderByDesc('jumlah')
            ->first();

        return view('superadmin.index', compact(
            'filter', 'selectedYear', 'tahunList',
            'peminjamChart', 'peminjamPerBulan',
            'totalPeminjam', 'peminjamTerbanyak'
        ));
    }

    public function dataPengunjung()
    {
        return view('superadmin.data_pengunjung');
    }

    public function dataPeminjaman(Request $request)
    {
        $tahun = $request->input('tahun');

        $peminjaman = PeminjamanBuku::when($tahun, function ($query, $tahun) {
            return $query->whereYear('tanggal_pinjam', $tahun);
        })->orderBy('tanggal_pinjam', 'desc')->paginate(10);

        $tahunList = PeminjamanBuku::selectRaw('YEAR(tanggal_pinjam) as tahun')->distinct()->pluck('tahun');

        return view('superadmin.data_peminjaman', compact('peminjaman', 'tahunList'));
    }

    public function dataKoleksi()
    {
        return view('superadmin.data_koleksi');
    }    
    
    public function editKoleksi()
    {
        return view('superadmin.edit_koleksi');
    }

}

