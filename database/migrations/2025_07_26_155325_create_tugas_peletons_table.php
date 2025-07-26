<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tugas_peletons', function (Blueprint $table) {
            $table->id();
            $table->string('pengasuh_danton_id', 3)->nullable();
            $table->string('pengasuh_danki_id', 3)->nullable();
            $table->string('pengasuh_danmen_id', 3)->nullable();
            $table->string('user_id', 3)->nullable();
            $table->string('siswa_id', 3)->nullable();

            $table->string('ton_ki_yon', 10)->nullable();
            $table->string('minggu_ke', 10)->nullable();
            $table->string('hari_tgl_1', 30)->nullable();
            $table->string('hari_tgl_2', 30)->nullable();
            $table->string('hari_tgl_3', 30)->nullable();
            $table->string('hari_tgl_4', 30)->nullable();
            $table->string('hari_tgl_5', 30)->nullable();
            $table->string('hari_tgl_6', 30)->nullable();
            $table->string('hari_tgl_7', 30)->nullable();
            $table->string('tempat_1', 30)->nullable();
            $table->string('tempat_2', 30)->nullable();
            $table->string('tempat_3', 30)->nullable();
            $table->string('tempat_4', 30)->nullable();
            $table->string('tempat_5', 30)->nullable();
            $table->string('tempat_6', 30)->nullable();
            $table->string('tempat_7', 30)->nullable();
            $table->text('keterangan_isi_data')->nullable();
            
            $table->string('mental_spiritual_1', 10)->nullable();
            $table->string('mental_spiritual_2', 10)->nullable();
            $table->string('mental_spiritual_3', 10)->nullable();

            $table->string('mental_ideologi_1', 10)->nullable();
            $table->string('mental_ideologi_2', 10)->nullable();
            $table->string('mental_ideologi_3', 10)->nullable();

            $table->string('mental_kejuangan_1', 10)->nullable();
            $table->string('mental_kejuangan_2', 10)->nullable();
            $table->string('mental_kejuangan_3', 10)->nullable();
            $table->string('mental_kejuangan_4', 10)->nullable();

            $table->string('watak_pribadi_1', 10)->nullable();
            $table->string('watak_pribadi_2', 10)->nullable();
            $table->string('watak_pribadi_3', 10)->nullable();
            $table->string('watak_pribadi_4', 10)->nullable();

            $table->string('mental_kepemimpinan_1', 10)->nullable();
            $table->string('mental_kepemimpinan_2', 10)->nullable();
            $table->string('mental_kepemimpinan_3', 10)->nullable();
            $table->string('mental_kepemimpinan_4', 10)->nullable();
            $table->string('mental_kepemimpinan_5', 10)->nullable();
            $table->string('mental_kepemimpinan_6', 10)->nullable();
            $table->string('mental_kepemimpinan_7', 10)->nullable();
            $table->string('mental_kepemimpinan_8', 10)->nullable();

            $table->string('jumlah_indikator', 10)->nullable();

            $table->string('skor', 10)->nullable();

            $table->string('nilai_konversi', 10)->nullable();

            $table->string('pelanggaran_prestasi_minus', 10)->nullable();

            $table->string('pelanggaran_prestasi_plus', 10)->nullable();

            $table->string('nilai_akhir', 10)->nullable();

            $table->string('rank_harian', 10)->nullable();

            $table->string('nilai_harian_1', 10)->nullable();
            $table->string('nilai_harian_2', 10)->nullable();
            $table->string('nilai_harian_3', 10)->nullable();
            $table->string('nilai_harian_4', 10)->nullable();
            $table->string('nilai_harian_5', 10)->nullable();
            $table->string('nilai_harian_6', 10)->nullable();
            $table->string('nilai_harian_7', 10)->nullable();
            $table->text('keterangan_nilai_harian')->nullable();

            $table->string('nilai_mingguan_hari_1', 10)->nullable();
            $table->string('nilai_mingguan_hari_2', 10)->nullable();
            $table->string('nilai_mingguan_hari_3', 10)->nullable();
            $table->string('nilai_mingguan_hari_4', 10)->nullable();
            $table->string('nilai_mingguan_hari_5', 10)->nullable();
            $table->string('nilai_mingguan_hari_6', 10)->nullable();
            $table->string('nilai_mingguan_hari_7', 10)->nullable();
            $table->string('nilai_mingguan', 10)->nullable();
            $table->string('rank_mingguan', 10)->nullable();
            $table->text('keterangan_nilai_mingguan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_peletons');
    }
};