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
        Schema::create('pelatihan_tenggat_upload', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tersedia_id')->nullable();     // Untuk pelatihan tersedia
            $table->unsignedBigInteger('pendaftaran_id')->nullable();  // Untuk pelatihan usulan (berbasis peserta)

            $table->year('tahun'); // Atau bisa pakai year() jika ingin field khusus tahun
            $table->enum('jenis_deadline', ['laporan_user', 'dokumen_admin']);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_deadline');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('tersedia_id')->references('id')->on('pelatihan_2_tersedias')->onDelete('cascade');
            $table->foreign('pendaftaran_id')->references('id')->on('pelatihan_3_pendaftarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_tenggat_upload');
    }
};
