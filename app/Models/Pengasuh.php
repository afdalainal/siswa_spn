<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengasuh extends Model
{
    use HasFactory;
    protected $fillable = [
        'jabatan',
        'nama',
        'pangkat_nrp',
    ];
}