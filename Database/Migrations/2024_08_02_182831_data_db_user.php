<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_db', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_companies')->nullable();
            $table->unsignedBigInteger('id_user_db')->nullable();
            $table->string('nombre')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('url_web')->nullable();
            $table->string('rating')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('mensaje_inicial_enviado')->nullable();
            $table->string('tipo_negocio_id')->nullable();
            $table->string('pais_id')->nullable();
            $table->string('ciudad_id')->nullable();
            $table->string('barrio_id')->nullable();
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
        //
    }
};
