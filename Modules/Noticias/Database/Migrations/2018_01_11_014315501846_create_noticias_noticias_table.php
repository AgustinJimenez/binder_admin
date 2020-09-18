<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticiasNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias__noticias', function (Blueprint $table) 
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('titulo', 60);
            $table->date('fecha');
            $table->text('contenido');

            $table->integer('colegio_id')->unsigned();
            $table->foreign('colegio_id')->references('id')->on('colegios__colegios');

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
        Schema::dropIfExists('noticias__noticias');
    }
}
