<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSQLServerSeeder extends Seeder
{
    public function run()
    {
        DB::connection('sqlsrv')->table('buku')->insert([
            ['id' => 1, 'judul' => 'Introduction to SQL Server', 'penulis' => 'Alice Cooper'],
            ['id' => 2, 'judul' => 'Advanced Database Design', 'penulis' => 'David Johnson'],
            ['id' => 3, 'judul' => 'Big Data Analysis', 'penulis' => 'Emma White'],
        ]);
    }
}
