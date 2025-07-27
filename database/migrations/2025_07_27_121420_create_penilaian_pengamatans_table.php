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
            $table->string('mental_spiritual_1')->nullable();
            $table->string('mental_spiritual_2')->nullable();
            $table->string('mental_spiritual_3')->nullable();
            $table->string('mental_ideologi_1')->nullable();
            $table->string('mental_ideologi_2')->nullable();
            $table->string('mental_ideologi_3')->nullable();
            $table->string('mental_kejuangan_1')->nullable();
            $table->string('mental_kejuangan_2')->nullable();
            $table->string('mental_kejuangan_3')->nullable();
            $table->string('mental_kejuangan_4')->nullable();
            $table->string('watak_pribadi_1')->nullable();
            $table->string('watak_pribadi_2')->nullable();
            $table->string('watak_pribadi_3')->nullable();
            $table->string('watak_pribadi_4')->nullable();
            $table->string('mental_kepemimpinan_1')->nullable();
            $table->string('mental_kepemimpinan_2')->nullable();
            $table->string('mental_kepemimpinan_3')->nullable();
            $table->string('mental_kepemimpinan_4')->nullable();
            $table->string('mental_kepemimpinan_5')->nullable();
            $table->string('mental_kepemimpinan_6')->nullable();
            $table->string('mental_kepemimpinan_7')->nullable();
            $table->string('mental_kepemimpinan_8')->nullable();
            $table->string('jumlah_indikator')->nullable();
            $table->string('skor')->nullable();
            $table->string('nilai_konversi')->nullable();
            $table->string('pelanggaran_prestasi_minus')->nullable();
            $table->string('pelanggaran_prestasi_plus')->nullable();
            $table->string('nilai_akhir')->nullable();
            $table->string('rank_harian')->nullable();
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