<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function dataPengunjung()
    {
        return view('admin.data_pengunjung');
    }

    public function dataPeminjaman()
    {
        return view('admin.data_peminjaman');
    }

    public function dataAkun()
    {
        return view('admin.data_akun');
    }

    public function dataKoleksi()
    {
        return view('admin.data_koleksi');
    }    
    
    public function editKoleksi()
    {
        return view('admin.edit_koleksi');
    }

}

