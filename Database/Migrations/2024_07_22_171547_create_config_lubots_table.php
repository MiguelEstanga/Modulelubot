<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_lubots', function (Blueprint $table) {
            $table->id();
            $table->string('estado')->default(0);
            $table->string('nombre_usuario')->nullable();
            $table->string('numero')->nullable();
            $table->unsignedBigInteger('id_companies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_lubots');
    }
};
