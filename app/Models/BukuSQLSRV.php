<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BukuSQLSRV extends Model
{
    protected $connection = 'sqlsrv'; // Koneksi ke SQL Server
    protected $table = 'buku'; // Nama tabel
    protected $fillable = ['judul', 'penulis'];
}