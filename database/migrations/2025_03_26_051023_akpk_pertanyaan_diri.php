<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_pertanyaan_diri', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi');
            $table->unsignedBigInteger('id_kategori');
            $table->integer('standar_min');
            $table->unsignedBigInteger('id_jabatan');
            $table->string('status');
            $table->boolean('is_visible_admin')->default(true);
            $table->timestamps();

            $table->foreign('id_kategori')->references('id')->on('akpk_kategori')->onDelete('cascade');
            $table->foreign('id_jabatan')->references('id')->on('ref_jabatan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_pertanyaan_diri');
    }
}
;