<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = PeminjamanBuku::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('book_title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('borrower_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('item_no', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('tahun') && $request->input('tahun') != 'all') {
            $query->whereYear('loan_date', $request->input('tahun'));
        }

        $peminjaman = $query->latest('loan_date')->paginate(25)->withQueryString();

        $tahunList = PeminjamanBuku::selectRaw('YEAR(loan_date) as tahun')
                                    ->distinct()
                                    ->orderBy('tahun', 'desc')
                                    ->pluck('tahun');

        return view('superadmin.data_peminjaman', compact('peminjaman', 'tahunList'));
    }
}