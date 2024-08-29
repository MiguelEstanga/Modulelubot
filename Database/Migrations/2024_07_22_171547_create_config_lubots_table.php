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
            $table->string('code_ws')->nullable();
            $table->integer('code_rc')->nullable();
            $table->integer('estado_ws')->nullable()->default(null);
            $table->string('estado_rc')->nullable()->default(null);
            $table->string('numero')->nullable();
            $table->unsignedBigInteger('id_codigo')->nullable();
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
