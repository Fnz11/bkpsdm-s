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
        Schema::create('pelatihan_3_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pendaftaran')->unique();
            $table->string('user_nip');
            $table->unsignedBigInteger('dokumen_id')->nullable();
            $table->unsignedBigInteger('tersedia_id')->nullable();
            $table->unsignedBigInteger('usulan_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_pendaftaran')->default(now());
            $table->enum('status_verifikasi', ['tersimpan', 'tercetak', 'terkirim', 'diterima', 'ditolak'])->default('tersimpan');
            $table->enum('status_peserta', ['calon_peserta', 'peserta', 'alumni'])->default('calon_peserta');
            $table->timestamps();

            $table->foreign('user_nip')->references('nip')->on('users')->onDelete('cascade');
            $table->foreign('dokumen_id')->references('id')->on('pelatihan_3_dokumens')->onDelete('cascade');
            $table->foreign('tersedia_id')->references('id')->on('pelatihan_2_tersedias')->onDelete('cascade');
            $table->foreign('usulan_id')->references('id')->on('pelatihan_2_usulans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_3_pendaftarans');
    }
};
