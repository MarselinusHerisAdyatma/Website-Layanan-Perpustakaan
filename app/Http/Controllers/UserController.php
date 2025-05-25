<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function dataPengunjung()
    {
        return view('user.data_pengunjung');
    }

    public function dataPeminjaman()
    {
        return view('user.data_peminjaman');
    }
}

