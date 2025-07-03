<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBuku;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Koleksi;

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

    public function dataPeminjaman()
    {
        return view('superadmin.data_peminjaman');
    }

    public function dataKoleksi()
    {
        $koleksi = Koleksi::first();
        return view('superadmin.data_koleksi', compact('koleksi'));
    }

    public function editKoleksi()
    {
        $koleksi = Koleksi::first();
        return view('superadmin.edit_koleksi', compact('koleksi'));
    }

    public function updateKoleksi(Request $request)
    {
        $validated = $request->validate([
            'buku' => 'required|integer',
            'jurnal' => 'required|integer',
            'karya_ilmiah' => 'required|integer',
            'anggota_aktif' => 'nullable|integer',
            'ebook_ejournal' => 'nullable|integer',
            'total_koleksi' => 'required|integer',
        ]);

        $koleksi = Koleksi::first();

        if ($koleksi) {
            $koleksi->update($validated);
        } else {
            Koleksi::create($validated);
        }

        return redirect()->route('superadmin.data_koleksi')->with('success', 'Data koleksi berhasil diperbarui.');
    }

}

