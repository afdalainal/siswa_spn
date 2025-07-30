<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TugasSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'tugas_peleton_id',
        'siswa_id',
        'status',
    ];
    public function penilaianHarian()
    {
        return $this->hasOne(\App\Models\PenilaianHarian::class);
    }

    public function penilaianMingguan()
    {
        return $this->hasOne(\App\Models\PenilaianMingguan::class);
    }

    public function penilaianPengamatan()
    {
        return $this->hasOne(\App\Models\PenilaianPengamatan::class);
    }

    public function tugasPeleton()
    {
        return $this->belongsTo(\App\Models\TugasPeleton::class);
    }

    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class);
    }

}