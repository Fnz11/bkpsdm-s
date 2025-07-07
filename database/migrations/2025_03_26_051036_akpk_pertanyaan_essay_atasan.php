<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_pertanyaan_essay_atasan', function (Blueprint $table) {
            $table->id();
            $table->string('pertanyaan');
            $table->string('status');
            $table->boolean('is_visible_admin')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_pertanyaan_essay_atasan');
    }
}
;