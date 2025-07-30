<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianHarian extends Model
{
    use HasFactory;
    protected $fillable = [
        'tugas_siswa_id',
        'nilai_harian_1',
        'nilai_harian_2',
        'nilai_harian_3',
        'nilai_harian_4',
        'nilai_harian_5',
        'nilai_harian_6',
        'nilai_harian_7',
        'keterangan',
    ];
    public function tugasSiswa()
    {
        return $this->belongsTo(\App\Models\TugasSiswa::class);
    }

}