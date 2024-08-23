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
        Schema::create('consumo_creditos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_campana');
            $table->unsignedBigInteger('id_segmento');
            $table->integer('creditos_consumidos');
            $table->integer('creditos_restantes');
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
