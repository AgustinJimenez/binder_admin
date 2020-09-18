<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosHorarioExamensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios__examenes', function (Blueprint $table) 
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->integer('seccion_id')->unsigned();
            $table->foreign('seccion_id')->references('id')->on('grados__seccions');

            $table->date('fecha');
            $table->string('materia', 60);
            $table->text('contenido')->nullable();

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
        Schema::dropIfExists('horarios__examenes');
    }
}
