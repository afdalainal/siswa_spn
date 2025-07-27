<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengasuhSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengasuhs')->insert([
            [
                'nama' => 'Letda Andi',
                'jabatan' => 'pengasuh danton',
                'pangkat_nrp' => 'Letda 123456',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Lettu Budi',
                'jabatan' => 'pengasuh danki',
                'pangkat_nrp' => 'Lettu 234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kapten Charlie',
                'jabatan' => 'pengasuh danmen',
                'pangkat_nrp' => 'Kapten 345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}