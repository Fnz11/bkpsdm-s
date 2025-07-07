<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelatihan_laporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_registrasi');
            $table->string('judul_laporan');
            $table->string('latar_belakang');
            $table->string('laporan_pelatihan');
            $table->string('sertifikat');
            $table->bigInteger('total_biaya');
            $table->enum('status', ['lulus', 'tidak lulus']);
            $table->timestamps();

            $table->foreign('id_registrasi')->references('id')->on('pelatihan_registrasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_laporans');
    }
};
