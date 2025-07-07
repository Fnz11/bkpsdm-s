<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_evaluasi_diri', function (Blueprint $table) {
            $table->id();
            // nip mereferensikan users.nip
            $table->string('nip');
            $table->unsignedBigInteger('id_jawaban');
            $table->unsignedBigInteger('id_pertanyaan');
            $table->unsignedBigInteger('id_tahun_evaluasi');
            $table->date('tanggal_pengisian');
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('id_jawaban')->references('id')->on('akpk_jawaban')->onDelete('cascade');
            $table->foreign('id_pertanyaan')->references('id')->on('akpk_pertanyaan_diri')->onDelete('cascade');
            $table->foreign('id_tahun_evaluasi')->references('id')->on('akpk_tahun_evaluasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_evaluasi_diri');
    }
}
;