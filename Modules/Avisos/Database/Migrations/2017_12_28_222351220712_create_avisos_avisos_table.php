<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvisosAvisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avisos__avisos', function (Blueprint $table) 
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('titulo', 60);
            $table->date('fecha');
            $table->text('contenido');
            $table->string('firma', 30);
            $table->enum('tipo', ['general', 'por_categoria', 'por_grado', 'por_seccion']);
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
        Schema::dropIfExists('avisos__avisos');
    }
}
