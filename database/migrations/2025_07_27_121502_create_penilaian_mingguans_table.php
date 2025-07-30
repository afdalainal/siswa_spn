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
            $table->decimal('nilai_mingguan_hari_1', 10, 2)->nullable();
            $table->decimal('nilai_mingguan_hari_2', 10, 2)->nullable();
            $table->decimal('nilai_mingguan_hari_3', 10, 2)->nullable();
            $table->decimal('nilai_mingguan_hari_4', 10, 2)->nullable();
            $table->decimal('nilai_mingguan_hari_5', 10, 2)->nullable();
            $table->decimal('nilai_mingguan_hari_6', 10, 2)->nullable();
            $table->decimal('nilai_mingguan_hari_7', 10, 2)->nullable();
            $table->decimal('nilai_mingguan', 10, 2)->nullable();
            $table->decimal('rank_mingguan', 10, 2)->nullable();
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