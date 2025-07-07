<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_evaluasi_essay_diri', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->text('jawaban');
            $table->unsignedBigInteger('id_tahun_evaluasi');
            $table->unsignedBigInteger('id_pertanyaan_essay_diri');
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('id_tahun_evaluasi')->references('id')->on('akpk_tahun_evaluasi')->onDelete('cascade');
            $table->foreign('id_pertanyaan_essay_diri')->references('id')->on('akpk_pertanyaan_essay_diri')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluasi_essay_diri');
    }
}
;