<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_usulan_pelatihan_umum', function (Blueprint $table) {
            $table->id();
            // nip sebagai foreign key ke users
            $table->string('nip');
            $table->unsignedBigInteger('id_tahun_usulan');
            $table->string('nama_pelatihan');
            $table->string('status');
            // penanggungjawab mereferensikan users.nip
            $table->string('penanggungjawab');
            $table->string('file_pdf');
            $table->string('tanggal_aktif');
            $table->string('keterangan');
            $table->unsignedBigInteger('id_rumpun');
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('id_tahun_usulan')->references('id')->on('akpk_tahun_usulan')->onDelete('cascade');
            $table->foreign('penanggungjawab')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('id_rumpun')->references('id')->on('akpk_rumpun')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_usulan_pelatihan_umum');
    }
}
;