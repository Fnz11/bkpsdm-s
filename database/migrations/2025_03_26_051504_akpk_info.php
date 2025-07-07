<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_info', function (Blueprint $table) {
            $table->id();
            $table->string('info_alph');
            $table->string('gambar');
            $table->string('link_info');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_info');
    }
}
;