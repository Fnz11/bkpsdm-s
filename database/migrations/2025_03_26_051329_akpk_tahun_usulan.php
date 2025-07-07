<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_tahun_usulan', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_buka');
            $table->string('tanggal_tutup');
            $table->string('tahun');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_tahun_usulan');
    }
}
;