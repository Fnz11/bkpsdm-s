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
        Schema::create('pelatihan_2_tersedias', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelatihan');
            $table->unsignedBigInteger('jenispelatihan_id');
            $table->unsignedBigInteger('metodepelatihan_id');
            $table->unsignedBigInteger('pelaksanaanpelatihan_id');
            $table->string('penyelenggara_pelatihan');
            $table->string('tempat_pelatihan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tutup_pendaftaran');
            $table->bigInteger('kuota');
            $table->bigInteger('biaya');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->enum('status_pelatihan',['draft', 'buka','tutup','selesai'])->default('draft');
            $table->timestamps();

            $table->foreign('jenispelatihan_id')->references('id')->on('ref_jenispelatihans')->onDelete('restrict');
            $table->foreign('metodepelatihan_id')->references('id')->on('ref_metodepelatihans')->onDelete('restrict');
            $table->foreign('pelaksanaanpelatihan_id')->references('id')->on('ref_pelaksanaanpelatihans')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_2_tersedias');
    }
};