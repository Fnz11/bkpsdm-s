<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_pilihan_pelatihan_solowas', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->unsignedBigInteger('id_tahun_usulan');
            $table->unsignedBigInteger('id_pengelolaan_solowasis');
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('id_tahun_usulan')->references('id')->on('akpk_tahun_usulan')->onDelete('cascade');
            $table->foreign('id_pengelolaan_solowasis')->references('id')->on('akpk_pengelolaan_solowasis')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_pilihan_pelatihan_solowasis');
    }
}
;