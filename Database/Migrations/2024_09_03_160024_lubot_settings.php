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
        Schema::create('lubot_settings', function (Blueprint $table) {
            if(!Schema::hasTable('lubot_settings'))
            {
                $table->id();
                $table->unsignedBigInteger('id_companie');
                $table->string('LUBOT_MASTER_API');
                $table->string('LUBOT_MASTER');
                $table->string('NGROK_LUBOT_WEBHOOK');
                $table->string('BEARER_LUBOT_MASTER');
            }
           
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
