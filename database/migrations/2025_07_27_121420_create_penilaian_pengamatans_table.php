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
        Schema::create('penilaian_pengamatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_siswa_id')->constrained('tugas_siswas')->cascadeOnDelete();
            $table->double('mental_spiritual_1', 10, 2)->nullable();
            $table->double('mental_spiritual_2', 10, 2)->nullable();
            $table->double('mental_spiritual_3', 10, 2)->nullable();
            $table->double('mental_ideologi_1', 10, 2)->nullable();
            $table->double('mental_ideologi_2', 10, 2)->nullable();
            $table->double('mental_ideologi_3', 10, 2)->nullable();
            $table->double('mental_kejuangan_1', 10, 2)->nullable();
            $table->double('mental_kejuangan_2', 10, 2)->nullable();
            $table->double('mental_kejuangan_3', 10, 2)->nullable();
            $table->double('mental_kejuangan_4', 10, 2)->nullable();
            $table->double('watak_pribadi_1', 10, 2)->nullable();
            $table->double('watak_pribadi_2', 10, 2)->nullable();
            $table->double('watak_pribadi_3', 10, 2)->nullable();
            $table->double('watak_pribadi_4', 10, 2)->nullable();
            $table->double('mental_kepemimpinan_1', 10, 2)->nullable();
            $table->double('mental_kepemimpinan_2', 10, 2)->nullable();
            $table->double('mental_kepemimpinan_3', 10, 2)->nullable();
            $table->double('mental_kepemimpinan_4', 10, 2)->nullable();
            $table->double('mental_kepemimpinan_5', 10, 2)->nullable();
            $table->double('mental_kepemimpinan_6', 10, 2)->nullable();
            $table->double('mental_kepemimpinan_7', 10, 2)->nullable();
            $table->double('mental_kepemimpinan_8', 10, 2)->nullable();
            $table->double('jumlah_indikator', 10, 2)->nullable();
            $table->double('skor', 10, 2)->nullable();
            $table->double('nilai_konversi', 10, 2)->nullable();
            $table->double('pelanggaran_prestasi_minus', 10, 2)->nullable();
            $table->double('pelanggaran_prestasi_plus', 10, 2)->nullable();
            $table->double('nilai_akhir', 10, 2)->nullable();
            $table->double('rank_harian', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_pengamatans');
    }
};