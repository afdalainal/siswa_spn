<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = ['nama','nosis'];
    
    public function tugasSiswas()
    {
        return $this->hasMany(\App\Models\TugasSiswa::class);
    }

}