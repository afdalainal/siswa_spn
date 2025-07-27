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
            $table->foreignId('pengasuh_danton_id')->nullable()->constrained('pengasuhs');
            $table->foreignId('pengasuh_danki_id')->nullable()->constrained('pengasuhs');
            $table->foreignId('pengasuh_danmen_id')->nullable()->constrained('pengasuhs');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('ton_ki_yon')->nullable();
            $table->string('minggu_ke')->nullable();
            $table->string('hari_tgl_1')->nullable();
            $table->string('tempat_1')->nullable();
            $table->string('hari_tgl_2')->nullable();
            $table->string('tempat_2')->nullable();
            $table->string('hari_tgl_3')->nullable();
            $table->string('tempat_3')->nullable();
            $table->string('hari_tgl_4')->nullable();
            $table->string('tempat_4')->nullable();
            $table->string('hari_tgl_5')->nullable();
            $table->string('tempat_5')->nullable();
            $table->string('hari_tgl_6')->nullable();
            $table->string('tempat_6')->nullable();
            $table->string('hari_tgl_7')->nullable();
            $table->string('tempat_7')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
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