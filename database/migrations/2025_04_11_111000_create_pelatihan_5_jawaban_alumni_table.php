<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelatihan_5_jawaban_alumni', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumni_id');
            $table->unsignedInteger('pertanyaan_index');
            $table->text('jawaban');
            $table->timestamps();

            $table->foreign('alumni_id')->references('id')->on('pelatihan_5_pascadiklat_alumni')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan_5_jawaban_alumni');
    }
};
