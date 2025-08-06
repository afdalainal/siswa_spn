<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TugasPeleton extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
    'pengasuh_danton_id',
    'pengasuh_danki_id',
    'pengasuh_danmen_id',
    'user_id',
    'ton_ki_yon',
    'minggu_ke',
    'hari_tgl_1',
    'tempat_1',
    'hari_tgl_2',
    'tempat_2',
    'hari_tgl_3',
    'tempat_3',
    'hari_tgl_4',
    'tempat_4',
    'hari_tgl_5',
    'tempat_5',
    'hari_tgl_6',
    'tempat_6',
    'hari_tgl_7',
    'tempat_7',
    'keterangan',
    'deleted_at',
    ];

    public function pengasuhDanton()
    {
        return $this->belongsTo(\App\Models\Pengasuh::class, 'pengasuh_danton_id');
    }

    public function pengasuhDanki()
    {
        return $this->belongsTo(\App\Models\Pengasuh::class, 'pengasuh_danki_id');
    }

    public function pengasuhDanmen()
    {
        return $this->belongsTo(\App\Models\Pengasuh::class, 'pengasuh_danmen_id');
    }

    public function peleton()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function tugasSiswa(){
        return $this->hasMany(\App\Models\TugasSiswa::class);
    }
    
    public function siswa()
    {
        return $this->hasManyThrough(\App\Models\Siswa::class, \App\Models\TugasSiswa::class, 'tugas_peleton_id', 'id', 'id', 'siswa_id');
    }
    
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeInactive($query)
    {
        return $query->onlyTrashed();
    }

    public function scopeGroupByWeek($query)
    {
        return $query->select('minggu_ke', \DB::raw('count(*) as total'))
            ->groupBy('minggu_ke')
            ->orderBy('minggu_ke', 'desc');
    }

    public static function activeStudentsCount()
    {
        return \DB::table('tugas_siswas')
            ->where('status', 'aktif')
            ->distinct('siswa_id')
            ->count('siswa_id');
    }
}