<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsablesResponsablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsables__responsables', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('ci')->nullable();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('telefono')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->enum('estado', ['aprobado', 'pendiente', 'rechazado'])->default('aprobado');
            $table->enum('tipo_encargado', ['papa', 'mama', 'tutor'])->default('tutor');
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
        Schema::dropIfExists('responsables__responsables');
    }
}
