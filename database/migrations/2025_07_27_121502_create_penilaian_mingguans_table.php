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
        Schema::create('penilaian_mingguans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_siswa_id')->constrained('tugas_siswas')->cascadeOnDelete();
            $table->string('nilai_mingguan_hari_1')->nullable();
            $table->string('nilai_mingguan_hari_2')->nullable();
            $table->string('nilai_mingguan_hari_3')->nullable();
            $table->string('nilai_mingguan_hari_4')->nullable();
            $table->string('nilai_mingguan_hari_5')->nullable();
            $table->string('nilai_mingguan_hari_6')->nullable();
            $table->string('nilai_mingguan_hari_7')->nullable();
            $table->string('nilai_mingguan')->nullable();
            $table->string('rank_mingguan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_mingguans');
    }
};