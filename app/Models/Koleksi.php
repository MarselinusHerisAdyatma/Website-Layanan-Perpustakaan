<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    protected $table = 'koleksi_perpustakaan';

    protected $fillable = [
        'buku',
        'jurnal',
        'karya_ilmiah',
        'anggota_aktif',
        'ebook_ejournal',
        'total_koleksi',
    ];
}