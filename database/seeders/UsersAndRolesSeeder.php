<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersAndRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Tambahkan roles
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Super Admin'],
            ['id' => 2, 'name' => 'Admin'],
            ['id' => 3, 'name' => 'User'],
        ]);

        // Tambahkan users
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('password123'),
                'role_id' => 1
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role_id' => 2
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'password' => Hash::make('user123'),
                'role_id' => 3
            ]
        ]);
    }
}
