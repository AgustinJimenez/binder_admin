<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos__alumnos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('ci')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('grado_id')->unsigned();
            $table->foreign('grado_id')->references('id')->on('grados__grados');

            $table->integer('seccion_id')->unsigned()->nullable();
            $table->foreign('seccion_id')->references('id')->on('grados__seccions')->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullable();

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
        Schema::dropIfExists('alumnos__alumnos');
    }
}
