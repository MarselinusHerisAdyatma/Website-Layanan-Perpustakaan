<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_buku';

    protected $fillable = [
        'nama_peminjam',
        'nim',
        'fakultas',
        'prodi',
        'judul_buku',
        'tanggal_pinjam',
    ];
}
