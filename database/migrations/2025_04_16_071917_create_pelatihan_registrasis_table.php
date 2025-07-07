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
        Schema::create('pelatihan_registrasis', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->unsignedBigInteger('id_pelatihan');
            $table->date('tanggal_daftar');
            $table->bigInteger('biaya_pelatihan');
            $table->bigInteger('biaya_akomodasi');
            $table->bigInteger('biaya_hotel');
            $table->bigInteger('uang_harian');
            $table->string('file_penawaran');
            $table->string('file_usulan');
            $table->enum('status', ['tersimpan', 'terkirim', 'diterima', 'ditolak']);
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('id_pelatihan')->references('id')->on('pelatihan_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_registrasis');
    }
};
