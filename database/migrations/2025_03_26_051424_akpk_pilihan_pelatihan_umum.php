<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_pilihan_pelatihan_umum', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->unsignedBigInteger('id_usulan_pelatihan_umum');
            $table->unsignedBigInteger('id_tahun_usulan');
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('id_usulan_pelatihan_umum')->references('id')->on('akpk_usulan_pelatihan_umum')->onDelete('cascade');
            $table->foreign('id_tahun_usulan')->references('id')->on('akpk_tahun_usulan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_pilihan_pelatihan_umum');
    }
}
;