<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeminjamanBukuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('peminjaman_buku')->insert([
            [
                'nama_peminjam' => 'Ayu Lestari',
                'judul_buku' => 'Pemrograman Laravel',
                'tanggal_pinjam' => '2024-05-20',
                'tanggal_kembali' => '2024-05-25',
                'status' => 'Dikembalikan',
                'fakultas' => 'Fakultas Teknik',
                'prodi' => 'Informatika',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_peminjam' => 'Budi Hartono',
                'judul_buku' => 'Statistika Ekonomi',
                'tanggal_pinjam' => '2024-05-21',
                'tanggal_kembali' => null,
                'status' => 'Dipinjam',
                'fakultas' => 'Fakultas Ekonomi',
                'prodi' => 'Ekonomi Pembangunan',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
