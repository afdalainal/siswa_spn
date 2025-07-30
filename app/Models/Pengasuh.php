<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengasuh extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'jabatan',
        'pangkat_nrp',
    ];

    public function dantonTugas()
    {
        return $this->hasMany(\App\Models\TugasPeleton::class, 'pengasuh_danton_id');
    }
    public function dankiTugas()
    {
        return $this->hasMany(\App\Models\TugasPeleton::class, 'pengasuh_danki_id');
    }
    public function danmenTugas()
    {
        return $this->hasMany(\App\Models\TugasPeleton::class, 'pengasuh_danmen_id');
    }

}