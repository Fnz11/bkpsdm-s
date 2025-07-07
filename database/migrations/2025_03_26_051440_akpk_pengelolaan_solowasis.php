<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_pengelolaan_solowasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tahun_usulan');
            $table->string('nama_pelatihan');
            $table->timestamps();

            $table->foreign('id_tahun_usulan')->references('id')->on('akpk_tahun_usulan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_pengelolaan_solowasis');
    }
}
;