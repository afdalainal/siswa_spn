<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianSiswaHarian extends Model
{
    use HasFactory;
    protected $fillable = [
    'tugas_siswa_id', 'hari_ke',
    ];

    public function tugasSiswa()
    {
        return $this->belongsTo(\App\Models\TugasSiswa::class);
    }

    public function penilaianPengamatan()
    {
        return $this->hasOne(\App\Models\PenilaianPengamatan::class);
    }

    public function penilaianHarian()
    {
        return $this->hasOne(\App\Models\PenilaianHarian::class);
    }

    public function penilaianMingguan()
    {
        return $this->hasOne(\App\Models\PenilaianMingguan::class);
    }

}