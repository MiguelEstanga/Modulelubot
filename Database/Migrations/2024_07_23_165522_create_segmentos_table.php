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
        Schema::create('segmentos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_de_negocio');
            $table->string('barrio');
            $table->string('pais');
            $table->string('ciudad');
            $table->integer('cantidad');
            
            $table->integer('cantidad_consumida')->default(0);
            $table->integer('estaod')->default(1);
            $table->unsignedBigInteger('id_campanas')->nullable();
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
        Schema::dropIfExists('segmentos');
    }
};
