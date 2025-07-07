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
        Schema::create('ref_namapelatihans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip');
            $table->string('kode_namapelatihan')->nullable();
            $table->string('nama_pelatihan');
            $table->unsignedBigInteger('jenispelatihan_id');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['diterima', 'ditolak', 'proses'])->default('proses');
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('jenispelatihan_id')->references('id')->on('ref_jenispelatihans')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_namapelatihans');
    }
};
