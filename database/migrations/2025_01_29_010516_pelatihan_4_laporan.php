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
        Schema::create('pelatihan_4_laporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran_id');
            $table->string('judul_laporan');
            $table->string('latar_belakang');
            $table->string('sertifikat')->nullable();
            $table->bigInteger('total_biaya');
            $table->string('laporan')->nullable();
            $table->enum('hasil_pelatihan',['draft','proses', 'revisi', 'lulus', 'tidak_lulus'])->default('draft');
            $table->timestamps();

            $table->foreign('pendaftaran_id')->references('id')->on('pelatihan_3_pendaftarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_4_laporans');
    }
};