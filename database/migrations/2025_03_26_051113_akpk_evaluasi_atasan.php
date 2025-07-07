<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_evaluasi_atasan', function (Blueprint $table) {
            $table->id();
            // Kedua kolom nip_atasan dan nip_bawahan mereferensikan users.nip
            $table->string('nip_atasan');
            $table->string('nip_bawahan');
            $table->unsignedBigInteger('id_jawaban');
            $table->unsignedBigInteger('id_pertanyaan');
            $table->unsignedBigInteger('id_tahun_evaluasi');
            $table->date('tanggal_pengisian');
            $table->timestamps();

            $table->foreign('nip_atasan')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('nip_bawahan')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('id_jawaban')->references('id')->on('akpk_jawaban')->onDelete('cascade');
            $table->foreign('id_pertanyaan')->references('id')->on('akpk_pertanyaan_atasan')->onDelete('cascade');
            $table->foreign('id_tahun_evaluasi')->references('id')->on('akpk_tahun_evaluasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_evaluasi_atasan');
    }
}
;