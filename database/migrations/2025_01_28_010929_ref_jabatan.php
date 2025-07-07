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
        Schema::create('ref_jabatans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategorijabatan_id');
            $table->string('jabatan');
            $table->timestamps();

            $table->foreign('kategorijabatan_id')->references('id')->on('ref_kategorijabatans')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_jabatans');
    }
};
