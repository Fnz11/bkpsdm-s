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
        Schema::create('pelatihan_3_dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('admin_nip');
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->string('keterangan')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->timestamps();

            $table->foreign('admin_nip')->references('nip')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_3_dokumens');
    }
};