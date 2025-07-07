<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_komentar', function (Blueprint $table) {
            $table->id();
            $table->integer('skor');
            $table->text('komentar');
            $table->string('jabatan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_komentar');
    }
}
;