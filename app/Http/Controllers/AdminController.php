<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function dataAkun(Request $request)
    {
        $query = User::with('role');

        if ($request->role) {
            $query->where('role_id', $request->role);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(10);

        return view('admin.data_akun', compact('users')); // View khusus admin
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

