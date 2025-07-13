<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
use App\Models\PeminjamanBuku;
use App\Models\Visitor;
use App\Models\Profession;
use App\Models\Koleksi;

class SuperAdminController extends Controller
{
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

