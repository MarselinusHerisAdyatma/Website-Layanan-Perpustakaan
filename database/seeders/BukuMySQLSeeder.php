<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuMySQLSeeder extends Seeder
{
    public function run()
    {
        DB::connection('mysql')->table('buku')->insert([
            ['id' => 1, 'judul' => 'Laravel for Beginners', 'penulis' => 'John Doe'],
            ['id' => 2, 'judul' => 'Mastering PHP', 'penulis' => 'Jane Smith'],
            ['id' => 3, 'judul' => 'Database Optimization', 'penulis' => 'Robert Brown'],
        ]);
    }
}

