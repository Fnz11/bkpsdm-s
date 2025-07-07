<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_pivot', function (Blueprint $table) {
            $table->id();
            // kolom nip sebagai foreign key ke users
            $table->string('nip');
            $table->unsignedBigInteger('id_unitkerja');
            $table->unsignedBigInteger('id_golongan');
            $table->unsignedBigInteger('id_jabatan');
            $table->date('tgl_mulai');
            $table->date('tgl_akhir')->nullable();
            $table->boolean('is_unit_kerja');
            $table->boolean('is_jabatan');
            $table->boolean('is_golongan');
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('users')->onDelete('restrict');
            $table->foreign('id_unitkerja')->references('id')->on('ref_subunitkerjas')->onDelete('restrict');
            $table->foreign('id_golongan')->references('id')->on('ref_golongans')->onDelete('restrict');
            $table->foreign('id_jabatan')->references('id')->on('ref_jabatans')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_pivot');
    }
}
;