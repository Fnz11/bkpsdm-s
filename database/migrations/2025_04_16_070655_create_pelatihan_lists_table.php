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
        Schema::create('pelatihan_lists', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama_pelatihan');
            $table->string('tempat_pelatihan');
            $table->string('tanggal_pelaksanaan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('penyelenggara');
            $table->text('deskripsi');
            $table->unsignedBigInteger('pelaksanaan_pelatihan_id');
            $table->unsignedBigInteger('metode_pelatihan_id');
            $table->unsignedBigInteger('jenis_pelatihan_id');
            $table->string('gambar');
            $table->enum('status', ['open', 'closed'])->default('closed');
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('pelaksanaan_pelatihan_id')->references('id')->on('ref_pelaksanaanpelatihans')->onDelete('cascade');
            $table->foreign('metode_pelatihan_id')->references('id')->on('ref_metodepelatihans')->onDelete('cascade');
            $table->foreign('jenis_pelatihan_id')->references('id')->on('ref_jenispelatihans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_lists');
    }
};
