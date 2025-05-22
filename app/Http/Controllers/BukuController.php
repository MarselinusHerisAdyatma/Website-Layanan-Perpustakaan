<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BukuMySQL;
use App\Models\BukuSQLSRV;

class BukuController extends Controller
{
    public function index()
    {
        $bukuMySQL = BukuMySQL::all();
        // $bukuSQLSRV = BukuSQLSRV::all();

        // return view('buku.index', compact('bukuMySQL', 'bukuSQLSRV'));
        return view('buku.index', compact('bukuMySQL'));
    }
}