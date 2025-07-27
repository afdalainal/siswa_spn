<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'nama' => 'Siswa ' . $i,
                'nosis' => str_pad($i, 4, '0', STR_PAD_LEFT), 
            ];
        }

        DB::table('siswas')->insert($data); 
    }
}