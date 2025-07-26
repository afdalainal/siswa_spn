<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TugasPeleton extends Model
{
    use HasFactory;
    protected $fillable = [
        'pengasuh_danton_id',
        'pengasuh_danki_id',
        'pengasuh_danmen_id',
        'user_id',
        'siswa_id',

        'ton_ki_yon',
        'minggu_ke',
        'hari_tgl_1',
        'hari_tgl_2',
        'hari_tgl_3',
        'hari_tgl_4',
        'hari_tgl_5',
        'hari_tgl_6',
        'hari_tgl_7',
        'tempat_1',
        'tempat_2',
        'tempat_3',
        'tempat_4',
        'tempat_5',
        'tempat_6',
        'tempat_7',
        'keterangan_isi_data',
        
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

        'nilai_harian_1',
        'nilai_harian_2',
        'nilai_harian_3',
        'nilai_harian_4',
        'nilai_harian_5',
        'nilai_harian_6',
        'nilai_harian_7',
        'keterangan_nilai_harian',

        'nilai_mingguan_hari_1',
        'nilai_mingguan_hari_2',
        'nilai_mingguan_hari_3',
        'nilai_mingguan_hari_4',
        'nilai_mingguan_hari_5',
        'nilai_mingguan_hari_6',
        'nilai_mingguan_hari_7',
        'nilai_mingguan',
        'rank_mingguan',
        'keterangan_nilai_mingguan',
    ];
}