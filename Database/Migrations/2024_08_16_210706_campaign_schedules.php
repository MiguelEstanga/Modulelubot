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
        Schema::create('campaign_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('companie_id');
            $table->integer('frequency_number'); // número de envíos
            $table->enum('frequency_unit', ['minutes', 'hours', 'days', 'weeks']); // unidad de tiempo
            $table->string('estado')->default(1);
            
            $table->timestamp('next_run_at')->nullable(); // próxima ejecución
            $table->timestamps();
        
            //$table->foreign('campaign_id')->references('id')->on('campanas')->onDelete('cascade');
            //$table->foreign('companie_id')->references('id')->on('companies')->onDelete('cascade');
        
          
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
