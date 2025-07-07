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
        Schema::create('ref_unitkerjas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_unitkerja');
            $table->string('unitkerja');
            $table->timestamps();
        });

        Schema::create('ref_subunitkerjas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unitkerja_id');
            $table->string('sub_unitkerja');
            $table->string('singkatan');
            $table->timestamps();

            $table->foreign('unitkerja_id')->references('id')->on('ref_unitkerjas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_unitkerjas');
        Schema::dropIfExists('ref_subunitkerjas');
    }
};
