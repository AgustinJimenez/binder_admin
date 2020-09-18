<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosHorarioClasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('horarios__clases', function (Blueprint $table) 
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('seccion_id')->unsigned();
            $table->foreign('seccion_id')->references('id')->on('grados__seccions');

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
        Schema::dropIfExists('horarios__clases');
    }
}
