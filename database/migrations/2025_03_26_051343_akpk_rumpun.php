<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akpk_rumpun', function (Blueprint $table) {
            $table->id();
            $table->string('rumpun');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('akpk_rumpun');
    }
}
;