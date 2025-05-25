<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('superadmin.index');
    }

    public function dataPengunjung()
    {
        return view('superadmin.data_pengunjung');
    }

    public function dataPeminjaman()
    {
        return view('superadmin.data_peminjaman');
    }

    public function dataAkun()
    {
        return view('superadmin.data_akun');
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

