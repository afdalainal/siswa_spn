<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianPengamatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'penilaian_siswa_harian_id',
        'mental_spiritual_1',
        'mental_spiritual_2',
        'mental_spiritual_3',
        'mental_ideologi_1',
        'mental_ideologi_2',
        'mental_ideologi_3',
        'mental_kejuangan_1',
        'mental_kejuangan_2',
        'mental_kejuangan_3',
        'mental_kejuangan_4',
        'watak_pribadi_1',
        'watak_pribadi_2',
        'watak_pribadi_3',
        'watak_pribadi_4',
        'mental_kepemimpinan_1',
        'mental_kepemimpinan_2',
        'mental_kepemimpinan_3',
        'mental_kepemimpinan_4',
        'mental_kepemimpinan_5',
        'mental_kepemimpinan_6',
        'mental_kepemimpinan_7',
        'mental_kepemimpinan_8',
        'jumlah_indikator',
        'skor',
        'nilai_konversi',
        'pelanggaran_prestasi_minus',
        'pelanggaran_prestasi_plus',
        'nilai_akhir',
        'rank_harian',
    ];

    public function tugasSiswa()
    {
        return $this->belongsTo(\App\Models\TugasSiswa::class);
    }

}