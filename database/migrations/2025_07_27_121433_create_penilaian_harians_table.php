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
        Schema::create('penilaian_harians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_siswa_id')->constrained('tugas_siswas')->cascadeOnDelete();
            $table->double('nilai_harian_1', 10, 2)->nullable();
            $table->double('nilai_harian_2', 10, 2)->nullable();
            $table->double('nilai_harian_3', 10, 2)->nullable();
            $table->double('nilai_harian_4', 10, 2)->nullable();
            $table->double('nilai_harian_5', 10, 2)->nullable();
            $table->double('nilai_harian_6', 10, 2)->nullable();
            $table->double('nilai_harian_7', 10, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_harians');
    }
};