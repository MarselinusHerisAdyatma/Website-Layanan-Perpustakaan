<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MemberGuess;
use App\Models\Profession; 
use Illuminate\Support\Facades\DB; 

class PengunjungController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::connection('mysql_xampp')
                ->table('memberguesses')
                ->select(
                    'memberguesses.Nama as NamaPengunjung',
                    'memberguesses.NoAnggota',
                    'memberguesses.CreateDate',
                    'master_fakultas.Nama as NamaFakultas',    
                    'master_jurusan.Nama as NamaJurusan',      
                    'master_program_studi.Nama as NamaProdi',  
                    'jenis_anggota.jenisanggota',
                    'status_anggota.Nama as NamaStatus'
                )
                ->leftJoin('members', 'memberguesses.NoAnggota', '=', 'members.MemberNo')
                ->leftJoin('master_fakultas', 'members.Fakultas_id', '=', 'master_fakultas.id')
                ->leftJoin('master_jurusan', 'members.Jurusan_id', '=', 'master_jurusan.id')
                ->leftJoin('master_program_studi', 'members.ProgramStudi_id', '=', 'master_program_studi.id')
                ->leftJoin('jenis_anggota', 'members.JenisAnggota_id', '=', 'jenis_anggota.id')
                ->leftJoin('status_anggota', 'members.StatusAnggota_id', '=', 'status_anggota.id');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('memberguesses.Nama', 'like', '%' . $searchTerm . '%')
                ->orWhere('memberguesses.NoAnggota', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('tahun') && $request->input('tahun') != 'all') {
            $query->whereYear('memberguesses.CreateDate', $request->input('tahun'));
        }

        $dataPengunjung = $query->latest('memberguesses.CreateDate')->paginate(20)->withQueryString();

        return view('superadmin.data_pengunjung', ['dataPengunjung' => $dataPengunjung]);
    }
}