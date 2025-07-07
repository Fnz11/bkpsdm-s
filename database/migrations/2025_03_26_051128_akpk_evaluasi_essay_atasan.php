<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_evaluasi_essay_atasan', function (Blueprint $table) {
            $table->id();
            // Kedua kolom nip_atasan dan nip_bawahan mereferensikan users.nip
            $table->string('nip_atasan');
            $table->string('nip_bawahan');
            $table->text('jawaban');
            $table->unsignedBigInteger('id_tahun_evaluasi');
            $table->unsignedBigInteger('id_pertanyaan_essay_atasan');
            $table->timestamps();

            $table->foreign('nip_atasan')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('nip_bawahan')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('id_tahun_evaluasi')->references('id')->on('akpk_tahun_evaluasi')->onDelete('cascade');
            $table->foreign('id_pertanyaan_essay_atasan')->references('id')->on('akpk_pertanyaan_essay_atasan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_evaluasi_essay_atasan');
    }
}
;