<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'superadmin',
        ]);

        User::create([
            'name' => 'Peleton User',
            'email' => 'peleton@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'peleton',
        ]);
    }
}