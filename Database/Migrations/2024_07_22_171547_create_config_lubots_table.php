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
            $table->string('code_ws')->nullable();
            $table->string('code_rc')->nullable();
            $table->unsignedBigInteger('id_codigo')->nullable();
            $table->integer('estado_ws')->nullable()->default(null);
            $table->integer('estado_rc')->nullable()->default(null);
            
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
