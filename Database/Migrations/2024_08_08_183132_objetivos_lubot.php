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
        Schema::create('objetivos_lubot', function (Blueprint $table) {
            $table->id();
            $table->string('objetivos');
            $table->timestamps();
        });

        if(Schema::hasTable('objetivos_lubot'))
        {
            DB::table('objetivos_lubot')->insert([
                'objetivos' => 'buscar leads'
            ]);
        }
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
