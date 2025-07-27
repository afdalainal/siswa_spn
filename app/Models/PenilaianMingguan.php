<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianMingguan extends Model
{
    use HasFactory;
    protected $fillable = [
        'tugas_siswa_id',
        'nilai_mingguan_hari_1',
        'nilai_mingguan_hari_2',
        'nilai_mingguan_hari_3',
        'nilai_mingguan_hari_4',
        'nilai_mingguan_hari_5',
        'nilai_mingguan_hari_6',
        'nilai_mingguan_hari_7',
        'nilai_mingguan',
        'rank_mingguan',
        'keterangan',
    ];
}