<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BukuMySQL extends Model
{
    protected $connection = 'mysql'; // Koneksi ke MySQL
    protected $table = 'buku'; // Nama tabel
    protected $fillable = ['judul', 'penulis'];
}