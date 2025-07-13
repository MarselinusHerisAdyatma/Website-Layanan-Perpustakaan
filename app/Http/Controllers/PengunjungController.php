<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MemberGuess;
use App\Models\Profession; 
use Carbon\Carbon;

class PengunjungController extends Controller
{
    public function index(Request $request)
    {
        
        // $inlisliteConnection = session('inlislite_connection', 'mysql_inlislite_local');
        $inlisliteConnection = session('mysql_inlislite_ssh');

        $query = DB::connection($inlisliteConnection)
            ->table('memberguesses as mg')
            ->select(
                'mg.Nama as NamaPengunjung',
                'mg.NoAnggota',
                'mg.CreateDate as WaktuKunjungan',
                DB::raw("IFNULL(mf.Nama, 'Tidak diketahui') as NamaFakultas"),
                DB::raw("IFNULL(mj.Nama, 'Tidak diketahui') as NamaJurusan"),
                DB::raw("IFNULL(mp.Nama, 'Tidak diketahui') as NamaProdi"),
                DB::raw("IFNULL(ja.jenisanggota, '-') as JenisAnggota"),
                DB::raw("IFNULL(sa.Nama, '-') as StatusAnggota"),
                DB::raw("CASE WHEN mg.NoAnggota IS NULL OR m.MemberNo IS NULL THEN 'Non Anggota' ELSE 'Anggota' END as TipePengunjung")
            )
            ->leftJoin('members as m', 'mg.NoAnggota', '=', 'm.MemberNo')
            ->leftJoin('master_fakultas as mf', 'm.Fakultas_id', '=', 'mf.id')
            ->leftJoin('master_jurusan as mj', 'm.Jurusan_id', '=', 'mj.id')
            ->leftJoin('master_program_studi as mp', 'm.ProgramStudi_id', '=', 'mp.id')
            ->leftJoin('jenis_anggota as ja', 'm.JenisAnggota_id', '=', 'ja.id')
            ->leftJoin('status_anggota as sa', 'm.StatusAnggota_id', '=', 'sa.id');

        // Search Nama atau NoAnggota
        // Filter
        if ($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('mg.Nama', 'like', $search)
                  ->orWhere('mg.NoAnggota', 'like', $search);
            });
        }

        // Filter Tahun
        if ($request->filled('tahun') && $request->tahun !== 'all') {
            $query->whereYear('mg.CreateDate', $request->tahun);
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('mg.CreateDate', $request->bulan);
        }

        // Filter Hari
        if ($request->filled('hari')) {
            $query->whereDate('mg.CreateDate', $request->hari);
        }

        // Filter Anggota / Non
        if ($request->filled('tipe')) {
            $request->tipe == 'anggota'
                ? $query->whereNotNull('m.MemberNo')
                : $query->whereNull('m.MemberNo');
        }
        
        // Filter Fakultas
        if ($request->filled('fakultas')) {
            $query->where('mf.Nama', $request->fakultas);
        }

        // Filter Jurusan
        if ($request->filled('jurusan')) {
            $query->where('mj.Nama', $request->jurusan);
        }

        // Filter Prodi
        if ($request->filled('prodi')) {
            $query->where('mp.Nama', $request->prodi);
        }

        $totalPengunjung = (clone $query)->count();
        $dataPengunjung = $query->latest('mg.CreateDate')->paginate(20)->withQueryString();

        // Tentukan daftar kata yang tidak ingin diubah (misalnya singkatan)
        $pengecualianKapital = ['FISIP', 'FEB', 'FKIP', 'PDD', 'PSDKU', 'ABG', 'SD', 'IPA', 'IPS', 'PGSD', 'PPG', 'PPKN', 'MIPA', 'D2', 'D3', 'D4'];

        // Fungsi pemformatan yang bisa dipakai ulang
        $formatFunction = function ($item) use ($pengecualianKapital) {
            $formatted = Str::title(strtolower(trim($item)));
            foreach ($pengecualianKapital as $acronym) {
                $pattern = '/\b' . preg_quote($acronym, '/') . '\b/i';
                $formatted = preg_replace($pattern, $acronym, $formatted);
            }
            return $formatted;
        };

        // Terapkan fungsi format ke setiap baris data yang akan ditampilkan
        $dataPengunjung->getCollection()->transform(function ($pengunjung) use ($formatFunction) {
            $pengunjung->NamaFakultas = $formatFunction($pengunjung->NamaFakultas);
            $pengunjung->NamaProdi = $formatFunction($pengunjung->NamaProdi);
            $pengunjung->NamaJurusan = $formatFunction($pengunjung->NamaJurusan);
            // Kolom lain bisa ditambahkan di sini jika perlu
            
            return $pengunjung;
        });

        $fakultasList = DB::connection($inlisliteConnection)->table('master_fakultas')->pluck('Nama')
            ->map($formatFunction)->unique()->sort()->values();

        $jurusanList = DB::connection($inlisliteConnection)->table('master_jurusan')->pluck('Nama')
            ->map($formatFunction)->unique()->sort()->values();
            
        $prodiList = DB::connection($inlisliteConnection)->table('master_program_studi')->pluck('Nama')
            ->map($formatFunction)->unique()->sort()->values();

        // DITAMBAHKAN: Membuat daftar tahun menjadi dinamis
        $tahunList = DB::connection($inlisliteConnection)->table('memberguesses')
            ->selectRaw('DISTINCT YEAR(CreateDate) as tahun')
            ->whereNotNull('CreateDate')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // DITAMBAHKAN: Membuat daftar bulan dalam Bahasa Indonesia
        Carbon::setLocale('id');
        $bulanList = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanList[str_pad($i, 2, '0', STR_PAD_LEFT)] = Carbon::create()->month($i)->translatedFormat('F');
        }

        return view('superadmin.data_pengunjung', compact(
            'dataPengunjung',
            'totalPengunjung',
            'fakultasList',
            'jurusanList',
            'prodiList',
            'tahunList',
            'bulanList'  
        ));
    }
}